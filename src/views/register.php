<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Registrarme</title>
  <link rel="stylesheet" href="css/styleLogin.css" />
</head>
<body>
<section>
  <?php for ($i=0;$i<160;$i++): ?><span></span><?php endfor; ?>

  <div class="signin">
    <div class="content">
      <h2>Sign Up</h2>

      <form class="form" id="registerForm" onsubmit="procesarRegistro(event)">
        <div class="inputBox">
          <input type="text" id="username" name="username" required autocomplete="username">
          <i>Usuario (email o alias)</i>
        </div>

        <div class="inputBox">
          <input type="text" id="nombre" name="nombre" autocomplete="name">
          <i>Nombre</i>
        </div>

        <div class="inputBox">
          <input type="password" id="password" name="password" required autocomplete="new-password">
          <i>Contraseña</i>
        </div>

        <div class="links">
          <a href="index.php">Volver a Login</a>
        </div>

        <p id="regMsg" aria-live="polite" style="min-height:1em;margin:6px 0 0;color:#f66;"></p>

        <div class="inputBox">
          <button type="submit" id="btnReg">Crear cuenta</button>
        </div>
      </form>
    </div>
  </div>
</section>

<script>
async function procesarRegistro(e) {
  e.preventDefault();
  const f = document.getElementById('registerForm');
  const username = f.username.value.trim();
  const nombre   = f.nombre.value.trim();
  const password = f.password.value;
  const btn = document.getElementById('btnReg');
  const msg = document.getElementById('regMsg');

  if (!username || !password) { msg.textContent = 'Completa usuario y contraseña.'; return; }

  btn.disabled = true; const t = btn.textContent; btn.textContent = 'Creando...'; msg.textContent = '';

  try {
    const res = await fetch('api/register.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ username, nombre, password })
    });
    const data = await res.json().catch(()=> ({}));
    if (!res.ok) throw new Error(data.message || 'No se pudo registrar');

    // Registro OK → vuelve al login
    msg.style.color = '#0f0';
    msg.textContent = 'Cuenta creada. Redirigiendo al login...';
    setTimeout(()=> window.location.href = 'index.php', 800);
  } catch (err) {
    msg.textContent = err.message;
  } finally {
    btn.disabled = false; btn.textContent = t;
  }
}
</script>
</body>
</html>
