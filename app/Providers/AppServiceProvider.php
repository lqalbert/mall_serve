<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            
            
            
            Log::debug('[sql]', ['sql'=>str_replace(array_keys($query->bindings), array_values($query->bindings), $query->sql), 'bindings'=>$query->bindings, 'time'=>$query->time, 'connection'=>$query->connectionName]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
