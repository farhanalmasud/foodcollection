    // FC-CUSTOM-START [FN-002: ipcallbd-sms]
    public static function ipcallbd_sms($receiver, $otp): string
    {
        if (class_exists(\Modules\IpCallBdSms\Services\IpCallBdSmsSender::class)) {
            return \Modules\IpCallBdSms\Services\IpCallBdSmsSender::send(
                $receiver,
                $otp,
                self::get_settings('ipcallbd_sms')
            );
        }

        return 'error';
    }
    // FC-CUSTOM-END [FN-002]
