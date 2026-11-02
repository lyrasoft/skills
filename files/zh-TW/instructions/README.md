# 指令規範

這個目錄保存「指令層」的共用內容，主要放置 repository-level 的規則、限制、分流原則與必要的操作指引。

## 目的

- 保存通用且必要的指令規則
- 維持 `copilot-instructions.md` 的簡潔與可讀性
- 明確區分哪些內容屬於規則、哪些屬於技能、哪些屬於長文件
- 為未來增加新規則保留可擴充的入口

## 內容

- [instruction.instructions.md](instruction.instructions.md)：說明如何將內容拆到 `instructions`、`skills`、`docs`、`prompts` 之間
- [test-common.instructions.md](test-common.instructions.md)：PHP 測試檔案的 PHPUnit 撰寫慣例
- [test-coverage.instructions.md](test-coverage.instructions.md)：`@codeCoverageIgnore` 與不可忽略分支的強制規則
- 其他 repo-level 指引文件可在此目錄中持續新增，依主題分層管理

## 原則

- `instructions/` 不用來放所有東西，只放必要的規則與標準
- 內容必須簡短、明確、可快速檢視
- 若內容是長篇背景或參考資料，請放到 `docs/`
- 若內容是可重用技能，請放到 `skills/`
- 若內容是模板化任務，請放到 `prompts/`
