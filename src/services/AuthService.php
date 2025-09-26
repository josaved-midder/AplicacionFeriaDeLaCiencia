<?php
declare(strict_types=1);
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../services/db.php';

class AuthService {
  public static function login(string $username, string $password): array {
    $user = UserModel::findByUsername($username);
    if (!$user || !password_verify($password, $user['password_hash'])) {
      return ['ok' => false, 'message' => 'Usuario o contraseña inválidos'];
    }
    if (session_status() === PHP_SESSION_NONE) session_start();
    $_SESSION['uid'] = $user['id'];
    $_SESSION['uname'] = $user['nombre'] ?? $user['username'];
    return ['ok' => true, 'user' => ['id' => $user['id'], 'name' => $_SESSION['uname']]];
  }

  public static function logout(): void {
    if (session_status() === PHP_SESSION_NONE) session_start();
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
      $p = session_get_cookie_params();
      setcookie(session_name(), '', time()-42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
    }
    session_destroy();
  }

  public static function currentUser(): ?array {
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['uid'])) return null;
    $st = db()->prepare("SELECT id, username, nombre FROM users WHERE id = ?");
    $st->execute([$_SESSION['uid']]);
    return $st->fetch() ?: null;
  }

  public static function requireLogin(): void {
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['uid'])) {
      $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'); // .../Public
      header('Location: ' . $base . '/login');
      exit;
    }
  }

  public static function register(string $username, string $password, ?string $nombre = null): array {
    $username = trim($username);
    if ($username === '' || $password === '') return ['ok' => false, 'message' => 'Usuario y contraseña requeridos.'];
    if (strlen($password) < 4) return ['ok' => false, 'message' => 'La contraseña debe tener al menos 4 caracteres.'];
    if (UserModel::existsByUsername($username)) return ['ok' => false, 'message' => 'El usuario ya existe.'];

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $id = UserModel::create($username, $hash, $nombre);
    return ['ok' => true, 'id' => $id];
  }
}
