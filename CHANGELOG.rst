
Changelog
---------

2.0.0
~~~~~

1) [BREAKING] Remove commands_required as they are too close to commands_fallback.
2) [FEATURE] Make command exec independent of binary execution. This way we can create deployer tasks without executing
   binary.

1.2.2
~~~~~

1) [TASK] Check if values in array are set before using them.
2) [TASK] Extend binary files exception text to be more informative.

1.2.1
~~~~~

1) [TASK] Docs.

1.2.0
~~~~~

1) [FEATURE] Add support for commands_required / add docs.
2) [TASK] Extend pregmatch for task name to digits also.

1.1.2
~~~~~

1) [TASK] Remove task name checks and exceptions because there is fallback
   now for error output and php warnings were going as tasks.

1.1.1
~~~~~

1) [BUGFIX] Fix fallback command not exploded/trimmed.

1.1.0
~~~~~

1) [TASK] Implement command fallback if execution of binary fails for some reason.
2) [TASK] Implement command filtering for cases when we need only selected commands to be deployer tasks.
3) [DOCS] Docs update.

1.0.0
~~~~~

1) [TASK] Init version of Deployer Bulk Task.
2) [DOCS] Docs update.