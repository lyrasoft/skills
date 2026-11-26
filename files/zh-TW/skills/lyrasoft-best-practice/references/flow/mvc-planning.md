# MVC 工作計畫指引

## 目的

在建立 MVC 之前，先規劃好資料表、模型、控制器、路由、視圖、表單與前端資產的關聯，避免重複工作。

## 預先參考文件

- [Windwalker MVC 架構文件](https://windwalker.io/documentation/unicorn/mvc-crud/mvc-concepts.md)
- [Code Generation](https://windwalker.io/documentation/unicorn/mvc-crud/code-generation.md)
- [ORM Entities](https://windwalker.io/documentation/framework/services/database/entities.md)
- Windwalker MVC 產生器指令 `../../../windwalker/references/development-app/mvc-generation.md`
- 測試指引 `../../../test/SKILL.md`
- 查找任何本地或遠端，與這次工作任務有關連的文件。
- 可用的文件查詢 API 請見 `../../../windwalker/SKILL.md`，或使用 Windwalker Docs MCP。

## 須準備參數

- `$stage`: 前後台位置(Front/Admin)，或者指定的 Stage 名稱 (PascalCase)
- `$subject`: 資料表名稱或 Entity 名稱 (PascalCase)

## 工作流程

- 確實閱讀所有指定文件，建立大方向了解 MVC 架構與產生器的使用方式，還有 Unicorn MVC 的 List / Item 架構。
- 使用 askQuestion tool 詢問使用者，取得 `$stage` 與 `$subject` 參數。
- 根據使用者提供的額外指示，規畫:
  - 這個 Entity ($subject) 的資料表欄位、建議的 indexes、是否需要關聯表等等
  - 根據 Windwalker ORM 的風格，規劃特殊資料欄位: JSON、Enum、DateTime、Record 等等 Casting
  - 與上述欄位搭配的 Edit View / Form Fields 規劃。
  - 搭配的 Services，運作方式、存取策略等等。
  - 任何達成本次工作任務需要的相關程式規劃與流程
- 建立一個 Markdown 計畫文件，命名為 `plan.<subject>.md`，放在專案 `tmp/` 目錄
  - 包含上述規劃的所有內容，盡量讓章節層次清楚，使用簡單文字描述，清單條列等，讓使用者可以進行必要編輯。
  - 編輯後可以用這個計畫讓 agent 直接執行。
  - 計畫範本見 `../../assets/plan.Flower.md`，請依照此範本建立計畫文件。
  - 範本註解中的 `<!-- agent: ... -->` 代表給 agent 看的說明，實際產生時請刪除。
- 後續實際執行時，依照使用者指令照順序執行，可以在使用者允許下實際執行 migrations & seeders 確認產生成果。

## 執行須知

- 若文件有提供產生器指令，應避免手動產生，盡量使用指令執行。
- 可依照計畫手動修改產生的程式碼。
- 可採用 E2E 測試或單元測試驗證產生的程式碼是否符合預期。 

## 驗證

- 依照計畫文件中的步驟，逐一執行並確認每個步驟的結果是否符合預期。
- 檢視產生的程式碼與資料庫結構，確保符合計畫文件中的規劃。可使用 MCP 來檢視資料庫內容。
- 可使用 E2E 測試檢視前端產生結果。
- 可使用單元測試檢視後端程式碼的行為是否符合預期。

