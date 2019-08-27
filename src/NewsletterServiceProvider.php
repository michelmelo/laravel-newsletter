<?php

namespace Leeovery\LaravelNewsletter;

use Illuminate\Support\ServiceProvider;

class NewsletterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('newsletter.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'newsletter');

        // Register the main class to use with the facade
        $this->app->singleton('newsletter', function ($app) {
            return new NewsletterManager($app,
                NewsletterListCollection::createFromConfig(config('newsletter')),
                config('newsletter')
            );
        });

        $this->app->alias(Newsletter::class, 'newsletter');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['newsletter'];
    }
}
