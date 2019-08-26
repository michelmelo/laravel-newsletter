<?php

namespace Leeovery\LaravelNewsletter;

class NullDriver implements Newsletter
{
    /**
     * @param  string        $email
     * @param  array|string  $listNames
     * @param  array         $attributes
     * @return mixed
     */
    public function subscribe(string $email, $listNames = [], array $attributes = [])
    {
        // TODO: Implement subscribe() method.
    }

    public function unsubscribe()
    {
        // TODO: Implement unsubscribe() method.
    }

    public function sendCampaign()
    {
        // TODO: Implement sendCampaign() method.
    }

    public function updateEmailAddress()
    {
        // TODO: Implement updateEmailAddress() method.
    }

    public function getApi()
    {
        // TODO: Implement getApi() method.
    }
}