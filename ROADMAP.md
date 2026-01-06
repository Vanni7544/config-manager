# 🛠 Config Manager — Product Roadmap

This document describes the planned evolution of **Config Manager for Laravel**.

The goal is to make `.env` management:
✔ safe  
✔ predictable  
✔ reversible  
✔ developer-friendly  

while keeping the tool simple and intentional — *no magic, no hidden behavior.*

---

## ✅ Phase 1 — Stable Core (Current Release)

🎯 Goal: provide a **safe foundation** for managing environment configuration.

### ✔ Already implemented

- Export environment configuration to `.env.config-manager`
- Strict validation before export
- Production safety warning
- Apply `.env` safely via `--apply`
- Automatic `.env` backup before overwrite
- Rollback of last applied `.env` (`--rollback`)
- Backup retention limit
- Support for Laravel 10 / 11 / 12
- Commercial licensing & documentation

Config Manager today already helps prevent:  
⚠ accidental overwrites  
⚠ missing environment variables  
⚠ risky manual edits in production  

---

## 🚧 Phase 2 — Pro Edition (Next Focus)

🎯 Goal: improve **control, traceability, safety and onboarding**.

### 🔜 Planned features

#### 1️⃣ Local Audit Logs

Log every critical action:

- export  
- apply  
- rollback  
- validation failures  
- confirmations & warnings  

Stored **locally only** — no SaaS, no remote calls.

**Example format:**

```bash
[2026-01-10 12:33:10] APPLY — project=1 env=production user=cli backup=.env.backup.20260110_123310
```

**Benefits:**
✔ accountability  
✔ easier debugging  
✔ full history of actions  

---

#### 2️⃣ Rollback — Select Backup

Allow selecting the backup to restore — not only the latest one.

**Example:**

```bash
php artisan config-manager:rollback
```

→ list backups  
→ user selects  
→ restore safely  

---

#### 3️⃣ Terminal CRUD — No Tinker Required

A simple, developer-friendly CLI to manage:

- projects  
- environments  
- variables  
- values  

Style: **clean, slightly-vintage terminal UX — no GUI, no wizard.**

**Examples:**

```bash
php artisan config-manager:project:create
php artisan config-manager:env:add
php artisan config-manager:var:add
```

**Goals:**
✔ easier onboarding  
✔ better clarity  
✔ consistent safety  

---

## 🛡 Phase 3 — Security / Enterprise Edition

🎯 Goal: **enterprise-grade control, auditability & compliance**.

### 🔐 Planned features

#### 🔸 Declarative Environment Policies

Define environment expectations such as:

- required variables  
- forbidden values  
- regex-based validation  
- environment-specific rules  

**Example:**

```env
APP_DEBUG=false    # production rule
```

---

#### 🔸 Human-Readable Dry-Run Mode

Preview changes before applying:

```bash
config-manager apply production --dry-run
```

Output should show:

- added vars  
- removed vars  
- changed vars  

---

#### 🔸 Structured Audit Trail

Machine-readable **and** human-readable logs  
for teams, audits and compliance workflows.

---

#### 🔸 CI/CD Integration

Validate configs automatically during deployment via:

- GitHub Actions  
- GitLab CI  
- Bitbucket Pipelines  

Validation should **fail safely** when required variables are missing.

---

#### 🔸 Diff Tool for .env Versions

Compare two snapshots or backups:

```bash
config-manager diff --from=backup_20260110 --to=current
```

---

## 🚫 What This Project Will NOT Do

To remain safe & predictable:

❌ No remote cloud management  
❌ No silent automatic updates  
❌ No vendor lock-in  
❌ No hidden behavior  

Config Manager will always be:
✔ local  
✔ explicit  
✔ reversible  

---

## 💬 Feedback & Ideas

If you purchased this software and want to suggest improvements,  
please contact the author via the **same platform where you obtained it**  
(e.g., Gumroad).

GitHub issues and pull requests are intentionally disabled.

---

## 📜 Licensing

Config Manager is **commercial & proprietary software**.  
Redistribution of source code is not permitted.

The English version of this document is the legally binding one.
