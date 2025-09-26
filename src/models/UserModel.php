<?php
// src/models/UserModel.php
declare(strict_types=1);
require_once __DIR__ . '/../services/db.php';

class UserModel {
  public static function findByUsername(string $username): ?array {
    $sql = "SELECT id, username, password_hash, nombre FROM users WHERE username = ?";
    $st = db()->prepare($sql);
    $st->execute([$username]);
    $row = $st->fetch();
    return $row ?: null;
  }
}
