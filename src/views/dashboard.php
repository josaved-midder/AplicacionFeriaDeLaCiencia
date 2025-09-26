<?php
declare(strict_types=1);
require_once __DIR__ . '/../services/AuthService.php';
require_once __DIR__ . '/../services/db.php';

AuthService::requireLogin();
$user = AuthService::currentUser();
if (!$user) { header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/login'); exit; }
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <title>Dashboard</title>
  <link rel="stylesheet" href="css/styleLogin.css" />
  <style>
    /* Fix label con inputs readonly */
    .signin .content .form .inputBox input[readonly] ~ i {
      transform: translateY(-7.5px); font-size:.8em; color:#fff; opacity:.9;
    }
    .actions { display:flex; gap:12px; }
    .btn { flex:1; display:inline-block; text-align:center; padding:10px; background:#0f0; color:#000; font-weight:700; border-radius:4px; text-decoration:none; }
    .btn.outline { background:transparent; border:1px solid #0f0; color:#0f0; }
  </style>
</head>
<body>
  <section>
    <?php for ($i=0;$i<160;$i++): ?><span></span><?php endfor; ?>

    <div class="signin">
      <div class="content">
        <h2 class="headline">DASHBOARD</h2>

        <form class="form" onsubmit="return false">
          <div class="inputBox">
            <input type="text" value="<?= htmlspecialchars((string)$user['id']) ?>" readonly placeholder=" ">
            <i>ID</i>
          </div>

          <div class="inputBox">
            <input type="text" value="<?= htmlspecialchars($user['username']) ?>" readonly placeholder=" ">
            <i>Usuario</i>
          </div>

          <div class="inputBox">
            <input type="text" value="<?= htmlspecialchars($user['nombre'] ?? '') ?>" readonly placeholder=" ">
            <i>Nombre</i>
          </div>

          <div class="inputBox actions">
            <a class="btn" href="dashboard">Refrescar</a>
            <a class="btn outline" href="api/logout">Cerrar sesión</a>
          </div>
        </form>
      </div>
    </div>
  </section>
</body>
</html>
