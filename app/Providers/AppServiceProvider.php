<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        \Illuminate\Support\Facades\View::composer('layouts.admin.app', function ($view) {
            $latestInquiries = \App\Models\Inquiry::where('is_read', false)->latest()->take(5)->get();
            $view->with('latestInquiries', $latestInquiries);
        });
    }
}
