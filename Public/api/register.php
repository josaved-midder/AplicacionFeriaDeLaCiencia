<?php
declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../../src/services/AuthService.php';
require_once __DIR__ . '/../../src/services/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['message' => 'Método no permitido']);
  exit;
}

$input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
$username = trim($input['username'] ?? '');
$password = (string)($input['password'] ?? '');
$nombre   = trim($input['nombre'] ?? '');

$result = AuthService::register($username, $password, $nombre !== '' ? $nombre : null);

if ($result['ok']) {
  echo json_encode(['message' => 'Usuario creado. Ahora inicia sesión.']);
} else {
  http_response_code(400);
  echo json_encode(['message' => $result['message'] ?? 'No se pudo registrar.']);
}
