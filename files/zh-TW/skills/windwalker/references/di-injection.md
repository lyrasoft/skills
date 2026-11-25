# Windwalker DI 與注入

本參考說明 Windwalker 的依賴注入（DI）容器在 Earth 中的運作方式，以及如何把服務注入到類別中。

官方文件：

- [DI 概覽](https://windwalker.io/documentation/components/di/)
- [基本用法](https://windwalker.io/documentation/components/di/basic-usage.html)
- [屬性](https://windwalker.io/documentation/components/di/attributes.html)
- [參數](https://windwalker.io/documentation/components/di/parameters.html)
- [多層容器](https://windwalker.io/documentation/components/di/multi-levels.html)

## 運作方式

- 服務可依類別名稱或別名從容器取得，例如 `PathResolver::class` 或 `'@temp'`。
- 容器會讀取物件建構子的參數型別，並逐一解析後建立物件。
- 註冊為 shared 的服務（例如 `AppProvider.php` 中的 `PathResolver`）每次取得時都會回傳同一個實例。
- 可使用容器的 `get()` 方法，或在具備服務感知能力的物件上使用 `service()`，例如 `ConsoleApplication` 或 `AppContext`：

```php
$path = $this->container->get(PathResolver::class)->resolve('@temp/cache');
$path = $this->app->service(PathResolver::class)->resolve('@migrations');
```

## 建構子注入

在建構子中為依賴加上型別提示，容器會自動解析：

```php
class FileUploadService
{
    public function __construct(
        protected Container $container,
    ) {
    }
}
```

只有由容器建立的類別才會取得注入的建構子參數。使用 `new` 建立的類別不會被注入，因此需要明確傳入依賴，或從容器取得。

## 使用 `#[Inject]` 的屬性注入

若類別沒有建構子注入點，或需要的依賴不在建構子中，可在屬性上加上 `#[Inject]`：

```php
use Windwalker\DI\Attributes\Inject;

abstract class AbstractModule implements ModuleInterface
{
    #[Inject]
    protected AppContext $app;
}
```

此屬性定義於 `vendor/windwalker/core/vendor/windwalker/framework/packages/di/src/Attributes/Inject.php`，接受以下參數：

- `?string $id`：要解析的服務 ID 或別名，取代型別提示。
- `bool $forceNew`：建立新實例，而非重用 shared 實例。
- `UnitEnum|Closure|string|null $tag`：解析帶有標籤的服務。

`#[Inject]` 也可用於建構子參數（`TARGET_PARAMETER`）。

## 使用 `#[Ref]` 注入設定值

若只需要讀取單一設定值，而不想注入整個應用程式，可在屬性上使用 `#[Ref]`。它會從容器參數（設定樹）解析指定路徑。

以 `#[Ref('app.debug')]` 取代 `$app->isDebug()`：

```php
use Windwalker\Core\Attributes\Ref;

class TinymceEditorField
{
    #[Ref('app.debug')]
    protected bool $debug;
}
```

之後將原本使用 `$this->app->isDebug()` 的地方改為 `$this->debug`。`Ref` 解析的值與 `ApplicationTrait::isDebug()` 的回傳值相同（`config('app.debug')`）。Core 本身也是這樣讀取，例如 `WhoopsProvider.php` 與 `RequestProvider.php` 使用 `getParam('app.debug')`。

若類別只需要設定值，優先使用 `#[Ref]`。只有需要呼叫應用程式方法時，才注入 `ApplicationInterface`。

## 注意事項

- 只能注入到由容器建立的物件中。使用 `new` 建立的物件不會進行注入。
- `@temp`、`@logs` 等別名定義於 `etc/define.php` 與 `etc/runtime.config.php`，請透過 `PathResolver` 解析。
- 若類別完全無法取得容器，不要自行建立全域變數，應詢問如何傳入依賴。
