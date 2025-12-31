<?php

namespace Vanni\ConfigManager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ConfigProject extends Model
{
    /**
     * La tabella associata al model.
     */
    protected $table = 'config_projects';

    /**
     * Attributi assegnabili in massa.
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Un progetto ha molti ambienti.
     */
    public function environments(): HasMany
    {
        return $this->hasMany(ConfigEnvironment::class, 'config_project_id');
    }

    /**
     * Un progetto ha molte variabili.
     */
    public function variables(): HasMany
    {
        return $this->hasMany(ConfigVariable::class, 'config_project_id');
    }
}
