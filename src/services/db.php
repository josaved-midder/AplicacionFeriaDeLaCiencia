<?php
declare(strict_types=1);

function db(): PDO {
  static $pdo = null;
  if ($pdo) return $pdo;

  $host = '127.0.0.1';
  $db   = 'feria2025';
  $user = 'root';
  $pass = '';
  $charset = 'utf8mb4';

  $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
  $opts = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
  ];
  $pdo = new PDO($dsn, $user, $pass, $opts);
  return $pdo;
}
