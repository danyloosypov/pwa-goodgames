<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\ArticleRepository;
use App\Repositories\ArticleRepositoryInterface;
use App\Policies\ArticlePolicy;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(\App\Contracts\PaymentProcessorFactoryInterface::class, \App\Services\PaymentProcessorFactory::class);
        date_default_timezone_set('Europe/Kyiv');

        $this->app->bind(ArticleRepositoryInterface::class, ArticleRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('create-article',		[ArticlePolicy::class, 'create']);
        Gate::define('update-article',		[ArticlePolicy::class, 'update']);
    }
}
