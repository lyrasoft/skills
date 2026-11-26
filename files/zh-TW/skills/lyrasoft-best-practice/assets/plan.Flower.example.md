# Flower MVC 工作計畫

- Stage: `Admin`
- Subject: `Flower`

## 目標

<!-- agent: 簡述此功能要解決的問題 -->

## 參考文件

- Windwalker MVC 架構、Code Generation、ORM Entities
- `windwalker/references/development-app/mvc-generation.md`

## 資料表（`flowers`）

| 欄位 | 型別 | PK  | Null | 預設 | 特殊型別  | 說明 |
| ---- | ---- |---| ---- | ---- |---| ---- |
| id | int AI | Y  | N | |   | PK |
| type   | varchar(255)       |    | N  | | enum:FlowerType  |    |
| prefix   | varchar(255)       |    | N  | |   |    |
| title | varchar(255) |   | N | '' |   | 名稱 |
| state | bool |   | N | 1 | enum:BasicState  | 發佈狀態 |
| details | json |   | N | 1 | FlowerDetails  | 細節 |
| ordering | int |   | N | 0 |   | 排序 |
| created | datetime |   | Y | |   | 建立時間 |
| created_by | int |   | N | 0 |   | 建立者 |
| modified | datetime |   | Y | |   | 修改時間 |
| modified_by | int |   | N | 0 |   | 修改者 |

### Indexes

- Indexes
  - created
  - type,prefix
- Unique Keys
  - type,prefix

### 關聯表

- （無 / 說明）

## Form Fields

只列出手動指定的，其他欄位由產生器自動生成。

- type: `FlowerTypeField` -> FlowerType enum
- prefix: `FlowerPrefixField`
- details: `RepeatableField`，可新增多個 `FlowerDetail`，每個 `FlowerDetail` 有：
  - title: `TextField`
  - description: `TextareaField`
  - date: `CalendarField`

<!-- agent: 後續章節依需求產生 -->

## 執行步驟

<!-- agent: 這邊的執行步驟也要根據實際計畫與文件建議產生，讓使用者決定一次執行到哪裡 -->

1. 建立 migration 與 Entity
2. 執行產生器
3. 調整 Form / View
4. 實作 Services 與其他邏輯
5. 測試
