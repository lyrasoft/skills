# Copilot instructions

## Purpose

This project is the company-wide shared agent instruction library. It acts as a reusable knowledge base for AI collaboration, cross-project standards, and shared operating guidance.

## Language variants

The reusable toolkit is organized in language-specific folders:

- `../zh-TW/`: Traditional Chinese version
- `../en/`: English version

These folders are intended to be copied into a project's `.github/` directory when the team needs repository guidance in one language or the other.

## What belongs here

- reusable cross-project skills and operating guidance
- internal documentation templates and conventions
- prompt templates for AI-assisted workflows
- onboarding and repository setup guidance for teams

Do not add product implementation docs, application source code, deployment scripts, secrets, or environment-sensitive configuration.

## Project structure

- [Project overview and shared standards](../../README.md)
- [General guidance for contributors and AI agents](../../AGENTS.md)
- `instructions`: repository-level rules and content routing guidance
- `SKILL.md`: formal definition of a reusable skill
- `skills`: shared skills and templates
- `docs`: internal documentation and templates
- `prompts`: AI workflow prompt templates

## File role separation

- [Entry point, overview, and index](../../README.md)
- [Repository-level rules and constraints for AI and contributors](../../AGENTS.md) / `.github/copilot-instructions.md`
- `SKILL.md`: defines a skill, including purpose, use cases, expected behavior, and validation
- `*.prompt.md`: reusable prompt templates
- `docs`: human-readable documentation and reference material

## Docs sections / lazy-loading guidance

`docs` may contain longer reference documents. Use a lazy-loading approach: do not read the full folder up front unless the task clearly requires it.

- [docs/index.md](docs/index.md): overview and section index; start here to identify which document is relevant.
- `docs/templates/`: templates, doc structure, and writing conventions; read this when creating or revising documentation.
- When adding a new docs category, update this section list so future work knows when to load it.
- If unsure which doc to read, start with [docs/index.md](docs/index.md) and then open only the topic-specific file needed for the current task.

Keep these sections short, durable, and expandable so future documentation categories can be added without rewriting the instruction file.

## Editing principles

- keep everything in Markdown
- when linking to other files in a list, you can use the Markdown link format `[display text](relative path)` at the beginning; when simply mentioning a file name or file type, you can use backticks.
- prefer neutral, reusable language
- avoid customer-, product-, or team-specific details unless they are explicitly required as examples
- keep templates concise and easy to copy into other repositories
- maintain clear folder responsibilities and avoid unrelated content
- keep the shared company context consistent across the documentation
- when no language is specified, default to bilingual Chinese + English content unless the request asks for one language only

## Validation

Before finalizing a change, confirm that:

- the content remains markdown-only
- the guidance stays generic and reusable
- the material remains aligned with the shared-knowledge purpose
- the repository does not drift into being a single-product or single-team private store
