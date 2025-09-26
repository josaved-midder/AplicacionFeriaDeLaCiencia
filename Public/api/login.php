<?php
// Public/api/login.php
declare(strict_types=1);

// Opcional: forzar JSON siempre
header('Content-Type: application/json; charset=utf-8');
// Cookies de sesión cross-site si las necesitas desde front en fetch(..., {credentials:'include'})
// header('Access-Control-Allow-Origin: https://tu-dominio'); header('Access-Control-Allow-Credentials: true');

require_once __DIR__ . '/../../src/services/AuthService.php';

$method = $_SERVER['REQUEST_METHOD'];
if ($method !== 'POST') {
  http_response_code(405);
  echo json_encode(['message' => 'Método no permitido']);
  exit;
}

$input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
$username = trim($input['username'] ?? '');
$password = (string)($input['password'] ?? '');

if ($username === '' || $password === '') {
  http_response_code(400);
  echo json_encode(['message' => 'Faltan credenciales']);
  exit;
}

$result = AuthService::login($username, $password);
if ($result['ok']) {
  echo json_encode(['message' => 'OK', 'user' => $result['user']]);
} else {
  http_response_code(401);
  echo json_encode(['message' => $result['message']]);
}
