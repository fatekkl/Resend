<?php

// Use Composer autoloader for PSR-4 compliance
require __DIR__ . '../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();


function enviarEmail($data) {
    $resend = Resend::client($_ENV['API_KEY']);

    $resend->emails->send([
        'from'=> $data['from'],
        'to' => $data['to'],
        'subject'=> $data['subject'],
        'html'=> $data['html'],
    ]);
};


$arquivo_json = 'emails_to_send.json';


if (file_exists($arquivo_json) && is_readable($arquivo_json)) {

    $dados_emails = file_get_contents($arquivo_json);

    $emails_agendados = json_decode($dados_emails, true);

    if ($emails_agendados !== null) {
        // Obtém a data e hora atuais
        $agora = time();

        echo 'percorreu o array';
        foreach ($emails_agendados as $email) {
            $data_envio = strtotime($email['at']);
        }


        // arrumar condicional embaixo e remover da lista depois de enviar

        // if ($data_envio <= $agora) {
        //     echo 'passou na condição';
        //     enviarEmail($email);
        // }

    }


}