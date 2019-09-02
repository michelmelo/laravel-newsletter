<?php

namespace Leeovery\LaravelNewsletter\Contracts;

use Illuminate\Support\Carbon;
use Leeovery\LaravelNewsletter\Exceptions\LaravelNewsletterException;

interface Newsletter
{
    /**
     * @param  string             $email
     * @param  array|string|null  $listNames
     * @param  array              $attributes
     * @return bool
     * @throws LaravelNewsletterException
     */
    public function subscribe(string $email, $listNames = null, array $attributes = []);

    /**
     * @param  string  $email
     * @return bool
     * @throws LaravelNewsletterException
     */
    public function unsubscribe(string $email);

    /**
     * @param  string  $email
     * @return mixed
     * @throws LaravelNewsletterException
     */
    public function resubscribe(string $email);

    /**
     * @param  string             $email
     * @param  array|string|null  $listNames
     * @return bool
     * @throws LaravelNewsletterException
     */
    public function addToLists(string $email, $listNames = null);

    /**
     * @param  string             $email
     * @param  array|string|null  $listNames
     * @return bool
     * @throws LaravelNewsletterException
     */
    public function removeFromLists(string $email, $listNames = null);

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
     * @throws LaravelNewsletterException
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
    );

    /**
     * Will return the contact record from the provider. If user is not
     * present then false will be returned.
     *
     * @param  string  $email
     * @return mixed
     * @throws LaravelNewsletterException
     */
    public function getContact(string $email);

    /**
     * @param  string    $email
     * @param  null|int  $listId
     * @return mixed
     * @throws LaravelNewsletterException
     */
    public function isSubscribed(string $email, $listId = null);

    /**
     * @param  string  $oldEmail
     * @param  string  $newEmail
     * @return bool
     * @throws LaravelNewsletterException
     */
    public function updateEmailAddress(string $oldEmail, string $newEmail);

    public function getApi();
}