<?php

use Illuminate\Support\Str;

return [
    'driver' => 'cookie',
    'lifetime' => 120, // Percben, pl. 2 óra
    'expire_on_close' => false, // Böngésző bezárásakor ne törlődjön
    'encrypt' => false,
    'http_only' => true,
    'secure' => env('APP_ENV') === 'production', // Csak HTTPS-en küldhető, ha éles szerveren vagy
    'same_site' => 'lax',
];