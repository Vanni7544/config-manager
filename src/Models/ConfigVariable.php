<?php

namespace Vanni\ConfigManager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ConfigVariable extends Model
{
    /**
     * Tabella associata.
     */
    protected $table = 'config_variables';

    /**
     * Attributi assegnabili in massa.
     */
    protected $fillable = [
        'config_project_id',
        'key',
        'type',
        'required',
        'description',
    ];

    /**
     * La variabile appartiene a un progetto.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(ConfigProject::class, 'config_project_id');
    }

    /**
     * Una variabile ha molti valori (uno per ambiente).
     */
    public function values(): HasMany
    {
        return $this->hasMany(ConfigValue::class, 'config_variable_id');
    }
}
