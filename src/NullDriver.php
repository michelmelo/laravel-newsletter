<?php

namespace Leeovery\LaravelNewsletter;

use Illuminate\Support\Carbon;

class NullDriver implements Newsletter
{
    /**
     * @param  string             $email
     * @param  array|string|null  $listNames
     * @param  array              $attributes
     * @return mixed
     */
    public function subscribe(string $email, $listNames = null, array $attributes = [])
    {
        // TODO: Implement subscribe() method.
    }

    /**
     * @param  string  $email
     * @return mixed
     */
    public function unsubscribe(string $email)
    {
        // TODO: Implement unsubscribe() method.
    }

    /**
     * @param  string             $email
     * @param  array|string|null  $listNames
     * @return mixed
     */
    public function addToLists(string $email, $listNames = null)
    {
        // TODO: Implement addToLists() method.
    }

    /**
     * @param  string             $email
     * @param  array|string|null  $listNames
     * @return mixed
     */
    public function removeFromLists(string $email, $listNames = null)
    {
        // TODO: Implement removeFromLists() method.
    }

    /**
     * @param  string             $campaignName
     * @param  string             $fromEmail
     * @param  string             $fromName
     * @param  string             $htmlContent
     * @param  string             $subject
     * @param  string             $replyTo
     * @param  string|array|null  $listNames
     * @param  Carbon|null        $scheduledAt
     * @return bool
     */
    public function sendCampaign(
        string $campaignName,
        string $fromEmail,
        string $fromName,
        string $htmlContent,
        string $subject,
        string $replyTo,
        $listNames = null,
        Carbon $scheduledAt = null
    ) {
        // TODO: Implement sendCampaign() method.
    }

    /**
     * @param  string  $oldEmail
     * @param  string  $newEmail
     * @return mixed
     */
    public function updateEmailAddress(string $oldEmail, string $newEmail)
    {
        // TODO: Implement updateEmailAddress() method.
    }

    public function getApi()
    {
        // TODO: Implement getApi() method.
    }
}