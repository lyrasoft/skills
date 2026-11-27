<!-- agent: 本檔為 LYRASOFT 套件 README 範本。使用前先依 references/packages/lyrasoft-package-readme.md 判斷套件類型，刪除不適用的章節，並移除所有 agent 註解與未替換的 {{ }} 佔位符。 -->
<!-- agent: 說明文字預設使用繁體中文，程式碼、指令、設定鍵名維持英文。若既有 README 為英文，沿用原語言。 -->

# LYRASOFT {{Package Title}} Package

<!-- agent: 標題格式固定為 "LYRASOFT {{Package Title}} Package"。函式庫或佈景主題同樣使用此格式。 -->

{{一句話說明套件用途，與 composer.json 的 description 一致。}}

<!-- agent: 有截圖時才保留。圖片使用 GitHub user-attachments 等公開連結，禁止使用本機路徑。沒有截圖就刪除本行。 -->
<!-- ![{{alt}}]({{image-url}}) -->

<!-- agent: 章節超過 5 個時加入 TOC，用 markdown TOC 工具產生。章節少於 5 個就刪除 TOC 區塊。 -->
<!-- TOC -->
<!-- TOC -->

## Installation

<!-- agent: 必要章節，所有套件都要有。 -->

Install from composer

```shell
composer require lyrasoft/{{package-name}}
```

Then copy files to project

```shell
php windwalker pkg:install lyrasoft/{{package-name}} -t routes -t migrations -t seeders
```

<!-- agent: -t 參數依套件實際提供的資源決定，只列出存在的目錄：routes（有 routes/）、migrations（有 migrations/）、seeders（有 seeders/ 且需要範例資料）。語言檔改由 Language Files 章節處理，不放進這行。entity、views、scss、vue 等覆寫資源只在套件明確提供且有覆寫需求時才列出。函式庫、佈景主題若不使用 pkg:install，改寫 yarn add 或 composer require 的安裝方式，刪除此段 pkg:install。 -->

### Dependencies

<!-- agent: 只有依賴其他 LYRASOFT 套件時才保留。列出依賴套件、連結其 README，並要求先完成其設定。沒有依賴就刪除整節。 -->

{{Package Title}} depends on [lyrasoft/{{dep-package}}](https://github.com/lyrasoft/{{dep-repo}}). Please read their README and configure them first.

Then install the dependent packages:

```shell
php windwalker pkg:install lyrasoft/{{dep-package}} -t routes -t migrations
```

### Seeders

<!-- agent: 只有套件提供 seeders 時才保留，否則刪除整節。 -->

Add these files to `resources/seeders/main.php`:

```php
return [
    // ...

    __DIR__ . '/{{seeder-name}}.seeder.php',

    // ...
];
```

<!-- agent: 只有 seeder 需要 category type 時才保留下列區段，列出每個 type 的 max_level 與 number，並說明 type 要加到哪個 seeder 檔。 -->

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

<!-- agent: 套件有 lang/ 目錄時才保留。 -->

Add this line to admin & front middleware to load language from the package:

```php
$this->lang->loadAllFromVendor(\Lyrasoft\{{Namespace}}\{{Namespace}}Package::class, 'ini');
```

<!-- agent: 只有需要讓專案覆寫語言檔時才保留下列指令。Class 名稱必須使用套件的 Package class，不可寫成套件名稱字串。 -->

Or copy language files to project:

```shell
php windwalker pkg:install lyrasoft/{{package-name}} -t lang
```

## Register Admin Menu

<!-- agent: 套件有後台頁面時才保留，列出所有後台 route 名稱。只有單一頁面時直接使用 link()，不需要 registerChildren()。 -->

Edit `resources/menu/admin/sidemenu.menu.php`:

```php
$menu->link('{{中文標題}}', '#')
    ->icon('fal fa-{{icon}}');

$menu->registerChildren(
    function (MenuBuilder $menu) use ($nav, $lang) {
        $menu->link('{{子選單標題}}')
            ->to($nav->to('{{route-name}}'))
            ->icon('fal fa-{{icon}}');
    }
);
```

## Configuration

<!-- agent: 套件有 etc/packages/*.php 設定檔時才保留，否則刪除整節。列出每個設定鍵的型別與預設值，不可只給程式碼。 -->

Open `etc/packages/{{package-name}}.config.php` to configure:

```php
return [
    '{{config-key}}' => [
        '{{setting}}' => {{default-value}}, // {{說明}}
    ],
];
```

| Key         | Type     | Default         | Description |
|-------------|----------|-----------------|-------------|
| `{{setting}}` | `{{type}}` | `{{default}}` | {{說明}}    |

<!-- agent: 讀取 .env 的設定才保留下列區段。禁止寫入真實金鑰、密碼、Hash Key，一律使用 `xxx` 或 `your-xxx-here` 佔位字串。 -->

Add these to `.env` and `.env.dist`:

```dotenv
{{PACKAGE}}_{{KEY}}=your-{{key}}-here
```

## Usage

<!-- agent: 必要章節之一。依套件主要功能撰寫，優先列出 Service 與 Repository 的常用呼叫。每個 API 給一段最小可執行範例，並以註解說明回傳值。 -->

```php
/** @var \Lyrasoft\{{Namespace}}\Service\{{Service}} $service */
$service = $app->service(\Lyrasoft\{{Namespace}}\Service\{{Service}}::class);

$result = $service->{{method}}({{args}});
```

## Frontend

<!-- agent: 前台有路由、blade 元件或 TS/JS 函式時才保留整節。 -->

### Routes

<!-- agent: 列出 routes 中對外的前台路由名稱。路由多時使用表格，欄位為 name、entity、說明。 -->

- `{{route-name}}`

### Components & JS

<!-- agent: 有 blade 元件或 TS/JS 函式時才保留。說明在哪個 main.ts 或頁面 ts 呼叫，並列出元件參數表。 -->

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

| Param    | Type            | Default | Description |
|----------|-----------------|---------|-------------|
| `{{param}}` | `{{type}}`   | `{{default}}` | {{說明}} |

## Events

<!-- agent: 套件會派發 DOM event 或 Windwalker event 時才保留，列出事件名稱與 detail 欄位。 -->

```ts
document.addEventListener('{{event-name}}', (e) => {
    e.detail.{{field}};
});
```

## Notes

<!-- agent: 放置必須注意的全域設定，例如 Session SameSite、CSRF 排除 Notify URL、金流 Callback、Cache 清除指令。沒有任何注意事項就刪除整節。 -->
