<?php

namespace App\Providers;

use App\Constants\CouponMasterConstant;
use Illuminate\Support\ServiceProvider;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use App\Constants\BusinessUserConstant;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('path.public', function () {
            return base_path('/../../../htdocs/https');
        });

        HeadingRowFormatter::extend('BusinessUser', function($value) {
            foreach(BusinessUserConstant::CSV_HEADER as $key => $heading) {
                if($heading == $value) {
                    return $key;
                }
            }
        });

        HeadingRowFormatter::extend('CouponMaster', function($value) {
            foreach (CouponMasterConstant::HEADER_CSV as $key => $heading) {
                if ($heading == $value) {
                    return $key;
                }
            }
        });
    }
}
