<?php

\Deployer\set('bulk_tasks', [
        [
            'prefix' => 'typo3',
            'binary' => './vendor/bin/typo3',
            'binary_required' => true,
            'command' => 'list --raw',
            'command_filter' => '',
            'command_fallback' => '
                autocomplete Generate shell auto complete script
                backend:lock Lock backend
                backend:lockforeditors Lock backend for editors
                backend:unlock Unlock backend
                backend:unlockforeditors Unlock backend for editors
                cache:flush Flush all caches
                cache:flushgroups Flush all caches in specified groups
                cache:flushtags Flush cache by tags
                cache:listgroups List cache groups
                cleanup:updatereferenceindex Update reference index
                configuration:remove Remove configuration option
                configuration:set Set configuration value
                configuration:show Show configuration value
                configuration:showactive Show active configuration value
                configuration:showlocal Show local configuration value
                database:export Export database to stdout
                database:import Import mysql from stdin
                database:updateschema Update database schema
                documentation:generatexsd Generate Fluid ViewHelper XSD Schema
                extension:activate Activate extension(s)
                extension:deactivate Deactivate extension(s)
                extension:dumpautoload Dump class auto-load
                extension:list List extensions that are available in the system
                extension:removeinactive Removes all extensions that are not marked as active
                extension:setup Set up extension(s)
                extension:setupactive Set up all active extensions
                frontend:request Submit frontend request
                help Help
                install:extensionsetupifpossible Setup TYPO3 with extensions if possible
                install:fixfolderstructure Fix folder structure
                install:generatepackagestates Generate PackageStates.php file
                install:setup TYPO3 Setup
                language:update Update language file for each extension
                scheduler:run Run scheduler
                upgrade:all Execute all upgrade wizards that are scheduled for execution
                upgrade:checkextensionconstraints Check TYPO3 version constraints of extensions
                upgrade:list List upgrade wizards
                upgrade:wizard Execute a single upgrade wizard
        '
        ]
    ]
);

require('./vendor/sourcebroker/deployer-bulk-tasks/src/BulkTasks.php');