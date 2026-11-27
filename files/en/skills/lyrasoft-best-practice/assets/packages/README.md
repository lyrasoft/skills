<!-- agent: This file is the LYRASOFT package README template. Before use, decide the package type by following references/packages/lyrasoft-package-readme.md, remove sections that do not apply, and remove all agent comments and any unreplaced {{ }} placeholders. -->
<!-- agent: Write prose in the language of the existing README, or English by default. Keep code, commands, and config keys in English. -->

# LYRASOFT {{Package Title}} Package

<!-- agent: Title format is always "LYRASOFT {{Package Title}} Package". Libraries and themes use the same format. -->

{{One-sentence description of the package. Match the description in composer.json.}}

<!-- agent: Keep only when a screenshot exists. Use a public link such as GitHub user-attachments. Never use local paths. Otherwise delete this line. -->
<!-- ![{{alt}}]({{image-url}}) -->

<!-- agent: Add a TOC when there are more than 5 sections, generated with a markdown TOC tool. Otherwise delete the TOC block. -->
<!-- TOC -->
<!-- TOC -->

## Installation

<!-- agent: Required for all packages. -->

Install from composer

```shell
composer require lyrasoft/{{package-name}}
```

Then copy files to project

```shell
php windwalker pkg:install lyrasoft/{{package-name}} -t routes -t migrations -t seeders
```

<!-- agent: Set -t flags to match the resources the package actually ships, listing only directories that exist: routes (if routes/ exists), migrations (if migrations/ exists), seeders (if seeders/ exists and sample data is needed). Language files are handled in the Language Files section, not here. Overridable resources such as entity, views, scss, or vue are listed only when the package explicitly provides them and overriding is expected. Libraries or themes that do not use pkg:install should replace this with yarn add or composer require instructions and delete the pkg:install line. -->

### Dependencies

<!-- agent: Keep only when the package depends on other LYRASOFT packages. List each dependency, link its README, and require configuring it first. Delete the whole section when there are no dependencies. -->

{{Package Title}} depends on [lyrasoft/{{dep-package}}](https://github.com/lyrasoft/{{dep-repo}}). Please read their README and configure them first.

Then install the dependent packages:

```shell
php windwalker pkg:install lyrasoft/{{dep-package}} -t routes -t migrations
```

### Seeders

<!-- agent: Keep only when the package provides seeders. Otherwise delete the whole section. -->

Add these files to `resources/seeders/main.php`:

```php
return [
    // ...

    __DIR__ . '/{{seeder-name}}.seeder.php',

    // ...
];
```

<!-- agent: Keep the block below only when seeders need category types. List each type's max_level and number, and state which seeder file the types go into. -->

Add these types to `category.seeder.php`:

```php
static function () use ($seeder, $orm, $db) {
    $types = [
        // ...

        '{{type}}' => [
            'max_level' => {{level}},
            'number' => {{number}},
        ],
    ];
```

### Language Files

<!-- agent: Keep only when the package has a lang/ directory. -->

Add this line to admin & front middleware to load language from the package:

```php
$this->lang->loadAllFromVendor(\Lyrasoft\{{Namespace}}\{{Namespace}}Package::class, 'ini');
```

<!-- agent: Keep the command below only when the project needs to override language files. The class name must be the package's Package class, never a package-name string. -->

Or copy language files to project:

```shell
php windwalker pkg:install lyrasoft/{{package-name}} -t lang
```

## Register Admin Menu

<!-- agent: Keep only when the package has admin pages, and list every admin route name. For a single page, call link() directly without registerChildren(). -->

Edit `resources/menu/admin/sidemenu.menu.php`:

```php
$menu->link('{{Menu Title}}', '#')
    ->icon('fal fa-{{icon}}');

$menu->registerChildren(
    function (MenuBuilder $menu) use ($nav, $lang) {
        $menu->link('{{Child Menu Title}}')
            ->to($nav->to('{{route-name}}'))
            ->icon('fal fa-{{icon}}');
    }
);
```

## Configuration

<!-- agent: Keep only when the package has an etc/packages/*.php config file. Otherwise delete the whole section. List each key with its type and default. Do not only paste the config file. -->

Open `etc/packages/{{package-name}}.config.php` to configure:

```php
return [
    '{{config-key}}' => [
        '{{setting}}' => {{default-value}}, // {{description}}
    ],
];
```

| Key           | Type       | Default       | Description     |
|---------------|------------|---------------|-----------------|
| `{{setting}}` | `{{type}}` | `{{default}}` | {{description}} |

<!-- agent: Keep the block below only when settings are read from .env. Never write real keys, passwords, or hash keys. Use placeholders such as your-xxx-here. -->

Add these to `.env` and `.env.dist`:

```dotenv
{{PACKAGE}}_{{KEY}}=your-{{key}}-here
```

## Usage

<!-- agent: Required. Describe the main features of the package, with Service and Repository calls first. Give a minimal runnable example for each API and explain the return value in a comment. -->

```php
/** @var \Lyrasoft\{{Namespace}}\Service\{{Service}} $service */
$service = $app->service(\Lyrasoft\{{Namespace}}\Service\{{Service}}::class);

$result = $service->{{method}}({{args}});
```

## Frontend

<!-- agent: Keep the whole section only when the package has front routes, blade components, or TS/JS functions. -->

### Routes

<!-- agent: List the public front route names from routes. Use a table with columns name, entity, and description when there are many. -->

- `{{route-name}}`

### Components & JS

<!-- agent: Keep only when the package provides blade components or TS/JS functions. Explain where to call them (page ts file or main.ts) and list the component params in a table. -->

Import and call in the page `ts` file or `main.ts`:

```ts
import { use{{Name}} } from '@lyrasoft/{{package-name}}';

await use{{Name}}();
```

Use the blade component:

```html
<x-{{component-name}}
    type="{{type}}"
    :id="$item->id"
></x-{{component-name}}>
```

| Param       | Type       | Default       | Description     |
|-------------|------------|---------------|-----------------|
| `{{param}}` | `{{type}}` | `{{default}}` | {{description}} |

## Events

<!-- agent: Keep only when the package dispatches DOM events or Windwalker events. List the event name and the detail fields. -->

```ts
document.addEventListener('{{event-name}}', (e) => {
    e.detail.{{field}};
});
```

## Notes

<!-- agent: Put global settings that projects must configure, such as Session SameSite, CSRF exclusion for notify URLs, payment callbacks, or cache clear commands. Delete the whole section when there are no notes. -->
