<?php

return [
    'enabled' => env('SMS_ENABLED', true),
    'base_url' => env('SMS_BASE_URL', 'https://smsc.kz/sys/send.php'),
    'login' => env('SMS_LOGIN', 'Brandstudio'),
    'psw' => env('SMS_PASSWORD', ''),
    'from' => env('SMS_FROM', ''),
    'time' => 0,
];
