# FN-002: SMS_module.php patch

File: `app/CentralLogics/SMS_module.php` (capital S — matches `composer.json`)

## 1. In `send()` method

After `alphanet_sms` block, before `return 'not_found';`

Insert: `snippets/send-hook.php`

## 2. Before `get_settings()` method

Insert: `snippets/ipcallbd-method-sms-module.php`
