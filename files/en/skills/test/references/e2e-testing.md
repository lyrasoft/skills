# E2E / Playwright testing guide

## Purpose

Use a real browser to verify frontend behavior that requires interaction (table toolbar buttons, dialogs, forms) against a local development server.

For Windwalker flows that require login (credential file, session cookie, session bridge, etc.), see `e2e-windwalker-auth.md`.

## Choosing a tool

- **Default: single smoke test or one-off verification**: first use Chrome DevTools MCP to drive the browser directly; if Chrome DevTools MCP is not available, fall back to driving the browser directly with Playwright. No script file is needed.
- **Write a script and use Playwright only when**:
  - The user explicitly asks to keep a long-term repeatable test command, or
  - The user wants the same behavior repeated for the rest of the conversation (for example, a long session where new instructions keep arriving)

## Prerequisites

- When using Playwright, run tests with `playwright-core`. It does not download browsers; launch an installed Chrome with `channel: 'chrome'` (or Edge with `channel: 'msedge'`). If the package is missing, notify the user.
- When using a Playwright script, put scripts and logs in `tmp/e2e/` (ignored by Git). Run from the repository root: `node tmp/e2e/<script>.mjs`.
- If a PHP dev server or JS dev server must be started, or JS must be built (`yarn build`) before testing, search the instructions for the project's procedure.

## Workflow

- **Direct control (default)**: use Chrome DevTools MCP to open the page, interact with elements, and check results; no `tmp/e2e/` files are needed.
- **Playwright script (long-term repeatable tests only)**:
  - **Start the PHP server on an explicit port** and record its PID:

   ```bash
   php windwalker server:start php:main --host localhost --port 8089 \
     > tmp/e2e/server.out 2> tmp/e2e/server.err &
   echo $!                                                        # server PID
   curl -s -o /dev/null -w "%{http_code}" http://localhost:8089/  # expect 200
   ```

   The returned PID may belong to a launcher rather than the process actually listening. Use `Get-NetTCPConnection -LocalPort 8089 -State Listen` to find the real PID, and stop only that process (`Stop-Process -Id <PID>`).
- **Prepare login (if needed)**: see `e2e-windwalker-auth.md`.
- **Copy and adjust the script**: copy `../assets` to `tmp/e2e/`, adjust it for the project and test scenario, then run it.
- **Cleanup**: delete the `.mjs` script and logs, and stop only the server you started. Keep `.env.agent.local`.

## Example script (Playwright script path only)

`../assets` logs in (using a Session ID or credentials from `.env.agent.local`), opens a backend list page, clicks the delete toolbar button without selecting any items, and outputs the native dialog content. **This is only an example: adjust the URL, selectors, and assertions for the project and test scenario.**
