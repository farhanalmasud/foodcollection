# FN-002: SMSModuleController patch

File: `app/Http/Controllers/Admin/SMSModuleController.php`

## 1. Add import

```php
use Modules\IpCallBdSms\Services\IpCallBdSmsRegistrar;
```

## 2. Start of `sms_index()`

```php
        try {
            IpCallBdSmsRegistrar::ensureRegistered();
        } catch (\Throwable) {
        }
```

## 3. whereIn query — add `ipcallbd_sms`

```php
->whereIn('key_name', ['twilio','nexmo','2factor','msg91','alphanet_sms','ipcallbd_sms'])
```

## 4. In `sms_update()` after alphanet_sms block

```php
        // FC-CUSTOM-START [FN-002: ipcallbd-sms]
        } elseif ($module == 'ipcallbd_sms' || $request['gateway'] == 'ipcallbd_sms') {
            $additional_data = [
                'status' => $request['status'],
                'api_key' => $request['api_key'],
                'otp_template' => $request['otp_template'],
            ];
        }
        // FC-CUSTOM-END [FN-002]
```

## 5. Disable-other-gateways foreach

Add `'ipcallbd_sms'` to the array.
