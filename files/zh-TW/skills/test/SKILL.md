---
name: test
description: 共用的 Test 技能，可以從這裡入口尋找測試相關的指令、文件與技能。
---

# 技能：test

## 目的

當使用者要求執行測試或編寫測時，agent 可以使用這個技能來提供測試相關的指令、文件與技能。

由於專案可能擁有多重混和技術棧，測試相關的指令、文件與技能可能分散在不同的路徑下，這個技能提供一個統一的入口，讓 agent 可以快速找到測試相關的資源。

## 測試指令

本 Skill 主要提供不同技術棧的常用測試指令，個別專案如果有專屬的測試指令與流程，請優先參考專案內的 instructions。

## 測試相關知識與規範

- 所有測試工作共同的知識 @references/test-common.md
- PHP / Windwalker 框架之測試 @references/windwalker-testing.md
  - PhpUnit 測試規範與指引 @references/phpunit-testing.md
  - Coverage 規範與指引 @references/coverages.md
- E2e / Playwright 測試規範與指引 @references/e2e-testing.md
  - Windwalker 登入流程（認證檔案、session cookie、session 橋接）@references/e2e-windwalker-auth.md
