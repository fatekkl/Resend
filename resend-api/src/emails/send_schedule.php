<?php

// Use Composer autoloader for PSR-4 compliance
require __DIR__ . '../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

date_default_timezone_set('America/Sao_Paulo');


function enviarEmail($data) {
    try {
        $resend = Resend::client($_ENV['API_KEY']);

        $resend->emails->send([
            'from' => $data['from'],
            'to' => $data['to'],
            'subject' => $data['subject'],
            'html' => $data['html'],
        ]);

        // Remover o email da lista após o envio bem-sucedido (opcional)
        // Remova esta parte se não desejar remover automaticamente
        // unset($emails_agendados[array_search($data, $emails_agendados)]);

        echo "Email enviado para: {$data['to']} - Assunto: {$data['subject']}\n";
        return true;
    } catch (Exception $e) {
        echo "Erro ao enviar email: {$e->getMessage()}\n";
        return false;
    }
}

$arquivo_json = 'emails_to_send.json';

if (file_exists($arquivo_json) && is_readable($arquivo_json)) {
    $dados_emails = file_get_contents($arquivo_json);
    $emails_agendados = json_decode($dados_emails, true);

    if ($emails_agendados !== null) {
        $agora = time();

        echo "Percorrendo a lista de emails agendados...\n";
        foreach ($emails_agendados as $key => $email) {
            $data_envio = strtotime($email['at']);

            echo "$data_envio";

            if ($data_envio <= $agora) {
                enviarEmail($email);

                // Remover o email da lista após o envio bem-sucedido
                unset($emails_agendados[$key]);

                // Atualizar o arquivo JSON sem o email enviado
                file_put_contents($arquivo_json, json_encode($emails_agendados, JSON_PRETTY_PRINT));
            }
        }
    } else {
        echo "Erro ao decodificar o arquivo JSON.\n";
    }
} else {
    echo "O arquivo JSON não existe ou não é legível.\n";
}

?>