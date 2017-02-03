<?php

$dotenv = new Dotenv\Dotenv(__DIR__ . '/../');

$dotenv->load();

// Prevent loading the application if these two environment variables are not
// set. They're necessary for proper functionality!
$dotenv->required([
    'ALGOLIA_APP_ID',
    'ALGOLIA_API_KEY'
])->notEmpty();
