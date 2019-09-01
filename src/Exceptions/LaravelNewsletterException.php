<?php

namespace Leeovery\LaravelNewsletter\Exceptions;

use Exception;

class LaravelNewsletterException extends Exception
{
    public static function noListWithName($name)
    {
        throw new static("The list named '{$name}' does not exist.");
    }

    public static function subscribeFailed(string $message)
    {
        throw new static("Subscribe failed with message: {$message}");
    }

    public static function unsubscribeFailed(string $message)
    {
        throw new static("Unsubscribe failed with message: {$message}");
    }

    public static function addToListsFailed(string $message)
    {
        throw new static("Adding contact to list(s) failed with message: {$message}");
    }

    public static function removeFromListsFailed(string $message)
    {
        throw new static("Removing contact to list(s) failed with message: {$message}");
    }

    public static function updateEmailAddressFailed(string $message)
    {
        throw new static("Updating user's email address failed with message: {$message}");
    }

    public static function sendCampaignFailed(string $message)
    {
        throw new static("Sending campaign failed with message: {$message}");
    }

    public static function getContactFailed(string $message)
    {
        throw new static("Fetching the contact record failed with message: {$message}");
    }

    public static function isSubscribedFailed(string $message)
    {
        throw new static("Check subscription status of user failed with message: {$message}");
    }
}