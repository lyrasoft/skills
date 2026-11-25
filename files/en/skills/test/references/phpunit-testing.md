# PHPUnit environment, temp files, and filesystem

## Reading or setting env values in tests

- Read with `Windwalker\Utilities\Env::get()`; do not read `$_SERVER`/`$_ENV` directly.
- Write with `Env::set()` (syncs `$_SERVER`, `$_ENV`, `putenv()`); if unavailable, set `$_SERVER` (and `$_ENV` if relevant).
- A host app's `.env` can leak values (e.g. `MAIL_ENABLED=1`) and pollute default-expecting tests.
- Save the original with `Env::get()` in `#[Before]`; restore it in `#[After]`.

## Temporary files

- Use the project `tmp/` (`WINDWALKER_TEMP`, default `WINDWALKER_ROOT . '/tmp'`), not `sys_get_temp_dir()`/`tempnam()`; never the project root.
- Path: `WINDWALKER_TEMP . '/ww-test-' . uniqid()`.
- Create in `#[Before]`; remove in `#[After]` (or a shutdown function).

## Filesystem tests

- Real filesystem: use `Windwalker\Filesystem\Test\FilesystemTestTrait` (`packages/filesystem/test/`).
  - `assertPathEquals()`: compares with `Path::clean()`.
  - `assertRealpathEquals()`: compares with `Path::normalize()` (does not call `realpath()`).
  - Do not compare raw path strings when separators are irrelevant.
- No real filesystem or OS behavior needed: use vfsStream (`org\bovigo\vfs\vfsStream`, `vfs://`); reuse `AbstractVfsTestCase` (`packages/filesystem/test/`).
- API lacks stream wrapper support or native semantics needed: use real temp files and clean up.
