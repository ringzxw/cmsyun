<?php

namespace App\Providers;

use App\Services\EmployeeService;
use App\Services\PermissionService;
use App\Services\QueryService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        \Carbon\Carbon::setLocale('zh');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        $this->app->bind('permissionService', function () {
            return new PermissionService();
        });
        $this->app->bind('queryService', function () {
            return new QueryService();
        });
        $this->app->bind('employeeService', function () {
            return new EmployeeService();
        });
    }
}
