<?php

namespace Leeovery\LaravelNewsletter\Exceptions;

use Exception;

class LaravelNewsletterException extends Exception
{
    public static function defaultListDoesNotExist($defaultList)
    {
        return new static("Default list ({$defaultList}) does not existing.");
    }

    public static function noListWithName($name)
    {
        return new static("The list named '{$name}' does not exist.");
    }

    public static function subscribeFailed(string $message)
    {
        return new static("Subscribe failed with message: {$message}");
    }

    public static function unsubscribeFailed(string $message)
    {
        return new static("Unsubscribe failed with message: {$message}");
    }

    public static function addToListsFailed(string $message)
    {
        return new static("Adding contact to list(s) failed with message: {$message}");
    }

    public static function removeFromListsFailed(string $message)
    {
        return new static("Removing contact to list(s) failed with message: {$message}");
    }

    public static function updateEmailAddressFailed(string $message)
    {
        return new static("Updating user's email address failed with message: {$message}");
    }
}