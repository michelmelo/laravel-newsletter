<?php

namespace Leeovery\LaravelNewsletter;

interface Newsletter
{
    /**
     * @param  string             $email
     * @param  array|string|null  $listNames
     * @param  array              $attributes
     * @return mixed
     */
    public function subscribe(string $email, $listNames = null, array $attributes = []);

    /**
     * @param  string  $email
     * @return mixed
     */
    public function unsubscribe(string $email);

    /**
     * @param  string             $email
     * @param  array|string|null  $listNames
     * @return mixed
     */
    public function addToLists(string $email, $listNames = null);

    /**
     * @param  string             $email
     * @param  array|string|null  $listNames
     * @return mixed
     */
    public function removeFromLists(string $email, $listNames = null);

    public function sendCampaign();

    /**
     * @param  string  $oldEmail
     * @param  string  $newEmail
     * @return mixed
     */
    public function updateEmailAddress(string $oldEmail, string $newEmail);

    public function getApi();
}