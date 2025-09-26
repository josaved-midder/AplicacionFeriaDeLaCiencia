<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) { session_start(); }

if (!empty($_SESSION['uid'])) {
  require __DIR__ . '/../src/views/dashboard.php';
} else {
  require __DIR__ . '/../src/views/login.php';
}
