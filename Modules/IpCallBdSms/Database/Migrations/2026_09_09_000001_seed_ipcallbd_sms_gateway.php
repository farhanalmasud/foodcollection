<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $defaults = [
            'gateway' => 'ipcallbd_sms',
            'mode' => 'test',
            'status' => 0,
            'api_key' => '',
            'otp_template' => 'Your OTP is #OTP#',
        ];

        $payload = json_encode($defaults);
        $now = now();

        DB::table('addon_settings')->updateOrInsert(
            ['key_name' => 'ipcallbd_sms', 'settings_type' => 'sms_config'],
            [
                'live_values' => $payload,
                'test_values' => $payload,
                'mode' => 'test',
                'is_active' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );
    }

    public function down(): void
    {
        DB::table('addon_settings')
            ->where('key_name', 'ipcallbd_sms')
            ->where('settings_type', 'sms_config')
            ->delete();
    }
};
