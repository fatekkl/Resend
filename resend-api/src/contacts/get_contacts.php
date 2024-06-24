<?php

// Include Composer autoload file to load Resend SDK classes...
require __DIR__ . '../../vendor/autoload.php';


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');

$dotenv-> load();

$resend = Resend::client($_ENV["API_KEY"]);



echo json_encode($resend->audiences->list() ?? []);


// Assign a new Resend Client instance to $resend variable, which is automatically autoloaded...


