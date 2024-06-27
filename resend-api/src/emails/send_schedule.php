<?php

// Use Composer autoloader for PSR-4 compliance
require __DIR__ . '../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

date_default_timezone_set('America/Sao_Paulo');

function enviarEmail($data)
{
    try {
        $resend = Resend::client($_ENV['API_KEY']);

        $resend->emails->send([
            'from' => $data['from'],
            'to' => $data['to'],
            'subject' => $data['subject'],
            'html' => $data['html'],
        ]);

        echo "Email enviado para: {$data['to']} - Assunto: {$data['subject']}\n";



        sleep(0.5);
        return true;
    } catch (Exception $e) {
        echo "Erro ao enviar email: {$e->getMessage()}\n";
        return false;
    }
}

$arquivo_json = '/var/www/html/resend-api/src/emails_to_send.json';

if (file_exists($arquivo_json) && is_readable($arquivo_json)) {
    $dados_emails = file_get_contents($arquivo_json);
    $emails_agendados = json_decode($dados_emails, true);

    if ($emails_agendados !== null) {
        foreach ($emails_agendados as $key => $email) {
            $data_atual = new DateTime();

            // Data específica no formato "YYYY-MM-DD HH:MM:SS"
            $data_especifica = new DateTime($email['at']);

            // Comparação das datas
            if ($data_atual < $data_especifica) {
                echo $email['subject'] . " ainda não deu a hora!!\n";
                continue; // Pula para a próxima iteração
            }

            if (enviarEmail($email)) {
                unset($emails_agendados[$key]);
            }
        }

        // Salva o conteúdo atualizado de volta no arquivo JSON
        file_put_contents($arquivo_json, json_encode(array_values($emails_agendados), JSON_PRETTY_PRINT));
    } else {
        echo "Erro ao decodificar o arquivo JSON.\n";
    }
} else {
    echo "O arquivo JSON não existe ou não é legível.\n";
}

?>
