<?php

namespace Vanni\ConfigManager\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;


class EnvApplier
{
    protected string $envPath;
    protected string $backupDir;

    public function __construct()
    {
        $this->envPath = base_path('.env');
        $this->backupDir = base_path('.env.backups');
    }

    /**
     * Applica il nuovo .env con backup automatico.
     */
    public function apply(string $newEnvContent): string
    {
        if (! File::exists($this->envPath)) {
            throw new \RuntimeException('.env file not found.');
        }

        $this->ensureBackupDir();

        // 🔒 Acquire lock (max 10 seconds wait)
        $lock = Cache::lock('config-manager:env-apply', 10);

        if (! $lock->get()) {
            throw new \RuntimeException(
                'Another .env apply process is already running. Please try again.'
            );
        }

        try {
            // Backup current .env
            $backupPath = $this->backup();

            // Write new .env atomically
            $tmpPath = $this->envPath . '.tmp';

            File::put($tmpPath, $newEnvContent);
            File::move($tmpPath, $this->envPath);

            // Enforce retention
            $this->enforceBackupRetention();

            return $backupPath;
        } finally {
            // 🔓 Always release the lock
            optional($lock)->release();
        }
    }


    /**
     * Ripristina l’ultimo backup.
     */
    public function rollback(): void
    {
        $latestBackup = collect(glob($this->backupDir . '/.env.backup.*'))
            ->map(fn ($path) => new \SplFileInfo($path))
            ->sortByDesc(fn ($file) => $file->getCTime())
            ->first();

        if (! $latestBackup) {
            throw new \RuntimeException(
                'No backups available. Make sure you have executed an --apply command before rolling back, ' .
                'and that you are running rollback in the same environment (Sail or host).'
            );
        }

        File::copy($latestBackup->getPathname(), $this->envPath);
    }

    /**
     * Crea un backup timestamped.
     */
    protected function backup(): string
    {
        $timestamp = now()->format('Ymd_His');
        $backupPath = "{$this->backupDir}/.env.backup.{$timestamp}";

        File::copy($this->envPath, $backupPath);

        return $backupPath;
    }

    /**
     * Garantisce che la cartella backup esista.
     */
    protected function ensureBackupDir(): void
    {
        if (! File::exists($this->backupDir)) {
            File::makeDirectory($this->backupDir, 0755, true);
        }
    }

    /**
     * Mantiene solo gli ultimi N backup.
     */
    protected function enforceBackupRetention(): void
    {
        $retention = (int) config('config-manager.backup_retention', 10);

        // Se retention è <= 0 non facciamo nulla
        if ($retention <= 0) {
            return;
        }

        $files = collect(glob($this->backupDir . '/.env.backup.*'))
            ->map(fn ($path) => new \SplFileInfo($path))
            ->sortByDesc(fn ($file) => $file->getCTime())
            ->values();

        if ($files->count() <= $retention) {
            return;
        }

        // Cancella i più vecchi tenendo solo i primi N
        $files
            ->slice($retention)
            ->each(function (\SplFileInfo $file) {
                @unlink($file->getPathname());
            });
    }
}
