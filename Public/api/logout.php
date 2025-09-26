<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) { session_start(); }
$_SESSION = [];
if (ini_get('session.use_cookies')) {
  $p = session_get_cookie_params();
  setcookie(session_name(), '', time()-42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
}
session_destroy();

// Redirige SIEMPRE al index público
$publicBase = dirname(dirname($_SERVER['SCRIPT_NAME'])); // .../Public
header('Location: ' . $publicBase . '/index.php');
exit;
