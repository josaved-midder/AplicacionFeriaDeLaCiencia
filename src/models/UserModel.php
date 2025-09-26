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
  public static function existsByUsername(string $username): bool {
    $st = db()->prepare("SELECT 1 FROM users WHERE username = ? LIMIT 1");
    $st->execute([$username]);
    return (bool)$st->fetchColumn();
  }

  public static function create(string $username, string $passwordHash, ?string $nombre): int {
    $st = db()->prepare("INSERT INTO users (username, password_hash, nombre) VALUES (?, ?, ?)");
    $st->execute([$username, $passwordHash, $nombre]);
    return (int)db()->lastInsertId();
  }
}
