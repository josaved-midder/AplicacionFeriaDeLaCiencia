<?php
declare(strict_types=1);
require_once __DIR__ . '/../../src/services/AuthService.php';

AuthService::logout();

// Redirige al login del router
$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');  // .../Public
header('Location: ' . $base . '/login');
exit;
