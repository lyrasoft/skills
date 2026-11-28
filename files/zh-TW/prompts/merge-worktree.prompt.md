---
agent: ''
---

提交目前 git worktree 中所有未提交的變更，然後將該 worktree 以單一 squash commit 合併回工作分支。

1. 先在 worktree 內提交所有未提交的變更，確保沒有遺漏。
2. 判斷 worktree 要合併的工作分支（主 checkout 所在的分支）。只有無法判斷時才詢問使用者。
3. 確認工作分支沒有會與合併衝突的未提交變更。
4. 合併前詢問使用者是否要提供自訂 commit message；若有，附加到依 diff 產生的 commit message 之後。
5. 將 worktree 分支 squash 合併到工作分支（`git merge --squash <worktree-branch>`），然後建立一個 commit。
6. 依實際 diff 自行撰寫 commit message：簡潔的祈使句標題，只有在變更需要說明時才加上簡短內文。不需要詢問使用者 message。
7. 若 squash 合併發生衝突，衝突解法明確時直接解決；否則停止並回報衝突的檔案。
8. 保留 worktree 與其分支，以便後續繼續工作；除非使用者要求，不要刪除。

成功條件：工作分支只新增一個 commit，包含 worktree 的所有變更；worktree 沒有未提交的變更；最終的 commit message 準確描述變更內容。
