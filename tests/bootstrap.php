<?php

include 'vendor/autoload.php';

$root = dirname(__DIR__);
$envFile = $root.'/.env';

if (! empty($_SERVER['APP_ENV'])) {
    $envFile .= '.'.$_SERVER['APP_ENV'];
}

if (file_exists($envFile)) {
    $dotenv = Dotenv\Dotenv::createImmutable($root, basename($envFile));
    $dotenv->load();
}
