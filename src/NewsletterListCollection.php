<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace Leeovery\LaravelNewsletter;

use Illuminate\Support\Collection;
use Leeovery\LaravelNewsletter\Exceptions\LaravelNewsletterException;

class NewsletterListCollection extends Collection
{
    /**
     * @var string
     */
    public $defaultListName = '';

    /**
     * @param  array  $config
     * @return NewsletterListCollection
     */
    public static function createFromConfig(array $config)
    {
        return tap(new static($config['lists']), function ($collection) use ($config) {
            return value($collection->defaultListName = $config['default_list_name']);
        })->transform(function ($listProperties, $name) {
            return new NewsletterList($name, $listProperties);
        });
    }

    public function findByName(string $name): NewsletterList
    {
        if ($name === '') {
            $name = $this->defaultListName;
        }

        $list = $this->first(function (NewsletterList $newsletterList) use ($name) {
            if ($newsletterList->getName() === $name) {
                return $newsletterList;
            }

            return null;
        });

        return tap($list, function ($list) use ($name) {
            throw_if(is_null($list),
                LaravelNewsletterException::noListWithName($name)
            );
        });
    }
}