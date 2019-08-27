<?php

namespace Leeovery\LaravelNewsletter;

use Illuminate\Support\Arr;
use Illuminate\Support\Manager;
use GuzzleHttp\Client as HttpClient;

class NewsletterManager extends Manager
{
    /**
     * @var NewsletterListCollection
     */
    private $listCollection;

    /**
     * @var array
     */
    private $config;

    /**
     * NewsletterManager constructor.
     *
     * @param                            $app
     * @param  NewsletterListCollection  $listCollection
     * @param  array                     $config
     */
    public function __construct($app, NewsletterListCollection $listCollection, array $config)
    {
        parent::__construct($app);

        $this->listCollection = $listCollection;
        $this->config = $config;
    }

    /**
     * Create a Null Provider driver instance.
     */
    public function createNullDriver()
    {
        return new NullDriver;
    }

    /**
     * @return SendInBlueProvider
     */
    public function createSendInBlueDriver()
    {
        return new SendInBlueProvider(
            $this->guzzle(),
            $this->listCollection,
            $this->config['credentials']
        );
    }

    /**
     * Get a fresh Guzzle HTTP client instance.
     *
     * @return HttpClient
     */
    protected function guzzle()
    {
        return new HttpClient(Arr::add(
            $this->config['provider_options']['guzzle'] ?? [], 'connect_timeout', 60
        ));
    }

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->app['config']['newsletter.driver'] ?? 'null';
    }
}
