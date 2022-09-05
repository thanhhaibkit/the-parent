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
        $this->app->singleton(
            \App\Services\TwitterAPIService::class,
            \App\Services\Impls\TwitterAPIServiceImpl::class
        );

        $this->app->singleton(
            \App\Services\TweetService::class,
            \App\Services\Impls\TweetServiceImpl::class
        );

        $this->app->singleton(
            \App\Services\UserService::class,
            \App\Services\Impls\UserServiceImpl::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
