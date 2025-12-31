<?php

namespace Vanni\ConfigManager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ConfigEnvironment extends Model
{
    /**
     * Tabella associata.
     */
    protected $table = 'config_environments';

    /**
     * Attributi assegnabili in massa.
     */
    protected $fillable = [
        'config_project_id',
        'name',
        'is_production',
    ];

    /**
     * Un ambiente appartiene a un progetto.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(ConfigProject::class, 'config_project_id');
    }

    /**
     * Un ambiente ha molti valori di configurazione.
     */
    public function values(): HasMany
    {
        return $this->hasMany(ConfigValue::class, 'config_environment_id');
    }
}
