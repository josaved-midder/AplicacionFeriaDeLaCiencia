<?php
// src/services/AuthService.php
declare(strict_types=1);
require_once __DIR__ . '/../models/UserModel.php';

class AuthService {
  public static function login(string $username, string $password): array {
    $user = UserModel::findByUsername($username);
    if (!$user || !password_verify($password, $user['password_hash'])) {
      return ['ok' => false, 'message' => 'Usuario o contraseña inválidos'];
    }
    // Arranca sesión y guarda datos mínimos
    if (session_status() === PHP_SESSION_NONE) session_start();
    $_SESSION['uid'] = $user['id'];
    $_SESSION['uname'] = $user['nombre'] ?? $user['username'];
    return ['ok' => true, 'user' => ['id' => $user['id'], 'name' => $_SESSION['uname']]];
  }

  public static function logout(): void {
    if (session_status() === PHP_SESSION_NONE) session_start();
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      setcookie(session_name(), '', time()-42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
    }
    session_destroy();
  }
  public static function currentUser(): ?array {
  if (session_status() === PHP_SESSION_NONE) session_start();
  if (empty($_SESSION['uid'])) return null;

  // Carga datos completos del usuario
  $st = db()->prepare("SELECT id, username, nombre FROM users WHERE id = ?");
  $st->execute([$_SESSION['uid']]);
  return $st->fetch() ?: null;
}

public static function requireLogin(): void {
  if (session_status() === PHP_SESSION_NONE) session_start();
  if (empty($_SESSION['uid'])) {
    header('Location: /login'); // o '/'
    exit;
  }
}

}
