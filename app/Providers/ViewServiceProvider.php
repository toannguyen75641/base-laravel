<?php

namespace App\Providers;

use App\Constants\AdminUserConstant;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the view services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            $auth = request()->user();
            $name = '';
            if ($auth) {
                $name = $auth->name;
            }

            $view->with('auth', [
                AdminUserConstant::INPUT_NAME => $name
            ]);
        });
    }
}
