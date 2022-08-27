<?php

return [
    'sms' => [
        'service_1' => [
            'name' => 'test',
            'from' => env('SERVICE_1_SENDER_ID', 'WASILIANA'),
            'key' => env('SERVICE_1_API_KEY', null)
        ],
    ]
];
