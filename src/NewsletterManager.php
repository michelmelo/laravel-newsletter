<?php

namespace Leeovery\LaravelNewsletter;

use Illuminate\Support\Arr;
use Illuminate\Support\Manager;
use GuzzleHttp\Client as HttpClient;

class NewsletterManager extends Manager
{
    private NewsletterListCollection $listCollection;

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

    public function createSendInBlueDriver(): SendInBlueProvider
    {
        return new SendInBlueProvider(
            $this->guzzle(),
            $this->listCollection,
            $this->config->get('newsletter.credentials')
        );
    }

    protected function guzzle(): HttpClient
    {
        return new HttpClient(Arr::add(
            $this->config->get('newsletter.provider_options.guzzle', []),
            'connect_timeout', 60
        ));
    }

    public function getDefaultDriver(): string
    {
        return 'null'; //$this->config->get('newsletter.driver', 'null');
    }
}
