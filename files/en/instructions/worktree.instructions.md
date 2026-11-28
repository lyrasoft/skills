---
applyTo: '**'
---
# Worktree mode guidance

These rules apply only when the task runs in a git worktree (worktree isolation mode).

- **Naming**: when starting a new task in worktree mode, ask the user whether they want a custom worktree / branch name before creating it. If they have no preference, derive a name from the task.
- **Commit every change**: commit directly inside the worktree after each change; do not leave uncommitted work.
- **Merging**: when the user asks to merge the worktree into the current working branch, squash all worktree commits into a single commit and write the commit message yourself from the actual changes (no need to ask).
- **Continuing**: if the user gives further instructions after a merge, keep working in the same worktree (keep committing each change) and squash-merge again only when asked.
- **Database tests**: when a task needs database tests, first check whether the working branch's environment already has a database running (local or Docker). If it does, use it directly (see [Database testing](../skills/test/references/database-testing.md)).
- **Vendor for tests**: a new worktree has no `vendor/`. After writing code, if tests need to run, first symlink the main repo's `vendor` into the worktree (`ln -s <main-repo>/vendor vendor`). If the link causes path problems that cannot be resolved effectively (or the main repo has no `vendor`), remove the link and run `composer install` instead. Do not commit `vendor/`.
- **Keep the link until the end**: if the project's pre-commit hook depends on `vendor/bin/php-cs-fixer` (see [Code style](./cs.instructions.md)), the hook silently skips formatting when it is missing. So create the `vendor` link before the first commit (even if no tests are run) and keep it for the whole session; only remove it when the whole task, including every commit and merge, is finished. If the main repo's `vendor/bin/php-cs-fixer` is missing, run `composer install` in the main repo first. Always check `git status` before committing and never stage `vendor/`.
