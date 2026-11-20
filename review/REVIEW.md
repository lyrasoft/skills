# 夏木樂 Code Review 指引

## 重要指示

這是夏木樂專案的 Code Review 指引，主要針對 Windwalker 4 專案的開發流程與程式碼審查提供指導。請遵循以下原則進行程式碼審查：

- 優先用繁體中文回應
- 優先閱讀規範文件，再開始 review
- 安全性優先，請注意程式碼中可能存在的安全漏洞
- 保持程式碼簡潔易讀，遵循專案的程式碼風格指南
- 說明 review 建議時，不要太繞口，用簡潔白話講解

## 規範文件

- HTML / CSS / SCSS 切版相關規範
  - [CSS / SCSS 標準規範](docs/css/css-scss-standards.md)
  - [修改 Bootstrap 變數、自定義顏色](docs/css/customize-bootstrap-variables.md)
  - [BEM 命名規範](docs/css/bem.md)

## 參考文件

- [Windwalker 4 官方文件 llms.txt](https://windwalker.io/llms.txt) - Windwalker 4 專案的官方文件索引，提供各種開發相關的文件連結。
  - [官方文件 REST API](https://docs.windwalker.io/search) - Windwalker 4 專案的官方文件搜尋工具，提供快速搜尋專案相關文件的功能。
  - [官方文件 MCP](https://docs-search.windwalker.io/mcp) - Windwalker 4 專案的官方文件 MCP (type=http) 伺服器，提供文件搜尋與查詢功能。
- [review.instructions.md](instructions/review.instructions.md) - Code Review 執行指引，這是主要的任務入口
- [php-review.instructions.md](instructions/php-review.instructions.md) - PHP Code Review 執行指引
