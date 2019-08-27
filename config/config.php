<?php

return [

    /**
     * This is where you choose the provider driver you wish to use.
     * Best to use the provided key in your .env file. A NullDriver
     * is provided for testing / local dev, and is the default.
     */
    'driver' => env('NEWSLETTER_DRIVER', 'null'),

    /**
     * You can add all the credentials your provider needs to this array.
     * Some providers will only need api_key so that's all that's there
     * by default.
     */
    'credentials' => [
        'api_key' => env('NEWSLETTER_APIKEY'),
    ],

    /**
     * List name reference here will be what's used by this package when you
     * don't pass a list name to the provider methods which require a list
     * name(s).
     */
    'default_list_name' => 'main',

    /**
     * Add the list(s) to this array, along with the ID corresponding to the
     * ID with your chosen provider. You can then use the name of the list
     * to reference them when using this package.
     */
    'lists' => [

        'main' => [
            'id' => '1',
        ],

        //

    ],

];