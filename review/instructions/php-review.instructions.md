---
applyTo: "**"
---

# PHP 程式碼審查指引

審查 PHP 程式碼變更、PR 或 diff 時，請遵守以下規則。

## Migrations 變更

一但偵測到 `resources/migrations/**` 下的現有檔案修改（非新建檔案），請發出提醒，確認網站 Schema 是否已 freeze，是否需要建立新 migration。

## 圖片大小警告

- 如果圖片的寬度超過 `1920px`，請發出警告，確認是否需要壓縮圖片或使用更小的尺寸。
- 如果圖片的檔案大小超過 `1MB`，請發出警告，確認是否需要壓縮圖片或使用更小的尺寸。
- 只要檢查一次就好，不需要每次都檢查。

## 相關文件

- [Windwalker 4 官方文件 llms.txt](https://windwalker.io/llms.txt) - Windwalker 4 專案的官方文件索引，提供各種開發相關的文件連結。
  - [官方文件 REST API](https://docs.windwalker.io/search) - Windwalker 4 專案的官方文件搜尋工具，提供快速搜尋專案相關文件的功能。
  - [官方文件 MCP](https://docs-search.windwalker.io/mcp) - Windwalker 4 專案的官方文件 MCP (type=http) 伺服器，提供文件搜尋與查詢功能。
