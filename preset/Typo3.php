<?php

\Deployer\set('bulk_tasks', [
    [
        'prefix' => 'typo3',
        'binary' => './vendor/bin/typo3',
        'binary_required' => true,
        'command' => 'list --raw',
    ],
]);

require('./vendor/sourcebroker/deployer-bulk-tasks/src/BulkTasks.php');