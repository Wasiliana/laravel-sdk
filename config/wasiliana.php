<?php

return [
    'sms' => [
        'service_1' => [
            'name' => 'testSms',
            'from' => env('SMS_SERVICE_1_SENDER_ID', 'WASILIANA'),
            'key' => env('SMS_SERVICE_1_API_KEY', null)
        ],
    ],
    'airtime' => [
        'service_1' => [
            'name' => 'testAirtime',
            'key' => env('AIRTIME_SERVICE_1_API_KEY', null)
        ],
    ]
];
