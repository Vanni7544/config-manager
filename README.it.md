# Config Manager per Laravel

![PHP](https://img.shields.io/badge/PHP-%5E8.2-blue)
![Laravel](https://img.shields.io/badge/Laravel-10%2B-red)
![License](https://img.shields.io/badge/License-MIT-green)

Gestisci in modo sicuro più configurazioni `.env` nei tuoi progetti Laravel.

Config Manager ti permette di **esportare, validare, applicare e ripristinare**
file di configurazione `.env` — riducendo al minimo il rischio di rompere
l’applicazione in produzione.

---

## 🚨 Perché esiste

Gestire manualmente i file `.env` tra ambienti diversi
(local, staging, production) è rischioso.

Un singolo errore può:

- bloccare l’applicazione
- esporre segreti
- causare downtime

Config Manager rende i cambi di configurazione:

- **espliciti**
- **reversibili**
- **sicuri di default**

---

## 🔐 Garanzie di sicurezza

Config Manager garantisce che:

✔ Il tuo `.env` **non viene mai modificato**
a meno che tu non usi esplicitamente `--apply`

✔ Ogni modifica applicata crea **un backup automatico**

✔ Puoi **fare rollback** in qualsiasi momento

✔ Le variabili richieste vengono **validate prima dell’export**

✔ Gli ambienti di produzione mostrano **avvisi chiari ed espliciti**

Nessuna modifica nascosta.  
Nessuna sovrascrittura silenziosa.

---

## 🛠 Requisiti

- PHP 8.2+
- Laravel 10+

---

## 📦 Installazione

Installa il pacchetto con Composer:

```bash
composer require vanni/config-manager
```

Le migrazioni vengono caricate automaticamente.

---

## 🚀 Utilizzo base

### Esportare la configurazione di un progetto/ambiente

```bash
php artisan config-manager:export <project-id> <environment-id>
```

Questo comando genera un file:

```bash
.env.config-manager
```

> **Nota:**  
> Il file `.env` esistente **non viene modificato**.

---

### Applicare subito la configurazione (con backup automatico)

```bash
php artisan config-manager:export <project-id> <environment-id> --apply
```

Questo comando:

✔ crea un backup del `.env` corrente  
✔ applica il nuovo `.env` generato  

---

### Ripristinare l’ultimo `.env` di backup

```bash
php artisan config-manager:export --rollback
```

---

## ⚠️ Ambienti di produzione

Quando esporti un ambiente segnato come **produzione**,  
Config Manager mostra un **avviso chiaro** prima di applicare qualsiasi modifica.

---

## 📁 Backup automatici

I backup vengono salvati in:

```bash
.env.backups/
```

e vengono gestiti automaticamente.

---

## 📌 Note importanti

- Non modificare manualmente `.env.config-manager`
- Usa sempre i comandi di export/apply/rollback
- Il rollback funziona solo se è stato creato almeno un backup

---

## 🛡 Licenza

Questo progetto è rilasciato sotto **licenza MIT**.

La versione Base fornisce funzionalità essenziali per una gestione
sicura e controllata dei file `.env`.

Funzionalità avanzate come audit, controlli di sicurezza estesi
e flussi guidati sono disponibili nella **Config Manager Pro**.

👉 **La versione inglese di questa documentazione è quella legalmente valida.**
