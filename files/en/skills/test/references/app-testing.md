# Windwalker app testing

A host app's tests are an integration environment from the start: config and providers are already set up, so there is no `phpunit.app.xml` and no provider recomposition.

## Automatic reset (all tiers)

- At the start of each TestCase: migrations are refreshed.
- Before each test method: tables are truncated.
- Tests do not create tables or clean data themselves, and must not rely on data left by a previous test.

## Tiers

Pick the lowest tier that covers the behavior. Tiers 1 and 2 may both use a DB.

| Tier | Description | Use for | DB |
| --- | --- | --- | --- |
| 1 Unit | mocked service dependencies | one class + test doubles | as needed |
| 2 Light integration | real app services and DI | request context, middleware, routing, controller dispatch | as needed |
| 3 DB: memory | SQLite `:memory:` | plain SQL/ORM logic, no dialect features | memory |
| 4 DB: real | real DBMS | dialect behavior, migrations, seeders | real |

- Rules and traits for tiers 3 and 4: see database-testing.
- Test doubles for tier 1: see [phpunit-testing](phpunit-testing.md).

## Helpers (`src/Core/Testing/`)

- `AbstractTestApp`: base for app tests; `tests/TestApp.php` is the subclass.
- `Traits/ServiceAwareTestTrait`: one child container per test class; `make()`, `retrieve()`, `call()`; prepare `AbstractTestApp::$ctx` (or `$sharedCtx`) first; does not boot the app.
- `Traits/ControllerTestTrait`: `dispatchController()` takes a controller, input or request, and method arguments; prepare the app context first.
- `Traits/InMemoryDatabaseTestTrait`, `Traits/DatabaseTestTrait`: see database-testing.

## What to assert

| Subject | Assert | Tier |
| --- | --- | --- |
| Enums / value types | cases and mappings | 1 |
| Services / factories | return values, interactions with collaborators | 1 |
| `AppContext` request API | input, headers, method override, API detection, url vars, stage | 2 |
| Middleware | order, short-circuit, exceptions rethrown in debug | 2 |
| Routing | route matched and dispatched | 2 |
| Controller dispatch | `AppContext` injection, state restored after `dispatchWithInput()` | 2 |
| Repository / ORM | CRUD, query results | 3 / 4 |
| Migration / Seeder | schema and data | 4 |

## Request-scoped behavior

- Create a new context per test; never reuse an `AppContext` across tests.
- To prove request scope, create two contexts and assert the instances differ; app-scoped services must be the same.
- Inject the request via `createContext($request)`; do not touch globals.
- `AbstractTestApp::prepareSharedContext()` sets `$sharedCtx`/`$ctx`; `dispatchWithInput()` swaps and restores request/controller.
- The test context disables the debug profiler; set `'debug' => true` only to test debug-mode error propagation.
- Services marked `#[Isolation]` are rebuilt per context; use this to assert two contexts hold distinct instances.

## View models and controllers

- Test view models directly: build with doubles, call `prepare($appContext, $view)`, assert returned data and `HtmlFrame`/`#[ViewMetadata]` separately.
- Input-dependent view models: use a tier 2 context.
- Controllers: `dispatchController()` or `runContext($ctx, [Controller::class, 'task'])`.
- Default tasks: GET `index`, POST/PUT/PATCH `save`, DELETE `delete`.
- Do not assert full HTML in unit tests; test layouts and templates at tier 2.

## Fixtures

- Keep names, routes, and config specific to other projects out of tests.
