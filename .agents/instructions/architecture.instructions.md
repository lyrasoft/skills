# 專案結構

## 目錄結構

- `files/zh-TW/`、`files/en/`：中文與英文兩個共用版本，可複製到各專案的 `.agents/` or `.github/`
- `review/`：審查規則與文件（`REVIEW.md`、`instructions/`、`docs/`）

## 語言

- 同時維護中文（`files/zh-TW/`）與英文（`files/en/`）版本
- 未另行指定時，採用中英文同時編寫；使用者明確要求單一語言時依其指定
- `files/` 內容避免反覆出現公司名稱，使用中性、通用的說法

## 提供給外部專案之文件

- `files/*/instructions/`：repository-level 規則與內容分流說明
- `files/*/skills/`：共用技能與模板
- `files/*/docs/`：公司內文件與說明範本
- `files/*/prompts/`：AI 工作流程 prompt 模板
- `review/`：審查規則與文件（`REVIEW.md`、`instructions/`、`docs/`）

> [!important]>
> `files/**` 與 `review/**` 內的內容是為了讓其他專案的 agent 使用的，不應該對本專案的程式碼或測試產生影響
