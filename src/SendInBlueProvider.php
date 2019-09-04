<?php

namespace Leeovery\LaravelNewsletter;

use Exception;
use ReflectionException;
use Illuminate\Support\Arr;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use GuzzleHttp\Client as HttpClient;
use SendinBlue\Client\Configuration;
use SendinBlue\Client\Api\ContactsApi;
use SendinBlue\Client\Model\CreateContact;
use SendinBlue\Client\Model\UpdateContact;
use SendinBlue\Client\Api\EmailCampaignsApi;
use SendinBlue\Client\Model\AddContactToList;
use SendinBlue\Client\Model\CreateEmailCampaign;
use SendinBlue\Client\Model\RemoveContactFromList;
use Leeovery\LaravelNewsletter\Contracts\Newsletter;
use SendinBlue\Client\Model\GetExtendedContactDetails;
use Leeovery\LaravelNewsletter\Exceptions\LaravelNewsletterException;

class SendInBlueProvider implements Newsletter
{
    /**
     * @var NewsletterListCollection
     */
    private $lists;

    /**
     * @var Configuration
     */
    private $config;

    /**
     * @var HttpClient
     */
    private $guzzle;

    /**
     * @var array
     */
    private $credentials;

    /**
     * SendInBlueProvider constructor.
     *
     * @param  HttpClient                $guzzle
     * @param  NewsletterListCollection  $lists
     * @param  array                     $credentials
     */
    public function __construct(HttpClient $guzzle, NewsletterListCollection $lists, array $credentials)
    {
        $this->guzzle = $guzzle;
        $this->lists = $lists;
        $this->credentials = $credentials;
        $this->config = Configuration::getDefaultConfiguration()
                                     ->setApiKey('api-key', $credentials['api_key']);
    }

    /**
     * @param  string  $email
     * @return bool
     */
    public function unsubscribe(string $email)
    {
        try {
            $this->getContactsAPIInstance()->updateContact($email,
                new UpdateContact(['emailBlacklisted' => true])
            );

            return true;
        } catch (Exception $e) {
            throw LaravelNewsletterException::unsubscribeFailed($e->getMessage());
        }
    }

    /**
     * @return ContactsApi
     */
    private function getContactsAPIInstance(): ContactsApi
    {
        return new ContactsApi($this->guzzle, $this->config);
    }

    /**
     * @param  string             $email
     * @param  array|string|null  $listNames
     * @return bool
     */
    public function addToLists(string $email, $listNames = null)
    {
        try {

            $this->getListIdsFromNames($listNames)->each(function ($listId) use ($email) {
                $this->getContactsAPIInstance()->addContactToList(
                    $listId,
                    new AddContactToList(['emails' => [$email]])
                );
            });

            return true;
        } catch (Exception $e) {
            throw LaravelNewsletterException::addToListsFailed($e->getMessage());
        }
    }

    /**
     * @param $listNames
     * @return Collection
     */
    private function getListIdsFromNames($listNames): Collection
    {
        return collect(Arr::wrap($listNames ?: ''))->map(function ($name) {
            return $this->lists->findByName($name);
        })->map(function (NewsletterList $list) {
            return (int) $list->getId();
        });
    }

    /**
     * @param  string             $email
     * @param  array|string|null  $listNames
     * @param  array              $attributes
     * @return bool
     */
    public function subscribe(string $email, $listNames = null, array $attributes = [])
    {
        $createContact = new CreateContact([
            'email'            => $email,
            'listIds'          => $this->getListIdsFromNames($listNames)->all(),
            'emailBlacklisted' => false,
            'updateEnabled'    => true,
        ]);

        if (!empty($attributes)) {
            $createContact->setAttributes($attributes);
        }

        try {
            return optional(
                $this->getContactsAPIInstance()->createContact($createContact)
            )->getId() ?: true;
        } catch (Exception $e) {
            throw LaravelNewsletterException::subscribeFailed($e->getMessage());
        }
    }

    /**
     * @param  string             $email
     * @param  array|string|null  $listNames
     * @return bool
     */
    public function removeFromLists(string $email, $listNames = null)
    {
        try {

            $this->getListIdsFromNames($listNames)->each(function ($listId) use ($email) {
                $this->getContactsAPIInstance()->removeContactFromList(
                    $listId,
                    new RemoveContactFromList(['emails' => [$email]])
                );
            });

            return true;
        } catch (Exception $e) {
            throw LaravelNewsletterException::removeFromListsFailed($e->getMessage());
        }
    }

