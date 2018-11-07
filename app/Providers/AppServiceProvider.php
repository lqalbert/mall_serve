<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Console\Commands\Deposit2;
use App\Models\DepositSet2;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        DB::listen(function ($query) {
            // $query->sql
            // $query->bindings
            // $query->time
            
            
            
            Log::debug('[sql]', ['sql'=>$query->sql, 'bindings'=>$query->bindings, 'time'=>$query->time, 'connection'=>$query->connectionName]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('DepositParam', function($app){
           return  DepositSet2::getInstance(); 
        });
    }
}
