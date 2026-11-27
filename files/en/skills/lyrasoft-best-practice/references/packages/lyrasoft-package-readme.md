# LYRASOFT Package README Writing Guide

This document explains how to write a README for a LYRASOFT package with the [README template](../../assets/packages/README.md). It covers the agent directive syntax, package type decisions, and section selection.

## Template Location and Purpose

- Template: `../../assets/packages/README.md`
- Purpose: copy it to the package root as `README.md` for new packages, or use it to fill in missing standard sections in an existing README.
- `<!-- agent: ... -->` comments are instructions for the agent. Remove all of them after filling in the template.

## Agent Directive Syntax

| Syntax | Meaning |
| --- | --- |
| `<!-- agent: text -->` | One-line instruction explaining how to fill in or whether to keep or delete a section or line. |
| `{{name}}` | Placeholder that must be replaced with the actual value. None may remain in the final file. |
| `<!-- ![...](...) -->` | Optional content that is commented out. Uncomment it when needed. |

Filling order:

1. Decide the package type (see below).
2. Keep or delete each section as instructed.
3. Replace all `{{ }}` placeholders.
4. Remove all `<!-- agent: ... -->` comments and unused comments.
5. Check that every command and path matches the real directories and code.

## Package Type Decision

Decide the package nature first, so the install method and sections match. Do not apply sections that do not fit.

| Type | How to recognize | Install method | Common sections |
| --- | --- | --- | --- |
| Business package | Has Windwalker `routes/`, `migrations/`, or admin pages | `composer require` + `pkg:install` | All, selected by the resources that actually exist |
| Frontend library | TS/Vue utilities published on npm, such as `ts-toolkit` | `yarn add` | Installation, Usage, one section per entry point |
| Theme | Provides SCSS and views overrides, such as `theme-nexus` | `composer require` + `pkg:install` with tags | Installation, Notes (Vite and fusionfile setup) |
| Base package | No routes or admin pages; only services, such as `throttle` or `sequence` | `composer require` + `pkg:install -t migrations` | Installation, Usage, Configuration |

## Section Selection

| Section | Keep when | Delete when |
| --- | --- | --- |
| Title and one-line description | Always | Never |
| Installation | Always | Never |
| Dependencies | The package depends on other LYRASOFT packages | No dependencies |
| Seeders | A seeders directory exists | No seeders. State that the project must write its own sample data |
| Language Files | A `lang/` directory exists | No language files |
| Register Admin Menu | Admin pages exist | Front-only or library packages |
| Configuration | An `etc/packages/*.php` file or env settings exist | Defaults are sufficient |
| Usage | Services or repositories are provided for the project to call | No public API, such as pure UI themes |
| Frontend | Front routes, blade components, or TS functions exist | Back-end only packages |
| Events | Events are dispatched for the project to listen to | No events are dispatched |
| Notes | The project needs extra global configuration | None |

## Writing Principles

- Write prose in the language of the existing README, or English by default. Keep code and config in English.
- Give each API at least one runnable example, and explain return values in comments, for example `// int`.
- List each config key with its type and default. Do not only paste the config file.
- Put global settings such as Session SameSite, CSRF exclusion for notify URLs, and payment callbacks in Notes, with complete code.
- Use the Composer name `lyrasoft/<package-name>` in commands. When it differs from the GitHub repo name, the Composer name wins.
- Always load language with `\Lyrasoft\<Namespace>\<Namespace>Package::class`, not a package-name string.
- Replace payment test keys, passwords, and hash keys in examples with placeholders. Never keep real values.
- Do not describe unfinished features as available. If a feature is unfinished, mark it `WIP` and state its status.

## Common Problems in Existing READMEs

Reviewing 20 READMEs in the `lyrasoft` organization showed these problems to avoid:

- Copying another package's section, so `loadAllFromVendor` points to the wrong package. For example, the event booking README loads the shopgo language.
- Outdated code, such as mixing `$this->trans`, `$app->retrieve`, and `$app->service` in one README.
- Inconsistent section order, and some READMEs lack installation or language sections.
- Inconsistent terms and typos, such as `poilicy`, and `Ecpay` mixed with `ECPay`.
- Real payment test keys left in examples. Do not copy them.

## Verification

After finishing, check each item:

- [ ] All `<!-- agent: -->` comments and `{{ }}` placeholders are removed.
- [ ] Each `-t` flag in `pkg:install` matches a directory that exists in the package.
- [ ] Routes, menu names, and config keys mentioned in the README exist in the code.
- [ ] Examples contain no real keys and no local paths.
- [ ] Inapplicable sections are deleted, with no empty headings.
