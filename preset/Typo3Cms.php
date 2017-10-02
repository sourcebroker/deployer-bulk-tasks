<?php

\Deployer\set('bulk_tasks', [
    [
        'prefix' => 'typo3cms',
        'binary' => './vendor/bin/typo3cms',
        'binary_required' => true,
        'command' => 'help --raw',
    ],
]);

require('./vendor/sourcebroker/deployer-bulk-tasks/src/BulkTasks.php');