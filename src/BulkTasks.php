<?php

call_user_func(function () {
    \Deployer\option('bulk-task-option', null, 4, 'Option for bulk tasks');
    if (\Deployer\get('bulk_tasks', false) !== false) {
        foreach (\Deployer\get('bulk_tasks') as $bulkTask) {
            $bulkTaskBinary = $bulkTask['binary'];
            if (file_exists($bulkTaskBinary)) {
                $commands = [];
                // We looking for available commands on local instance because "dep list" does not yet have target stage.
                // This assume of course that local and remote instances have the same version of commands which should
                // be true for most cases.
                exec($bulkTaskBinary . ' ' . $bulkTask['command'], $commands, $exitStatus);
                if ($exitStatus !== 0) {
                    if ($bulkTask['command_fallback'] !== null) {
                        $commands = trim($bulkTask['command_fallback']);
                    } else {
                        throw new \Exception('Command: "' . $bulkTaskBinary . ' ' . $bulkTask['command'] . '"' .
                            ' executed with error.');
                    }
                }
                foreach ($commands as $commandRawLine) {
                    preg_match('/^([a-zA-Z:]+)/', $commandRawLine, $match);
                    if (is_array($match) && isset($match[1])) {
                        $taskKey = trim($match[1]);
                        if (!empty($bulkTask['command_filter']) && !preg_match($bulkTask['command_filter'], $taskKey)) {
                            continue;
                        }
                        $taskDescription = trim(substr($commandRawLine, strlen($taskKey)));
                        if (preg_match('/^[a-zA-Z:]+$/', $taskKey)) {
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
                        } else {
                            throw new \Exception('Task key: "' . $taskKey . '" is not valid name for task.' .
                                "\n" . 'Raw command line parsed was: "' . $commandRawLine . '"' . "\n" .
                                "\n" . 'Pregmatch result is: ' . print_r($match, true));
                        }
                    } else {
                        throw new \Exception('Parsing raw command line: "' . $commandRawLine . '"' . "\n" .
                            'Pregmatch result is: ' . print_r($match, true));
                    }
                } // foreach $commands

            } else {
                if ($bulkTask['binary_required']) {
                    throw new \Exception('Binary required but not found: "' . $bulkTaskBinary . '"');
                }
            }
        }
    }
});

