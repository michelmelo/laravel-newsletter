<?php

namespace Leeovery\LaravelNewsletter;

use Illuminate\Support\Facades\Log;

class NullDriver
{
    public function __call($name, $arguments)
    {
        Log::debug('Called Leeovery\LaravelNewsletter facade method: '.$name.' with:', $arguments);
    }
}