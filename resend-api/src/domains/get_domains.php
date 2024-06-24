<?php

// Include Composer autoload file to load Resend SDK classes...
require __DIR__ . '../../vendor/autoload.php';


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');

$dotenv-> load();

function getDomains() : Resend\Collection {
    $resend = Resend::client($_ENV["API_KEY"]);

    return $resend->domains->list();
}

$domains = getDomains();

header("Content-Type: application/json");

echo json_encode($domains);


// Assign a new Resend Client instance to $resend variable, which is automatically autoloaded...


