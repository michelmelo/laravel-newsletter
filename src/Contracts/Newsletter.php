<?php

namespace Leeovery\LaravelNewsletter\Contracts;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Carbon;

interface Newsletter
{
    /**
     * @param  string             $email
     * @param  array|string|null  $listNames
     * @param  array              $attributes
     * @return bool
     */
    public function subscribe(string $email, $listNames = null, array $attributes = []);

    /**
     * @param  string  $email
     * @return bool
     */
    public function unsubscribe(string $email);

    /**
     * @param  string  $email
     * @return mixed
     */
    public function resubscribe(string $email);

    /**
     * @param  string             $email
     * @param  array|string|null  $listNames
     * @return bool
     */
    public function addToLists(string $email, $listNames = null);

    /**
     * @param  string             $email
     * @param  array|string|null  $listNames
     * @return bool
     */
    public function removeFromLists(string $email, $listNames = null);

    /**
     * @param  string             $campaignName
     * @param  string             $subject
     * @param  string             $htmlContent
     * @param  string|array|null  $listNames
     * @param  string|null        $fromEmail
     * @param  string|null        $fromName
     * @param  string|null        $replyTo
     * @param  Carbon|null        $scheduledAt
     * @return bool
     */
    public function sendCampaign(
        string $campaignName,
        string $subject,
        string $htmlContent,
        $listNames = null,
        $fromEmail = null,
        $fromName = null,
        $replyTo = null,
        Carbon $scheduledAt = null
    );

    /**
     * @param  Mailable           $mailable
     * @param  array|string|null  $listNames
     * @param  string|null        $fromEmail
     * @param  string|null        $fromName
     * @param  string|null        $replyTo
     * @param  Carbon|null        $scheduledAt
     * @param  string|null        $campaignName
     * @return mixed
     */
    public function sendMailableToList(
        Mailable $mailable,
        $listNames = null,
        $fromEmail = null,
        $fromName = null,
        $replyTo = null,
        Carbon $scheduledAt = null,
        $campaignName = null
    );

    /**
     * Will return the contact record from the provider. If user is not
     * present then false will be returned.
     *
     * @param  string  $email
     * @return mixed
     */
    public function getContact(string $email);

    /**
     * @param  string    $email
     * @param  null|int  $listId
     * @return mixed
     */
    public function isSubscribed(string $email, $listId = null);

    /**
     * @param  string  $oldEmail
     * @param  string  $newEmail
     * @return bool
     */
    public function updateEmailAddress(string $oldEmail, string $newEmail);

    public function getApi();
}