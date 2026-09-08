# IP Call BD SMS — FoodCollection Addon

Adds **IP Call BD SMS** (`ipcallbd_sms`) to the 6amMart SMS gateway system.

## API

- URL: `https://portal.ipcall.bd/smsapi/send`
- Method: POST (JSON)
- Fields: `api_key`, `mobiles` (array), `message`

## Install

1. Upload `releases/IpCallBdSms.zip` on **System Addons** page (or deploy via git)
2. Enable in `modules_statuses.json`: `"IpCallBdSms": true`
3. Run: `php artisan migrate --force && php artisan optimize:clear`
4. Activate addon on System Addons page
5. Configure at **Business Settings → Third Party → SMS Module**
   - Or if Gateways addon is active: `/admin/sms/configuration/addon-sms-get`

## Configure

| Field | Description |
|-------|-------------|
| api_key | Your IP Call BD API key |
| otp_template | Use `#OTP#` placeholder, e.g. `Your OTP is #OTP#` |

Enable **Active**, save, and disable other SMS gateways.

## Requires

Small hooks in `Modules/Traits/SmsGateway.php` and `SMSConfigController.php` (documented as FN-002). Re-apply after 6amMart updates.
