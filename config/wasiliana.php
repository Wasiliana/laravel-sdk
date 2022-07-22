<?php

return [
    'api' => [
        'key' => env('WASILIANA_API_KEY')
    ],
    'sms' => [
        'from' => env('WASILIANA_SENDER_ID', 'WASILIANA')
    ]
];