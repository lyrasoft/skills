# LYRASOFT Package 開發指引

基本套件開發指引請見 `../../../windwalker/references/development-core/package-development.md`。

本文件補充 LYRASOFT 套件的開發流程，請先依照上述標準流程完善工作後，再依本文件加入 LYRASOFT 專屬開發環境。

## 根目錄開發文件

- `.gitignore`：可參考這份共用版本：<https://raw.githubusercontent.com/lyrasoft/luna/refs/heads/master/.gitignore> 並依需求調整
- `.gitattributes`： 範本 `../../assets/.gitattributes`，可依套件需求調整。
- `VERSION`：從 `0.1.0` 開始。
- `README.md`：放上套件標題即可。

## PHP-CS-Fixer 與 Git Hook

套件可使用 PHP-CS-Fixer 檢查與修正程式碼，並選擇啟用 pre-commit hook 整理已暫存的 PHP 檔案。將以下範本複製到套件根目錄：

| 範本 | 套件內位置 |
| --- | --- |
| [`.php-cs-fixer.dist.php`](../../assets/cs-fixer/.php-cs-fixer.dist.php) | `.php-cs-fixer.dist.php` |
| [`autoload.app.php`](../../assets/cs-fixer/autoload.app.php) | `bin/autoload.app.php` |
| [`cs-fixer.php`](../../assets/cs-fixer/cs-fixer.php) | `bin/cs-fixer.php` |
| [`pre-commit`](../../assets/cs-fixer/pre-commit) | `.githooks/pre-commit` |

PHP-CS-Fixer 使用 Windwalker Core 的 `.php-cs-fixer.rules.php` 共用規則，依序從 `../core/` 或 `vendor/windwalker/core/` 載入。

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

使用 `composer cs-check` 檢查，或使用 `composer cs-fix` 修正程式碼。可傳入 PHP-CS-Fixer 參數，例如：

```shell
composer cs-check -- --path-mode=intersection src/SomeClass.php
composer cs-fix -- --path-mode=intersection src/SomeClass.php
```

- `bin/autoload.app.php` 供套件開發指令與測試載入 Composer autoloader；正式應用程式請載入自己的 `vendor/autoload.php`。
- `bin/cs-fixer.php` 會載入 autoloader 並執行 PHP-CS-Fixer。請保留此檔的可執行權限。
- `.githooks/pre-commit` 處理已暫存的新增、複製、修改或重新命名 PHP 檔案；若有未暫存變更，不會重新暫存。Hook 或 PHP-CS-Fixer 執行失敗時，提交會失敗。

完成後提醒使用者自行在套件根目錄執行 `composer prepare-hooks` 啟用 hook。

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

## 測試機制

參考 Host app 內的 `vendor/windwalker/core/tests/` 內的測試範例，建立：

- `tests/bootstrap.app.php` - 載入套件的 autoloader 與測試環境，範本見: `../../assets/packages/bootstrap.app.php`
- `phpunit.dist.xml` - PHPUnit 設定檔，範本見: `../../assets/packages/phpunit.dist.xml`
- `phpunit.app.dist.xml` - PHPUnit 設定檔，使用 Host App 環境，同上但 `WINDWALKER_TEST_APP_ROOT=../../..`
- `.github/workflows/ci.yml` - GitHub Actions CI 設定檔，依照需求撰寫，使用最新的 actions modules

其他注意事項

- DB 原則上先使用 SQLite 測試
- 若需要 DB 測試，盡量設計成每一次測試啟動時都用不同的 hash 產生不同的 Database/Schema，避免多個 process 同時測試時互相干擾

## 完整 README

僅在使用者明確要求撰寫 README 時才參考：複製範本 `../../assets/packages/README.md` 到套件根目錄，依 [套件 README 撰寫指引](lyrasoft-package-readme.md) 填寫，完成後移除所有 `agent` 註解。通常於功能完成後處理。
