// FC-CUSTOM-START [FN-002: ipcallbd-sms]
        $config = self::get_settings('ipcallbd_sms');
        if (isset($config) && $config['status'] == 1) {
            return self::ipcallbd_sms($receiver, $otp);
        }
        // FC-CUSTOM-END [FN-002]
