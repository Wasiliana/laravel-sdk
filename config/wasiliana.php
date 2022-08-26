<?php

return [
    'api' => [
        'key' => env('WASILIANA_API_KEY')
    ],
    'sms' => [
        'service_1' => [
            'name' => 'test',
            'from' => env('WASILIANA_SERVICE_1_SENDER_ID', 'WASILIANA'),
            'key' => env('WASILIANA_SERVICE_1_API_KEY', null)
        ],
    ]
];
