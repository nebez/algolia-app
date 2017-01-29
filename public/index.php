<?php

// Serve static files as-is and let everything else fall through to our web
// application. This serves as a "front-controller" for the built-in PHP web
// server.
if (preg_match('/\.(?:png|css|js)$/', $_SERVER["REQUEST_URI"])) {
    return false;
}

echo 'It works...';
