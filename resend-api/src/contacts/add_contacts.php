<?php

// Use Composer autoloader for PSR-4 compliance
require __DIR__ . '../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$resend = Resend::client($_ENV["API_KEY"]);


if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $data = json_decode(file_get_contents('php://input'), true);

    try {
        $resend->contacts->create($_GET['id'], [
            'email' => $data['email'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'unsubscribed' => $data['unsubscribed']
        ]);
    } catch (\Throwable $th) {
        throw new \Exception($th->getMessage());
    }
}