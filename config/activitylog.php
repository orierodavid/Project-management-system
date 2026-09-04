<?php

use Spatie\Activitylog\Models\Activity;

return [
    'enabled' => env('ACTIVITY_LOGGER_ENABLED', true),
    'delete_records_older_than_days' => 365,
    'default_log_name' => 'default',
    'database_connection' => env('DB_CONNECTION', 'mysql'),
    'table_name' => 'activity_log',
    'activity_model' => Activity::class,
    'subject_returns_soft_deleted_models' => false,
    'causer_returns_soft_deleted_models' => false,
    'changes' => [
        'enabled' => true,
        'attribute_getters' => false,
        'attribute_setters' => false,
    ],
    'submit_empty_logs' => false,
    'activity' => [
        'batch_uuid' => true,
    ],
];
