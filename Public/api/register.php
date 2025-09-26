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
$nombre   = trim($input['nombre'] ?? '');

$res = AuthService::register($username, $password, $nombre !== '' ? $nombre : null);

if ($res['ok']) {
  echo json_encode(['message' => 'Usuario creado. Inicia sesión.']);
} else {
  http_response_code(400);
  echo json_encode(['message' => $res['message'] ?? 'No se pudo registrar.']);
}
