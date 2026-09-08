<?php

namespace Modules\IpCallBdSms\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\IpCallBdSms\Services\IpCallBdSmsRegistrar;

class IpCallBdSmsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(module_path('IpCallBdSms', 'Database/Migrations'));

        try {
            IpCallBdSmsRegistrar::ensureRegistered();
        } catch (\Throwable) {
            // DB may be unavailable during install; migration will seed on deploy.
        }
    }

    public function register(): void
    {
    }
}
