<?php

namespace Vanni\ConfigManager\Contracts;

use Vanni\ConfigManager\Models\ConfigProject;
use Vanni\ConfigManager\Models\ConfigEnvironment;

interface EnvExporterContract
{
    /**
     * Genera il contenuto di un file .env
     * per un progetto e un ambiente.
     */
    public function generate(
        ConfigProject $project,
        ConfigEnvironment $environment
    ): string;

    /**
     * Scrive il file di configurazione su filesystem.
     */
    public function writeToFile(string $content): void;
}
