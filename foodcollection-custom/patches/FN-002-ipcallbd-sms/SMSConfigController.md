# FN-002: SMSConfigController patch

File: `Modules/Http/Controllers/SMSConfigController.php`

## 1. Add import (top of file)

```php
use Modules\IpCallBdSms\Services\IpCallBdSmsRegistrar;
```

## 2. In `sms_config_get()` — before loading data

```php
        try {
            IpCallBdSmsRegistrar::ensureRegistered();
        } catch (\Throwable) {
        }
```

## 3. In `sms_config_set()` validation gateway list

Add `ipcallbd_sms` to the `in:` rule:

```
...,alphanet_sms,ipcallbd_sms
```

## 4. After `alphanet_sms` elseif block

```php
        // FC-CUSTOM-START [FN-002: ipcallbd-sms]
        } elseif ($request['gateway'] == 'ipcallbd_sms') {
            $additional_data = [
                'status' => 'required|in:1,0',
                'api_key' => 'required',
                'otp_template' => 'required',
            ];
        }
        // FC-CUSTOM-END [FN-002]
```

## 5. In disable-other-gateways foreach

Add `'ipcallbd_sms'` to the gateway array.
