<?php

namespace Modules\IpCallBdSms\Providers;

use Illuminate\Support\ServiceProvider;

class IpCallBdSmsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(module_path('IpCallBdSms', 'Database/Migrations'));
    }

    public function register(): void
    {
    }
}
