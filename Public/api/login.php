<?php
declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../../src/services/AuthService.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['message' => 'Método no permitido']);
  exit;
}

$input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
$username = trim($input['username'] ?? '');
$password = (string)($input['password'] ?? '');

$result = AuthService::login($username, $password);

if ($result['ok']) {
  echo json_encode(['message' => 'OK', 'user' => $result['user']]);
} else {
  http_response_code(401);
  echo json_encode(['message' => $result['message'] ?? 'Credenciales inválidas']);
}
