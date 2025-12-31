<?php

namespace Vanni\ConfigManager\Validation;

use Vanni\ConfigManager\Models\ConfigProject;
use Vanni\ConfigManager\Models\ConfigEnvironment;

class ConfigValidator
{
    /**
     * Valida il progetto prima dell'export.
     *
     * @return array{errors: string[], warnings: string[]}
     */
    public function validate(
        ConfigProject $project,
        ConfigEnvironment $environment
    ): array {
        $errors = [];
        $warnings = [];

        $variables = $project->variables()->with([
            'values' => function ($query) use ($environment) {
                $query->where('config_environment_id', $environment->id);
            }
        ])->get();

        foreach ($variables as $variable) {
            $value = optional($variable->values->first())->value;

            // ❌ ERRORE BLOCCANTE se required mancante
            if ($variable->required && ($value === null || $value === '')) {
                $errors[] = sprintf(
                    'Missing required variable "%s" for environment "%s".',
                    $variable->key,
                    $environment->name
                );
            }
        }

        /**
         * 🛡️ Validazione VARIABILI CRITICHE
         * Queste devono SEMPRE esistere ed avere un valore.
         */
        $critical = [
            'APP_KEY',
            'APP_ENV',
            'DB_CONNECTION',
            'DB_HOST',
            'DB_PORT',
            'DB_DATABASE',
            'DB_USERNAME',
            'DB_PASSWORD',
        ];

        foreach ($critical as $key) {
            $variable = $project->variables()
                ->where('key', $key)
                ->first();

            if (! $variable) {
                $errors[] = "Critical variable \"{$key}\" is missing from project configuration.";
                continue;
            }

            $value = $variable->values()
                ->where('config_environment_id', $environment->id)
                ->value('value');

            if ($value === null || $value === '') {
                $errors[] = sprintf(
                    'Critical variable "%s" has no value for environment "%s".',
                    $key,
                    $environment->name
                );
            }
        }

        // ⚠️ WARNING DI PRODUZIONE
        if ($environment->is_production) {
            $warnings[] = 'You are exporting a PRODUCTION environment.';
        }

        return [
            'errors' => $errors,
            'warnings' => $warnings,
        ];
    }
}
