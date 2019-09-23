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
     * NewsletterManager constructor.
     *
     * @param                            $app
     * @param  NewsletterListCollection  $listCollection
     */
    public function __construct($app, NewsletterListCollection $listCollection)
    {
        parent::__construct($app);
        $this->listCollection = $listCollection;
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
            $this->config->get('newsletter.credentials')
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
            $this->config->get('newsletter.provider_options.guzzle', []),
            'connect_timeout', 60
        ));
    }

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->config->get('newsletter.driver', 'null');
    }
}
