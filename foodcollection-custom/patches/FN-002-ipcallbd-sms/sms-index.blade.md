# FN-002: sms-index.blade.php patch

File: `resources/views/admin-views/business-settings/sms-index.blade.php`

Replace the card title line:

```blade
<h4 class="page-title">{{translate($gateway->key_name)}}</h4>
```

With:

```blade
<h4 class="page-title">
    @if($gateway->key_name === 'ipcallbd_sms')
        {{ translate('ipcallbd_sms') }}
    @else
        {{ translate($gateway->key_name) }}
    @endif
</h4>
```
