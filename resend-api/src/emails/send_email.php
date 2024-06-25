<?php

// Use Composer autoloader for PSR-4 compliance
require __DIR__ . '../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();




$command = "php /caminho/para/seu/script.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    $resend = Resend::client($_ENV['API_KEY']);

    $data = json_decode(file_get_contents('php://input'), true);

    // Verifica se os campos obrigatórios estão presentes e são strings
    if (
      !isset($data['from']) || !is_string($data['from']) ||
      !isset($data['to']) || !is_string($data['to']) ||
      !isset($data['subject']) || !is_string($data['subject'])
    ) {
      throw new InvalidArgumentException('Dados faltando ou inválidos');
    }

    // Define $text e $html como null se não estiverem definidos
    $text = isset($data['text']) ? $data['text'] : null;
    $html = isset($data['html']) ? $data['html'] : null;

    $resend->emails->send([
      'from' => $data['from'],
      'to' => $data['to'],
      'subject' => $data['subject'],
      'html' => $text,
    ]);

    echo json_encode(['message' => "Email enviado!!"]);
  } catch (Exception $e) {
    echo json_encode([
      'message' => 'Falha ao enviar email.',
      'error' => $e->getMessage(),
    ]);
  }
} else {
  echo json_encode(['message' => 'Este script deve ser executado em uma requisição HTTP POST.']);
}
