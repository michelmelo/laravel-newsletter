<?php

/*
 * You can place your custom package configuration in here.
 */
return [

    'driver' => env('NEWSLETTER_DRIVER', 'send-in-blue'),

    'credentials' => [
        'api_key' => env('NEWSLETTER_APIKEY'),
    ],

    'default_list_name' => 'test',

    'lists' => [
        'main' => [
            'id' => '3',
        ],
        'test' => [
            'id' => '6',
        ],
    ],

];