<?php

namespace Leeovery\LaravelNewsletter;

use Illuminate\Support\Collection;
use Leeovery\LaravelNewsletter\Exceptions\LaravelNewsletterException;

class NewsletterListCollection extends Collection
{
    /** @var string */
    public $defaultListName = '';

    public static function createFromConfig(array $config)
    {
        $collection = new static();

        foreach ($config['lists'] as $name => $listProperties) {
            $collection->push(new NewsletterList($name, $listProperties));
        }

        $collection->defaultListName = $config['default_list_name'];

        return $collection;
    }

    public function findByName(string $name): NewsletterList
    {
        if ($name === '') {
            return $this->getDefault();
        }

        /** @var NewsletterList $newsletterList */
        foreach ($this->items as $newsletterList) {
            if ($newsletterList->getName() === $name) {
                return $newsletterList;
            }
        }

        throw LaravelNewsletterException::noListWithName($name);
    }

    public function getDefault(): NewsletterList
    {
        /** @var NewsletterList $newsletterList */
        foreach ($this->items as $newsletterList) {
            if ($newsletterList->getName() === $this->defaultListName) {
                return $newsletterList;
            }
        }

        throw LaravelNewsletterException::defaultListDoesNotExist($this->defaultListName);
    }
}