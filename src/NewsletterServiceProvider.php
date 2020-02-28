<?php

namespace Leeovery\LaravelNewsletter;

use Illuminate\Support\ServiceProvider;

class NewsletterServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('newsletter.php'),
            ], 'config');
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'newsletter');

        $this->app->singleton('newsletter', function ($app) {
            return new NewsletterManager($app,
                NewsletterListCollection::createFromConfig(config('newsletter'))
            );
        });
    }

    public function provides()
    {
        return ['newsletter'];
    }
}
