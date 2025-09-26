<?php
declare(strict_types=1);
require_once __DIR__ . '/../services/AuthService.php';
require_once __DIR__ . '/../services/db.php';

// Redirige si no hay sesión
AuthService::requireLogin();

// Obtén datos del usuario SIEMPRE aquí (para que $user exista)
$user = AuthService::currentUser();

// Por seguridad extra: si algo raro pasa y $user es null, vuelve al index público
if (!$user) {
  $publicBase = dirname(dirname($_SERVER['SCRIPT_NAME'])); // .../Public
  header('Location: ' . $publicBase . '/index.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <title>Dashboard</title>
  <!-- Estás entrando por /Public/index.php, por eso esta ruta funciona -->
  <link rel="stylesheet" href="css/styleLogin.css" />
</head>
<body>
  <section>
    <?php for ($i=0; $i<160; $i++): ?><span></span><?php endfor; ?>

    <div class="signin">
      <div class="content">
        <h2 class="headline">DASHBOARD</h2>

        <form class="form" onsubmit="return false">
          <div class="inputBox">
            <input type="text" value="<?= htmlspecialchars((string)$user['id']) ?>" readonly>
            <i>ID</i>
          </div>

          <div class="inputBox">
            <input type="text" value="<?= htmlspecialchars($user['username']) ?>" readonly>
            <i>Usuario</i>
          </div>

          <div class="inputBox">
            <input type="text" value="<?= htmlspecialchars($user['nombre'] ?? '') ?>" readonly>
            <i>Nombre</i>
          </div>

          <div class="actions inputBox" style="display:flex; gap:12px;">
         <a class="btn" href="index.php">Refrescar</a>
<a class="btn outline" href="api/logout.php">Cerrar sesión</a>

          </div>
        </form>
      </div>
    </div>
  </section>
</body>
</html>
