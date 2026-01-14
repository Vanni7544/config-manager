# Changelog — Config Manager for Laravel

All notable changes to this project will be documented in this file.

The format is based on common standards such as Keep a Changelog.
Version numbers follow a simple semantic pattern.

---

## [1.1.0] — 2025-12-31

### Added

- Automatic `.env` backup before applying changes
- Rollback support via `--rollback` option
- Validation layer to ensure required variables are present
- Production warning when exporting a production environment
- Configurable backup retention limit
- Support for multi-environment configuration storage
- Contract-based Env Exporter service
- `config-manager:export` Artisan command
- Support for Laravel 10 / 11 / 12
- MIT license
- Italian + English documentation

### Changed

- Improved safety messaging and UX during export/apply
- Internal refactoring for better structure and maintainability

### Fixed

- Minor stability and edge-case behavior improvements

---

## [1.0.0] — 2025-12-19

### Initial Release

- Environment configuration export
- Environment variable storage per project/environment
- `.env.config-manager` file generation
- Blade-free, console-focused workflow
