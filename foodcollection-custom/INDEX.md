# Customization index

| ID | Title | Module folder | Patches | Status |
|----|-------|---------------|---------|--------|
| FN-002 | IP Call BD SMS gateway | `modules/IpCallBdSms/` | `patches/FN-002-ipcallbd-sms/` | active |

## FN-002 summary

- **API:** `https://portal.ipcall.bd/smsapi/send`
- **Config key:** `ipcallbd_sms`
- **Admin SMS (Gateways on):** `/admin/sms/configuration/addon-sms-get`
- **Admin SMS (core):** `/admin/business-settings/third-party/sms-module`

## Version log

| Date | SOFTWARE_VERSION | Verified by |
|------|------------------|-------------|
| 2026-09-09 | — | IP Call BD SMS working on production |
| 2026-10-09 | 4.1 | Re-applied FN-002 to `SMS_module.php` after update wiped hooks (OTP “Failed to send sms”) |

## Critical note (SMS path)

OTP / password-recovery uses `SMS_module::send()` when Gateways is not published
(`get_payment_publish_status` looks for `Modules/Gateways/`). After every 6amMart
update, **confirm** `app/CentralLogics/SMS_module.php` still has FN-002 markers.
