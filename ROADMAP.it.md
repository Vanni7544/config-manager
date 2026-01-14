# 🛠 Config Manager — Roadmap di Prodotto

Questo documento descrive l’evoluzione pianificata di **Config Manager for Laravel**.

L’obiettivo è rendere la gestione del file `.env`:
✔ sicura  
✔ prevedibile  
✔ reversibile  
✔ facile da usare per gli sviluppatori  

mantenendo sempre lo strumento semplice e intenzionale — *senza magia e senza comportamenti nascosti.*

---

## ✅ Fase 1 — Core Stabile (Versione Attuale)

🎯 Obiettivo: fornire una **base solida e sicura** per la gestione delle configurazioni di ambiente.

### ✔ Funzionalità già implementate

- Esportazione configurazione ambiente in `.env.config-manager`
- Validazione rigorosa prima dell’export
- Avviso di sicurezza in produzione
- Applicazione sicura del `.env` tramite `--apply`
- Backup automatico del `.env` prima della sovrascrittura
- Rollback dell’ultimo `.env` applicato (`--rollback`)
- Limite di retention dei backup
- Supporto Laravel 10 / 11 / 12
- Licenza MIT e documentazione

Config Manager oggi aiuta già a prevenire:  
⚠ sovrascritture accidentali  
⚠ variabili mancanti  
⚠ modifiche rischiose in produzione  

---

## 🚧 Fase 2 — Pro Edition (Prossimo Focus)

🎯 Obiettivo: migliorare **controllo, tracciabilità, sicurezza e onboarding**.

### 🔜 Funzionalità pianificate

#### 1️⃣ Log Locali delle Operazioni

Registrare ogni azione critica:

- export  
- apply  
- rollback  
- errori di validazione  
- conferme e avvisi  

I log restano **solo in locale** — nessun SaaS, nessuna trasmissione esterna.

**Formato esempio:**

```bash
[2026-01-10 12:33:10] APPLY — project=1 env=production user=cli backup=.env.backup.20260110_123310
```

**Benefici:**

✔ responsabilità  
✔ debug più semplice  
✔ cronologia completa delle azioni  

---

#### 2️⃣ Rollback — Scelta del Backup

Permettere di selezionare **quale backup ripristinare** — non solo l’ultimo.

**Esempio:**

```bash
php artisan config-manager:rollback
```

→ elenco dei backup  
→ l’utente sceglie  
→ ripristino sicuro  

---

#### 3️⃣ CRUD da Terminale — Senza Tinker

Una CLI semplice e chiara per gestire:

- progetti  
- ambienti  
- variabili  
- valori  

Stile: **UX da terminale pulita, leggermente vintage — senza GUI, senza wizard.**

**Esempi:**

```bash
php artisan config-manager:project:create
php artisan config-manager:env:add
php artisan config-manager:var:add
```

**Obiettivi:**

✔ onboarding più semplice  
✔ maggiore chiarezza  
✔ sicurezza coerente  

---

## 🛡 Fase 3 — Security / Enterprise Edition

🎯 Obiettivo: **controllo di livello enterprise, audit e compliance.**

### 🔐 Funzionalità pianificate

#### 🔸 Policy Dichiarative di Ambiente

Definire regole e requisiti come:

- variabili obbligatorie  
- valori vietati  
- validazione tramite regex  
- regole specifiche per ambiente  

**Esempio:**

```env
APP_DEBUG=false    # regola per la produzione
```

---

#### 🔸 Dry-Run leggibile

Permettere di vedere cosa cambierà **prima** di applicarlo:

```bash
config-manager apply production --dry-run
```

Mostrando:

- variabili aggiunte  
- variabili rimosse  
- variabili modificate  

---

#### 🔸 Audit Trail Strutturato

Log **leggibili dall’uomo e dalle macchine**  
per team, audit e flussi di compliance.

---

#### 🔸 Integrazione CI/CD

Validazione automatica durante il deploy con:

- GitHub Actions  
- GitLab CI  
- Bitbucket Pipelines  

La validazione deve **fallire in modo sicuro** se mancano variabili richieste.

---

#### 🔸 Strumento di Diff per versioni `.env`

Confronto tra due snapshot o backup:

```bash
config-manager diff --from=backup_20260110 --to=current
```

---

## 🚫 Cosa Questo Progetto NON Farà

Per rimanere sicuro e prevedibile:

❌ Nessuna gestione cloud remota  
❌ Nessun aggiornamento automatico silenzioso  
❌ Nessun lock-in  
❌ Nessun comportamento nascosto  

Config Manager sarà sempre:
✔ locale  
✔ esplicito  
✔ reversibile  

---

## 💬 Feedback & Idee

Se utilizzi questo software e desideri suggerire miglioramenti,
puoi contattare l’autore tramite la **stessa piattaforma da cui lo hai ottenuto**.

Le issue e le pull request GitHub sono intenzionalmente disabilitate,
per mantenere uno sviluppo coerente e intenzionale del progetto.

---

## 📜 Licenza

Questo progetto è rilasciato sotto **licenza MIT**.

Il codice sorgente può essere utilizzato, modificato e redistribuito
nel rispetto dei termini della licenza MIT.

👉 **La versione inglese di questo documento è quella legalmente vincolante.**
