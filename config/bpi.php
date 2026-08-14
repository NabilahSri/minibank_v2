<?php

return [
    'mode' => env('BPI_MODE', 'production'),
    'client_id' => env('BPI_CLIENT_ID', 'BPI9535'),
    'grant_type' => env('BPI_GRANT_TYPE', 'password'),
    'username' => env('BPI_USERNAME', 'smkypctskmly'),
    'password' => env('BPI_PASSWORD', '65LMWuzcBqV7FDkm'),
    'client_secret' => env('BPI_CLIENT_SECRET', '9e8c4e3d-bdbb-46f1-9825-201b2b092805'),
    'token_url' => env('BPI_TOKEN_URL', 'https://account.makaramas.com/auth/realms/bpi/protocol/openid-connect/token'),
    'base_url' => env('BPI_BASE_URL', 'https://billing-bpi.maja.id/api/v2'),
    'callback_user' => env('BPI_CALLBACK_USER', '900'),
];
