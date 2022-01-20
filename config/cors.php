<?php
return [
    'paths' => ['api/'],
    'allowed_methods' => ['POST', 'GET', 'DELETE', 'PUT', '*'],
    'allowed_origins' => ['http://http://localhost:8081/', '*'],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['Access-Control-Request-Method', 'Access-Control-Request-Headers', '*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];
