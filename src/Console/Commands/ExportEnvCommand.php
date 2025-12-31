<?php

namespace Vanni\ConfigManager\Console\Commands;

use Illuminate\Console\Command;
use Vanni\ConfigManager\Models\ConfigProject;
use Vanni\ConfigManager\Models\ConfigEnvironment;
use Vanni\ConfigManager\Contracts\EnvExporterContract;
use Vanni\ConfigManager\Validation\ConfigValidator;
use Vanni\ConfigManager\Services\EnvApplier;




class ExportEnvCommand extends Command
{
    protected $signature = 'config-manager:export
                        {project? : ID del progetto}
                        {environment? : ID dell\'ambiente}
                        {--apply : Apply the generated .env and create a backup}
                        {--rollback : Rollback last applied .env backup}';


    protected $description = 'Generate a .env.config-manager file for a project environment';

    public function handle(): int
    {
        // 🔁 ROLLBACK: non deve toccare DB
        if ($this->option('rollback')) {
            app(EnvApplier::class)->rollback();
            $this->info('Rollback completed.');
            return self::SUCCESS;
        }

        $projectId = $this->argument('project');
        $environmentId = $this->argument('environment');

        // 🧠 fallback interattivo se non passati
        if (! $projectId) {
            $projectId = $this->ask('Enter the project ID');
        }

        if (! $environmentId) {
            $environmentId = $this->ask('Enter the environment ID');
        }

        $project = ConfigProject::find($projectId);
        $environment = ConfigEnvironment::find($environmentId);

        if (! $project) {
            $this->error("Config project [{$projectId}] not found.");
            return self::FAILURE;
        }

        if (! $environment || $environment->config_project_id !== $project->id) {
            $this->error("Environment [{$environmentId}] not found or not linked to project.");
            return self::FAILURE;
        }

        $validator = app(ConfigValidator::class);
        $result = $validator->validate($project, $environment);

        if (! empty($result['errors'])) {
            foreach ($result['errors'] as $error) {
                $this->error($error);
            }
            return self::FAILURE;
        }

        foreach ($result['warnings'] as $warning) {
            $this->warn($warning);
        }

        $exporter = app(EnvExporterContract::class);
        $content = $exporter->generate($project, $environment);
        $exporter->writeToFile($content);

        if ($this->option('apply')) {

            // 🛡️ Extra safety: confirm in production
            if (app()->environment('production')) {
                $this->warn('⚠️  WARNING: You are about to modify the PRODUCTION .env file.');

                if (! $this->confirm('Do you really want to continue?')) {
                    $this->info('Operation cancelled. No changes were made.');
                    return self::SUCCESS;
                }
            }

            $backupPath = app(EnvApplier::class)->apply($content);

            $this->warn('Previous .env backed up to:');
            $this->line("  {$backupPath}");
            $this->info('.env file updated successfully.');
        }


        $this->info('.env.config-manager generated successfully.');

        return self::SUCCESS;
    }
}
