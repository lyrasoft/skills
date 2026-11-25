# Shared instruction toolkit

This folder is a reusable toolkit that can be copied into a project's `.github/` directory when a team wants a consistent AI collaboration setup.

## Language variants

- `zh-TW/`: Traditional Chinese guidance for local company or team use
- `en/`: English guidance for international or cross-team use

These two versions are meant to coexist as parallel language variants of the same shared material. Teams may choose one language or the other depending on project needs.

## Default writing rule

Unless a task explicitly requests Chinese-only or another specific language, the default behavior is to write in both Chinese and English together. Keep the wording neutral and reusable, and do not repeat the company name inside `files/` unless there is a specific need.

## File references

When linking to another file, prefer a Markdown link such as `[file name](relative/path.md)`. Use inline code only when mentioning a filename or file type without linking to it.

## File roles

- `README.md`: overview and usage context
- `AGENTS.md: repo-level guidance for agents and contributors
- `instructions/`: repository-level rules and routing guidance
- `SKILL.md`: a reusable skill definition
- `*.prompt.md`: reusable prompt templates
- `docs/`: human-readable documentation and templates
- `skills/`: reusable skill sets and templates
