<?php

\Deployer\set('bulk_tasks', [
    [
        'prefix' => 'magento',
        'binary' => './bin/magento',
        'binary_required' => true,
        'command' => 'list --raw',
    ],
]);

require('./vendor/sourcebroker/deployer-bulk-tasks/src/BulkTasks.php');