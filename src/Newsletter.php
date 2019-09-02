<?php

namespace Leeovery\LaravelNewsletter;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Facade;

/**
 * @method static bool subscribe(string $email, $listNames = null, array $attributes = [])
 * @method static bool unsubscribe(string $email)
 * @method static bool resubscribe(string $email)
 * @method static bool addToLists(string $email, $listNames = null)
 * @method static bool removeFromLists(string $email, $listNames = null)
 * @method static bool sendCampaign(string $campaignName, string $fromEmail, string $fromName, string $htmlContent, string $subject, string $replyTo, $listNames = null, Carbon $scheduledAt = null)
 * @method static bool getContact(string $email)
 * @method static bool isSubscribed(string $email, $listId = null)
 * @method static bool updateEmailAddress(string $oldEmail, string $newEmail)
 * @method static void getApi()
 *
 * @see \Leeovery\LaravelNewsletter\Contracts\Newsletter
 */
class Newsletter extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'newsletter';
    }
}
