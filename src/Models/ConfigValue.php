<?php

namespace Vanni\ConfigManager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConfigValue extends Model
{
    /**
     * Tabella associata.
     */
    protected $table = 'config_values';

    /**
     * Attributi assegnabili in massa.
     */
    protected $fillable = [
        'config_variable_id',
        'config_environment_id',
        'value',
    ];

    /**
     * Il valore appartiene a una variabile.
     */
    public function variable(): BelongsTo
    {
        return $this->belongsTo(ConfigVariable::class, 'config_variable_id');
    }

    /**
     * Il valore appartiene a un ambiente.
     */
    public function environment(): BelongsTo
    {
        return $this->belongsTo(ConfigEnvironment::class, 'config_environment_id');
    }
}
