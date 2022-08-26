<?php

return [
    'api' => [
        'key' => env('WASILIANA_API_KEY')
    ],
    'sms' => [
        'prefix' => 'conversation_id',
        'from' => env('WASILIANA_SENDER_ID', 'WASILIANA'),
        [
            'name' => 'service_1',
            'prefix' => 'conversation_id',
            'from' => env('WASILIANA_SENDER_ID', 'WASILIANA'),
            'key' => ''
        ]
    ]
];
