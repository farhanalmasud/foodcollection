<?php

namespace Modules\IpCallBdSms\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IpCallBdSmsSender
{
    public static function send(string $receiver, string $otp, ?array $config = null): string
    {
        if (!$config) {
            $data = config_settings('ipcallbd_sms', 'sms_config');
            $config = $data && $data->live_values
                ? (is_array($data->live_values) ? $data->live_values : json_decode($data->live_values, true))
                : null;
        }

        if (!$config || (int) ($config['status'] ?? 0) !== 1) {
            return 'error';
        }

        $apiKey = trim((string) ($config['api_key'] ?? ''));
        if ($apiKey === '') {
            return 'error';
        }

        $message = str_replace('#OTP#', $otp, $config['otp_template'] ?? 'Your OTP is #OTP#');
        $mobile = self::normalizeMobile($receiver);

        if ($mobile === '') {
            return 'error';
        }

        try {
            $response = Http::timeout(30)
                ->acceptJson()
                ->asJson()
                ->post('https://portal.ipcall.bd/smsapi/send', [
                    'api_key' => $apiKey,
                    'mobiles' => [$mobile],
                    'message' => $message,
                ]);

            if ($response->successful() && $response->json('success') === true) {
                return 'success';
            }

            Log::warning('IpCallBdSms: send failed', [
                'mobile' => $mobile,
                'body' => $response->json(),
            ]);
        } catch (\Throwable $exception) {
            Log::error('IpCallBdSms: ' . $exception->getMessage());
        }

        return 'error';
    }

    public static function normalizeMobile(string $receiver): string
    {
        $mobile = preg_replace('/\D+/', '', $receiver);

        if (str_starts_with($mobile, '880')) {
            $mobile = '0' . substr($mobile, 3);
        }

        if ($mobile !== '' && !str_starts_with($mobile, '0')) {
            $mobile = '0' . $mobile;
        }

        return $mobile;
    }
}
