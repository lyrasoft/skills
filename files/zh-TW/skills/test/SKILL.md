---
name: test
description: 使用 PHPUnit 新增、更新與執行 PHP 測試，包含處理本機測試範圍設定，以及利用 coverage 找出缺漏測試。
---

# 技能：test

## 目的

提供新增、更新與執行 PHPUnit 測試的可重複流程。撰寫慣例請見[共用測試指令](../../instructions/test-common.instructions.md)，
coverage 規則請見 [coverage 指令](../../instructions/test-coverage.instructions.md)；本技能負責流程。

## 適用時機

- 為新增或變更的行為補上或更新測試
- 執行指定範圍的測試並回報結果
- 使用者要求補齊缺漏測試或提升 coverage

## 預期行為

### 執行測試

1. 確認要求的範圍（單一檔案、測試套件或整個專案）。
2. 根目錄的 `phpunit.xml` 是主要測試設定，但使用者的本機設定可能停用 database、service 或 package 等測試範圍。
3. 若要求的範圍被停用，不可將未執行的測試視為通過。請使用以 `phpunit.dist.xml` 為基礎的暫時設定並在完成後移除，
   或在可行時透過 PHPUnit CLI 選項提供所需設定。
4. 保留既有的本機 `phpunit.xml`。

### 以 coverage 補齊缺漏測試

1. 有可用的 coverage driver 時，對指定範圍執行 coverage，找出未覆蓋的行與分支。
2. 針對這些缺口補上有意義的行為斷言，包含邊界情況與錯誤路徑。
3. 重新執行相同範圍的 coverage，確認改善。
4. 不要用沒有斷言的測試或新增 coverage 排除來湊數字。
5. 若無法執行 coverage，請說明限制，不要宣稱缺口已被覆蓋。

## 驗證

- 指定範圍確實被執行，而非被悄悄略過
- 暫時設定已移除，本機 `phpunit.xml` 未被更動
- 新測試驗證行為，並遵循共用測試與 coverage 指令
- coverage 相關說明皆以重新執行相同範圍的結果為依據
