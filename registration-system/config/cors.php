<?php
return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'], // Specify paths that should allow CORS
    'allowed_methods' => ['*'], // Allow all HTTP methods
    'allowed_origins' => ['*'], // Allow all origins (replace '*' with specific domains if needed)
    'allowed_headers' => ['*'], // Allow all headers
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true, // If cookies or authentication tokens are needed
];