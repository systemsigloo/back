<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class PassportServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        //Passport::routes();
    }
}
