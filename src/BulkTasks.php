<?php

call_user_func(function () {
    \Deployer\option('bulk-task-option', null, 4, 'Option for bulk tasks');
    if (\Deployer\get('bulk_tasks', false) !== false) {
        foreach (\Deployer\get('bulk_tasks') as $bulkTask) {
            $bulkTaskBinary = !empty($bulkTask['binary']) ? $bulkTask['binary'] : null;
            if ($bulkTaskBinary && file_exists($bulkTaskBinary)) {
                $commands = [];
                // We looking for available commands on local instance because "dep list" does not yet have target stage.
                // This assume of course that local and remote instances have the same version of commands which should
                // be true for most cases.
                if (!empty($bulkTask['command'])) {
                    exec($bulkTaskBinary . ' ' . $bulkTask['command'], $commands, $exitStatus);
                    if ($exitStatus !== 0) {
                        if (isset($bulkTask['command_fallback'])) {
                            $commands = array_map(function ($item) {
                                return trim($item);
                            }, preg_split('/\R/', trim($bulkTask['command_fallback'])));
                        } else {
                            throw new \Exception('Command: "' . $bulkTaskBinary . ' ' . $bulkTask['command'] . '"' .
                                ' executed with error.');
                        }
                    }
                    if (!empty($bulkTask['command_required'])) {
                        $commands = array_merge($commands, array_map(function ($item) {
                            return trim($item);
                        }, preg_split('/\R/', trim($bulkTask['command_required']))));
                    }
                    foreach ($commands as $commandRawLine) {
                        preg_match('/^([a-z0-9:]+)/', $commandRawLine, $match);
                        if (is_array($match) && isset($match[1])) {
                            $taskKey = trim($match[1]);
                            if (!empty($bulkTask['command_filter'])
                                && !preg_match($bulkTask['command_filter'], $taskKey)) {
                                continue;
                            }
                            $taskDescription = trim(substr($commandRawLine, strlen($taskKey)));
                            \Deployer\task($bulkTask['prefix'] . ':' . $taskKey,
                                function () use ($taskKey, $bulkTaskBinary) {
                                    $option = '';
                                    if (\Deployer\input()->hasOption('bulk-task-option')) {
                                        $option = \Deployer\input()->getOption('bulk-task-option');
                                    }
                                    if (\Deployer\get('bin/' . pathinfo($bulkTaskBinary, PATHINFO_FILENAME),
                                            false) !== false) {
                                        $bulkTaskBinary = '{{bin/' . pathinfo($bulkTaskBinary,
                                                PATHINFO_FILENAME) . '}}';
                                    }
                                    $activeDir = \Deployer\test('[ -e {{deploy_path}}/release ]') ?
                                        \Deployer\get('deploy_path') . '/release' :
                                        \Deployer\get('deploy_path') . '/current';
                                    \Deployer\run('cd ' . $activeDir . ' && 
                                    {{bin/php}} ' . $bulkTaskBinary . ' ' . $taskKey . ' ' . $option);
                                })->desc($taskDescription);
                        }
                    }
                } else {
                    throw new \Exception('Command not set for the binary.');
                }
            } else {
                if ($bulkTask['binary_required']) {
                    throw new \Exception('Binary required but not found: "' . $bulkTaskBinary . '"');
                }
            }
        }
    }
});

