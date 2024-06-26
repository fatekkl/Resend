<?php

// Use Composer autoloader for PSR-4 compliance
require __DIR__ . '../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$resend = Resend::client($_ENV["API_KEY"]);


if ($_SERVER['REQUEST_METHOD'] === "DELETE") {

    $data = json_decode(file_get_contents('php://input'), true);

    $audienceId = $_GET['id'];

    $contactId = $data['contact_id'];

    try {
        $resend->contacts->remove($audienceId, $contactId);

        echo "Contato removido!!";
    } catch (\Throwable $th) {
        echo''. $th->getMessage() .'';
    }
}