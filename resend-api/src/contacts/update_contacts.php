<?php

// Use Composer autoloader for PSR-4 compliance
require __DIR__ . '../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$resend = Resend::client($_ENV["API_KEY"]);


if ($_SERVER['REQUEST_METHOD'] === "PATCH") {

    $data = json_decode(file_get_contents('php://input'), true);

    if (empty(trim($data['first_name'])) || empty(trim($data['last_name']))){

        echo 'preenche os campos corretamente';
        throw new Exception("Preencha os campos corretamente", 1);
    }

    $audienceId = $_GET['id'];

    $contactId = $data['contact_id'];

    try {
        $resend->contacts->update($audienceId, $contactId, 
            ['audienceId'=> $audienceId,'id'=> $contactId, 'first_name'=> $data['first_name'], 'last_name'=> $data['last_name']]);

       echo "deu certo eu acho";
    } catch (\Throwable $th) {
        echo''. $th->getMessage() .'';
    }
}