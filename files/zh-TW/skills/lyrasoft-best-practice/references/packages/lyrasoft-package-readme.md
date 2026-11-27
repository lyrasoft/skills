# LYRASOFT 套件 README 撰寫指引

本文件說明如何使用 [`README.md` 範本](../../assets/packages/README.md) 為 LYRASOFT 套件撰寫 README，包含 agent 指示語法、套件類型判斷與章節取捨。

## 範本位置與用途

- 範本：`../../assets/packages/README.md`
- 用途：新建套件時複製為套件根目錄的 `README.md`，或為既有 README 補齊標準章節。
- 範本內的 `<!-- agent: ... -->` 是給 agent 的指示，完成後必須全部移除。

## Agent 指示語法

| 寫法 | 意義 |
| --- | --- |
| `<!-- agent: 說明 -->` | 單行指示，說明該章節或該行要怎麼填、何時保留或刪除。 |
| `{{name}}` | 佔位符，必須替換為實際值；交付前不得殘留。 |
| `<!-- ![...](...) -->` | 被註解掉的選用內容，需要時取消註解。 |

填寫順序：

1. 判斷套件類型（見下方）。
2. 依指示逐章保留或刪除。
3. 替換所有 `{{ }}` 佔位符。
4. 移除所有 `<!-- agent: ... -->` 與未使用的註解。
5. 對照實際目錄與程式碼，確認每條指令與路徑存在。

## 套件類型判斷

先依套件性質決定安裝方式與章節，不要套用不適用的章節。

| 類型 | 判斷依據 | 安裝方式 | 常用章節 |
| --- | --- | --- | --- |
| 業務套件 | 有 Windwalker `routes/`、`migrations/`、後台頁面 | `composer require` + `pkg:install` | 全部，依實際資源取捨 |
| 函式庫（前端） | 以 npm 發布的 TS/Vue 工具，例如 `ts-toolkit` | `yarn add` | Installation、Usage、各入口說明 |
| 佈景主題 | 提供 SCSS、views 覆寫，例如 `theme-nexus` | `composer require` + `pkg:install` 指定 tag | Installation、Notes（如何覆寫 Vite、fusionfile） |
| 基礎套件 | 無路由、無後台，只提供服務，例如 `throttle`、`sequence` | `composer require` + `pkg:install -t migrations` | Installation、Usage、Configuration |

## 章節取捨

| 章節 | 何時保留 | 何時刪除 |
| --- | --- | --- |
| 標題與一句話說明 | 必要 | 不可刪除 |
| Installation | 必要 | 不可刪除 |
| Dependencies | 依賴其他 LYRASOFT 套件 | 無依賴 |
| Seeders | 有 seeders 目錄 | 無 seeders；套件不提供範例資料時應說明由專案自行撰寫 |
| Language Files | 有 `lang/` 目錄 | 無語言檔 |
| Register Admin Menu | 有後台頁面 | 純前台或函式庫 |
| Configuration | 有 `etc/packages/*.php` 或 env | 使用預設值即可 |
| Usage | 提供 Service 或 Repository 給專案呼叫 | 無公開 API（例如純 UI 佈景） |
| Frontend | 有路由、blade 元件或 TS 函式 | 純後端套件 |
| Events | 會派發事件給專案監聽 | 不派發事件 |
| Notes | 有需要專案額外設定的全域注意事項 | 無 |

## 撰寫原則

- 說明以繁體中文為主，程式碼與設定保持英文。既有 README 為英文時沿用原語言。
- 每個 API 至少給一段可執行範例，並用註解說明回傳值，例如 `// int`。
- 設定項目必須列出型別與預設值，不能只貼設定檔。
- Session SameSite、CSRF 排除、金流 Notify URL 等全域設定放在 Notes，並給出完整程式碼。
- 指令中的套件名稱以 `lyrasoft/<package-name>` 為準，`<package-name>` 與 GitHub repo 名稱不同時以 Composer 套件名為準。
- Language 載入一律使用 `\Lyrasoft\<Namespace>\<Namespace>Package::class`，不要寫成字串套件名。
- 範例中的金流金鑰、密碼、Hash Key 一律替換為佔位字串，不可保留真實值。
- 未完成的功能不要寫成已可用。若要標示未完成，使用 `WIP` 並說明狀態。

## 既有 README 的常見問題

整理 `lyrasoft` 組織內 20 份 README 時觀察到，以下問題應避免重複：

- 直接複製其他套件段落，導致 `loadAllFromVendor` 指向錯誤套件（例如活動報名套件寫成 shopgo）。
- 指令與程式碼片段仍是舊版寫法（例如 `$this->trans`、`$app->retrieve` 與 `$app->service` 混用）。
- 段落順序不一致，部分 README 缺少安裝或語言章節。
- 拼字與用語不一致或有錯字（例如 `poilicy`、`Ecpay` 與 `ECPay` 混用、`catagoey`）。
- 含有實際的金流測試金鑰，不可沿用。

## 驗證

完成後逐項確認：

- [ ] 所有 `<!-- agent: -->` 註解與 `{{ }}` 佔位符已移除。
- [ ] `pkg:install` 的 `-t` 參數對應套件實際存在的目錄。
- [ ] 文件中提到的 route、menu、config key 能在程式碼中找到。
- [ ] 範例中沒有真實金鑰或本機路徑。
- [ ] 不適用的章節已刪除，沒有空標題。
