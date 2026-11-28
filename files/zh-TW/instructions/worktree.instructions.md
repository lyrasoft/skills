---
applyTo: '**'
---
# Worktree 模式指引

以下規則只適用於任務在 git worktree（worktree 隔離模式）中執行的情況。

- **命名**：在 worktree 模式下開始新任務時，先詢問使用者是否要自訂 worktree / 分支名稱，再建立。使用者沒有偏好時，依任務內容自動命名。
- **每次變更都提交**：每完成一項變更，直接在 worktree 內 commit，不留下未提交的工作。
- **合併**：使用者要求將 worktree 合併回目前的工作分支時，把 worktree 內所有 commit squash 成單一 commit，並依實際變更自行撰寫 commit message，不需再詢問。
- **延續工作**：合併後若使用者還有後續指示，持續在同一個 worktree 工作（每次變更仍要 commit），只有在使用者要求時才再次 squash 合併。
- **資料庫測試**：任務需要資料庫測試時，先確認工作分支的環境是否已有運行中的資料庫（本機或 Docker）。若有，直接使用，參考 [資料庫測試](../skills/test/references/database-testing.md)。
- **Vendor 供測試使用**：新建的 worktree 沒有 `vendor/`。寫完程式碼後若需要執行測試，先將主 repo 的 `vendor` 以符號連結方式建立在 worktree 內（`ln -s <主 repo>/vendor vendor`）。若連結造成無法有效解決的路徑問題，或主 repo 沒有 `vendor`，則移除連結並改執行 `composer install`。`vendor/` 不可提交。
- **連結保留到最後**：若專案的 pre-commit hook 依賴 `vendor/bin/php-cs-fixer`（見 [程式碼規範](./cs.instructions.md)），缺少時 hook 會默默略過格式化。因此第一次 commit 前就要建立 `vendor` 連結（即使不跑測試），並在整個工作階段保留；只有在整個任務（包含所有 commit 與合併）完成後才移除。若主 repo 的 `vendor/bin/php-cs-fixer` 不存在，先在主 repo 執行 `composer install`。提交前一律用 `git status` 確認沒有暫存到 `vendor/`。
