# Apply customizations after 6amMart update

Use this checklist every time you upload a new version from CodeCanyon.

---

## Before update

- [ ] Backup database + `.env`
- [ ] Note current `SOFTWARE_VERSION` in `.env`
- [ ] Export `foodcollection-custom/` (already in git)
- [ ] **Do not use `git clean`**

---

## Step 1 — Update script

Upload/replace 6amMart files via admin updater or manual zip.

---

## Step 2 — Restore custom modules

```bash
cd /path/to/portal.foodcollections.com
bash foodcollection-custom/scripts/apply.sh
```

This copies `foodcollection-custom/modules/*` → `Modules/` and runs migrate.

---

## Step 3 — Enable modules

Edit `modules_statuses.json` — ensure these are `true`:

```json
"IpCallBdSms": true
```

(See `config/modules_statuses.additions.json` for full merge.)

---

## Step 4 — Apply core patches (FN-002)

Search for markers — if missing, re-apply from `patches/FN-002-ipcallbd-sms/`:

```bash
rg "FC-CUSTOM" --glob '!foodcollection-custom/**'
```

| File | What to add |
|------|-------------|
| `Modules/Traits/SmsGateway.php` | `send-hook.php` + `ipcallbd-method.php` |
| `app/Traits/SmsGateway.php` | Same as Gateways trait |
| `app/CentralLogics/SMS_module.php` | Same hooks + method |
| `Modules/Http/Controllers/SMSConfigController.php` | See `SMSConfigController.md` |
| `app/Http/Controllers/Admin/SMSModuleController.php` | See `SMSModuleController.md` |
| `resources/views/admin-views/business-settings/sms-index.blade.php` | See `sms-index.blade.md` |
| `resources/lang/en/messages.php` | Add `'ipcallbd_sms' => 'IP Call BD SMS'` |
| `resources/lang/bn/messages.php` | Same |

**Easiest:** Tell Cursor → *"Apply all patches from foodcollection-custom/patches/"*

---

## Step 5 — Clear cache

```bash
php artisan migrate --force
php artisan optimize:clear
composer dump-autoload
```

**Never run:** `git clean -fd`

---

## Step 6 — Verify

- [ ] System Addons → **IpCallBdSms** active
- [ ] SMS config → **IP Call BD SMS** visible
- [ ] `POST /api/v1/auth/login` → OTP SMS sends
- [ ] Admin login works

---

## Step 7 — Update INDEX

Mark items in `INDEX.md` as verified with new script version + date.
