# FN-002: SmsGateway trait patches

Apply to **both** files (same content):

- `Modules/Traits/SmsGateway.php` (Gateways addon)
- `app/Traits/SmsGateway.php` (core fallback)

## 1. In `send()` method

**After** the `alphanet_sms` block, **before** `return 'not_found';`

Insert: `snippets/send-hook.php`

## 2. Before `get_settings()` method

Insert: `snippets/ipcallbd-method.php`
