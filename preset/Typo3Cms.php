<?php

\Deployer\set('bulk_tasks', [
    [
        'prefix' => 'typo3cms',
        'binary' => './vendor/bin/typo3cms',
        'binary_required' => true,
        'command' => 'help --raw',
        'command_filter' => '',
        'command_fallback' => '
                help                                                     Displays help for a command
                list                                                     Lists commands
                backend:lock                                             Lock the TYPO3 Backend
                backend:unlock                                           Unlock the TYPO3 Backend
                cleanup:deletedrecords                                   Permanently deletes all records marked as "deleted" in the database.
                cleanup:flexforms                                        Updates all database records which have a FlexForm field and the XML data does not match the chosen datastructure.
                cleanup:lostfiles                                        Looking for files in the uploads/ folder which does not have a reference in TYPO3 managed records.
                cleanup:missingfiles                                     Find all file references from records pointing to a missing (non-existing) file.
                cleanup:missingrelations                                 Find all record references pointing to a non-existing record
                cleanup:multiplereferencedfiles                          Looking for files from TYPO3 managed records which are referenced more than once
                cleanup:orphanrecords                                    Find and delete records that have lost their connection with the page tree.
                cleanup:rteimages                                        Looking up all occurrences of RTEmagic images in the database and check existence of parent and copy files on the file system plus report possibly lost RTE files.
                cleanup:versions                                         Find all versioned records and possibly cleans up invalid records in the database.
                extbase:help:help                                        The help command displays help for a given command: ./typo3/sysext/core/bin/typo3 extbase:help 
                extensionmanager:extension:dumpclassloadinginformation   This command is only needed during development. The extension manager takes care creating or updating this info properly during extension (de-)activation.
                extensionmanager:extension:install                       The extension files must be present in one of the recognised extension folder paths in TYPO3.
                extensionmanager:extension:uninstall                     The extension files must be present in one of the recognised extension folder paths in TYPO3.
                impexp:import                                            Imports a T3D / XML file with content into a page tree
                lang:language:update                                     
                referenceindex:update                                    Update the reference index of TYPO3
                scheduler:run                                            Start the TYPO3 Scheduler from the command line.
                syslog:list                                              Show entries from the sys_log database table of the last 24 hours.
        '
    ]
]);

require('./vendor/sourcebroker/deployer-bulk-tasks/src/BulkTasks.php');