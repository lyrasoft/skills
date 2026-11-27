# LYRASOFT Package 開發指引

基本套件開發指引請見 `../../../windwalker/references/development-core/package-development.md`。

本文件補充 LYRASOFT 套件的開發流程。

## 根目錄開發文件

- `.gitignore`：可參考這份共用版本：<https://github.com/lyrasoft/luna/blob/master/.gitignore>
- `README.md`：可先放上套件標題。
- `VERSION`：從 `0.1.0` 開始。

## PHP-CS-Fixer 與 Git Hook

套件使用 PHP-CS-Fixer 檢查與修正程式碼，並可選擇啟用 pre-commit hook，自動整理已暫存的 PHP 檔案。請將以下範本複製到套件根目錄的對應位置：

| 範本 | 套件內位置 |
| --- | --- |
| [`.php-cs-fixer.dist.php`](../../assets/cs-fixer/.php-cs-fixer.dist.php) | `.php-cs-fixer.dist.php` |
| [`autoload.app.php`](../../assets/cs-fixer/autoload.app.php) | `bin/autoload.app.php` |
| [`cs-fixer.php`](../../assets/cs-fixer/cs-fixer.php) | `bin/cs-fixer.php` |
| [`pre-commit`](../../assets/cs-fixer/pre-commit) | `.githooks/pre-commit` |

此 PHP-CS-Fixer 設定會使用 Windwalker Core 的 `.php-cs-fixer.rules.php` 共用規則；範本會依序尋找套件旁的 `../core/.php-cs-fixer.rules.php`，以及套件內的 `vendor/windwalker/core/.php-cs-fixer.rules.php`。

在套件的 `composer.json` 加入以下 scripts：

```json
{
    "scripts": {
        "cs-check": "bin/cs-fixer.php check --diff",
        "cs-fix": "bin/cs-fixer.php fix",
        "prepare-hooks": "git config core.hooksPath .githooks",
        "remove-hooks": "git config --local --unset core.hooksPath"
    }
}
```

使用 `composer cs-check` 檢查套件設定的檔案範圍，使用 `composer cs-fix` 修正程式碼。可將參數傳給 PHP-CS-Fixer，例如：

```shell
composer cs-check -- --path-mode=intersection src/SomeClass.php
composer cs-fix -- --path-mode=intersection src/SomeClass.php
```

`bin/autoload.app.php` 是供套件開發指令與測試使用的內部 helper，不是正式環境的應用程式啟動檔。它依序載入套件自己的 `vendor/autoload.php`，或假設套件位於主應用程式 `vendor/{vendor}/{package}` 下時，載入主應用程式的 Composer autoloader。正式應用程式應直接載入自己的 Composer autoloader。

`bin/cs-fixer.php` 會使用上述 helper 尋找 autoloader、切換至套件根目錄，並將命令列參數交給 PHP-CS-Fixer。請保留此檔的可執行權限。`.githooks/pre-commit` 只處理已暫存的新增、複製、修改或重新命名 PHP 檔案；若檔案同時有未暫存變更，hook 會修正工作目錄中的檔案但不會重新暫存，以免覆蓋部分暫存的狀態。Hook 或 PHP-CS-Fixer 執行失敗時，提交也會失敗。

Hook 為手動啟用：在套件根目錄執行 `composer prepare-hooks` 設定該 repository 的 `core.hooksPath`，並可用 `composer remove-hooks` 取消。除非另有需求，請勿將 hook 啟用加入 Composer 的 `post-install-cmd` 或 `post-update-cmd`；在主應用程式根目錄執行 Composer 也不會執行依賴套件中宣告的 scripts。

## 自動更新版本號

為了方便管理套件版本，可使用預先準備的發布指令更新版本號與 Git tag。

先在套件根目錄建立 `VERSION` 檔案，填入初始版本號，例如 `0.1.0`。

接著在套件根目錄建立 `bin/`，並在該目錄下載 `Console.php` 與 `release.php`：

```shell
wget https://raw.githubusercontent.com/asika32764/php-simple-console/master/src/Console.php
wget https://raw.githubusercontent.com/asika32764/php-simple-console/refs/heads/master/bin/release.php

chmod +x release.php
```

或使用 `curl`：

```shell
curl https://raw.githubusercontent.com/asika32764/php-simple-console/master/src/Console.php -o Console.php
curl https://raw.githubusercontent.com/asika32764/php-simple-console/refs/heads/master/bin/release.php -o release.php

chmod +x release.php
```

### 更新版號的指令

程式更新完成、準備發布新版本時，在套件根目錄執行：

```shell
php bin/release.php patch
```

其他參數：

```shell
php bin/release.php -h       # 顯示說明
php bin/release.php patch    # 更新 patch 版本
php bin/release.php minor    # 更新 minor 版本
php bin/release.php major    # 更新 major 版本
php bin/release.php x.x.x    # 指定版本號
```
