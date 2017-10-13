deployer-bulk-tasks
===================

.. image:: http://img.shields.io/packagist/v/sourcebroker/deployer-bulk-tasks.svg?style=flat
   :target: https://packagist.org/packages/sourcebroker/deployer-bulk-tasks

.. image:: https://img.shields.io/badge/license-MIT-blue.svg?style=flat
   :target: https://packagist.org/packages/sourcebroker/deployer-bulk-tasks

|

.. contents:: :local:

What does it do?
----------------

This library takes cli commands of any package and makes them available as deployer tasks.

Installation
------------

1) Install package with composer:
   ::

      composer require sourcebroker/deployer-bulk-tasks

2) Take look at presets in folder vendor/sourcebroker/deployer-bulk-tasks/preset, choose yours and put
   following line in your deploy.php file, like in this example:
   ::

      require_once (__DIR__ . '/vendor/sourcebroker/deployer-bulk-tasks/preset/Magento2.php');

3) If you found the right presets then at this point you are done and you can check for new commands with "dep".

4) If you did not find preset then you can add your own config and require BulkTask.php after config like in this
   example:
   ::

      set('bulk_tasks', [
          [
              'prefix' => 'magento',
              'binary' => './bin/magento',
              'binary_required' => true,
              'command' => 'list --raw',
              'command_filter' => '',
              'command_fallback' => '
                    help                                      Displays help for a command
                    list                                      Lists commands
                    admin:user:create                         Creates an administrator
                    admin:user:unlock                         Unlock Admin Account
                    app:config:dump                           Create dump of application
                    ...
                    ...
                    ...
              '
          ],
      ]);
      require('./vendor/sourcebroker/deployer-bulk-tasks/src/BulkTasks.php');

   where the params means:

   **prefix**
     a prefix that will be put before each command from cli. For example if you have help command in Magento2
     and call it "php bin/magento help" then now you will call it "dep magento:help live".

   **binary**
     cli application binary

   **binary_required**
     if true then the php exception will be thrown if binary is not found.

   **command**
     a command that together with binary will output raw command list like "php bin/magento list --raw".

   **command_filter**
     a string to be used in preg_match to filter commands that should be deployer tasks because usually
     we do not need all commands to be available as deployer tasks. Example "/database:/".

   **command_fallback**
     a string that contains all commands with description that you want to be deployer tasks. This is a fallback when
     our local binary will fail to return list of commands for whatever reason.


Commands usage
--------------

After installation and configuration you can use all commands of application like in following example from TYPO3 preset:

::

  dep typo3cms:database:updateschema live


If you want to see the output of command then use -vvv switch. Example:

::

  dep typo3:cleanup:deletedrecords live -vvv

If you want to add some option then use "--bulk-task-option" option and put whole option inside. Example:

::

  dep typo3cms:database:updateschema live --bulk-task-option="--schema-update-types=\"*.add\""



Your presets
------------

If you have some new presets for some well known frameworks then please create a PR and I will merge it to master.


Known problems
--------------

None.


To-Do list
----------

None.

Changelog
---------

See https://github.com/sourcebroker/deployer-bulk-tasks/blob/master/CHANGELOG.rst