    /**
     * @param  string  $oldEmail
     * @param  string  $newEmail
     * @return bool
     */
    public function updateEmailAddress(string $oldEmail, string $newEmail)
    {
        try {
            $this->getContactsAPIInstance()->updateContact($oldEmail,
                new UpdateContact([
                    'attributes' => [
                        'EMAIL' => $newEmail,
                    ],
                ])
            );

            return true;
        } catch (Exception $e) {
            throw LaravelNewsletterException::updateEmailAddressFailed($e->getMessage());
        }
    }

    public function getApi()
    {
        return [
            'ContactsApi'       => $this->getContactsAPIInstance(),
            'EmailCampaignsApi' => $this->getCampaignAPIInstance(),
        ];
    }

    /**
     * @return EmailCampaignsApi
     */
    private function getCampaignAPIInstance(): EmailCampaignsApi
    {
        return new EmailCampaignsApi($this->guzzle, $this->config);
    }

    /**
     * @param  string    $email
     * @param  null|int  $listId
     * @return mixed
     */
    public function isSubscribed(string $email, $listId = null)
    {
        try {
            if (is_null($listId)) {
                return !$this->getContact($email)->getEmailBlacklisted();
            }

            return in_array($listId, value($contact = $this->getContact($email))->getListIds()) &&
                !$contact->getEmailBlacklisted();
        } catch (Exception $e) {
            if ($e->getCode() !== 404) {
                throw LaravelNewsletterException::isSubscribedFailed($e->getMessage());
            }
        }

        return false;
    }

    /**
     * Will return the contact record from the provider. If user is not
     * present then false will be returned.
     *
     * @param  string  $email
     * @return bool|GetExtendedContactDetails
     */
    public function getContact(string $email)
    {
        try {
            return $this->getContactsAPIInstance()->getContactInfo($email);
        } catch (Exception $e) {
            if ($e->getCode() !== 404) {
                throw LaravelNewsletterException::getContactFailed($e->getMessage());
            }
        }

        return false;
    }

    /**
     * @param  string  $email
     * @return mixed
     */
    public function resubscribe(string $email)
    {
        try {
            return $this->getContactsAPIInstance()->updateContact($email,
                new UpdateContact(['emailBlacklisted' => false])
            );
        } catch (Exception $e) {
            if ($e->getCode() !== 404) {
                throw LaravelNewsletterException::reSubscribeFailed($e->getMessage());
            }
        }

        return false;
    }

    /**
     * @param  Mailable           $mailable
     * @param  array|string|null  $listNames
     * @param  string|null        $fromEmail
     * @param  string|null        $fromName
     * @param  string|null        $replyTo
     * @param  Carbon|null        $scheduledAt
     * @param  string|null        $campaignName
     * @return mixed
     * @throws ReflectionException
     */
    public function sendMailableToList(
        Mailable $mailable,
        $listNames = null,
        $fromEmail = null,
        $fromName = null,
        $replyTo = null,
        Carbon $scheduledAt = null,
        $campaignName = null
    ) {
        $view = $mailable->render();

        return $this->sendCampaign(
            $campaignName ?? class_basename($mailable),
            $mailable->subject,
            $view,
            $listNames,
            $fromEmail,
            $fromName,
            $replyTo,
            $scheduledAt
        );
    }

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
    ) {
        try {
            $this->getCampaignAPIInstance()->createEmailCampaign(
                new CreateEmailCampaign([
                    'name'        => $campaignName,
                    'htmlContent' => $htmlContent,
                    'subject'     => $subject,
                    'recipients'  => [
                        'listIds' => $this->getListIdsFromNames($listNames)->all(),
                    ],
                    'sender'      => [
                        'email' => $fromEmail ?? config('mail.from.address'),
                        'name'  => $fromName ?? config('mail.from.name'),
                    ],
                    'replyTo'     => $replyTo,
                    'scheduledAt' => value($scheduledAt ?? now()->addMinutes(5))->toISOString(),
                ])
            );

            return true;
        } catch (Exception $e) {
            throw LaravelNewsletterException::sendCampaignFailed($e->getMessage());
        }
    }
}