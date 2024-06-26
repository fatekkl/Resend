<?php

// Use Composer autoloader for PSR-4 compliance
require __DIR__ . '../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    $resend = Resend::client($_ENV['API_KEY']);

    $data = json_decode(file_get_contents('php://input'), true);

    if (
      !isset($data['from']) || 
      !isset($data['to']) || 
      !isset($data['subject'])
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
      'html' => $data['text'],
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
