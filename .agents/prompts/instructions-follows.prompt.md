---
agent: ''
---
每次執行此 prompt 時，必須先依照任務型態，重新讀取相關的 instructions 再開始執行任務。

要求：
- 先判斷本次任務的型態（例如：文件撰寫、程式碼修改、審查、測試、設定變更等）。
- 讀取與該任務型態相關的 instructions（例如 `../main.instructions.md`、`.github/copilot-instructions.md`、`AGENTS.md`，以及任何適用的 `instructions/` 檔案），不要憑記憶或先前上下文直接執行。
- 在回報結果前，說明已讀取哪些 instructions，並確認本次執行符合其規範。
- 若讀取的 instructions 與任務需求衝突，先回報衝突並詢問使用者，不要自行忽略。

成功條件：
- 任務開始前，已完成對應 instructions 的重新讀取，且回覆中有列出讀取的檔案。
- 任務結果符合所讀取 instructions 的規範。
