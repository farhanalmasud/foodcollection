<?php

namespace Modules\IpCallBdSms\Services;

use Illuminate\Support\Facades\DB;

class IpCallBdSmsRegistrar
{
    public static function ensureRegistered(): void
    {
        $exists = DB::table('addon_settings')
            ->where('key_name', 'ipcallbd_sms')
            ->where('settings_type', 'sms_config')
            ->exists();

        if ($exists) {
            return;
        }

        $defaults = [
            'gateway' => 'ipcallbd_sms',
            'mode' => 'test',
            'status' => 0,
            'api_key' => '',
            'otp_template' => 'Your OTP is #OTP#',
        ];

        $payload = json_encode($defaults);
        $now = now();

        DB::table('addon_settings')->insert([
            'key_name' => 'ipcallbd_sms',
            'settings_type' => 'sms_config',
            'live_values' => $payload,
            'test_values' => $payload,
            'mode' => 'test',
            'is_active' => 0,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
