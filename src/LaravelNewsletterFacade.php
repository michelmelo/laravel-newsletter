<?php

namespace Leeovery\LaravelNewsletter;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Leeovery\LaravelNewsletter\Skeleton\SkeletonClass
 */
class LaravelNewsletterFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-newsletter';
    }
}
