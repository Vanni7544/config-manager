<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Backup retention
    |--------------------------------------------------------------------------
    |
    | This defines how many .env backups are kept.
    | When the limit is exceeded, the oldest backups are deleted.
    |
    */

    'backup_retention' => env('CONFIG_MANAGER_BACKUP_RETENTION', 10),

];
