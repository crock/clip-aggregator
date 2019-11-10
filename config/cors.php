<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel CORS
    |--------------------------------------------------------------------------
    |
    | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
    | to accept any value.
    |
    */
   
    'supportsCredentials' => false,
    'allowedOrigins' => [
        'https://duel.net', 
        'https://duel.org', 
        'https://duel.netlify.com', 
        'https://fortn.it', 
        'https://battleroyale.site', 
        'https://fortnite.live', 
        'https://playbattleroyale.com', 
        'http://localhost:8000'
    ],
    'allowedOriginsPatterns' => [],
    'allowedHeaders' => ['*'],
    'allowedMethods' => ['GET'],
    'exposedHeaders' => [],
    'maxAge' => 0,

];
