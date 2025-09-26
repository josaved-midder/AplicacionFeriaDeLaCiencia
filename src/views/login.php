<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Login</title>
  <!-- Importa el CSS desde la carpeta pública -->
  <link rel="stylesheet" href="css/styleLogin.css">
</head>
<body>
<section>
  <!-- tus <span> decorativos… (los dejé tal cual) -->
  <?php for ($i=0;$i<160;$i++): ?><span></span><?php endfor; ?>

  <div class="signin">
    <div class="content">
      <h2>Sign In</h2>

      <!-- FORMULARIO REAL -->
      <form class="form" id="loginForm" onsubmit="procesarLogin(event)">
        <div class="inputBox">
          <input type="text" id="username" name="username" required autocomplete="username">
          <i>Username</i>
        </div>

        <div class="inputBox">
          <input type="password" id="password" name="password" required autocomplete="current-password">
          <i>Password</i>
        </div>

        <div class="links">
          <a href="#">Forgot Password</a>
          <a href="register.php">Signup</a>
        </div>

        <p id="loginMsg" aria-live="polite" style="min-height:1em;margin:6px 0 0;color:#f66;"></p>

        <div class="inputBox">
          <button type="submit" id="btnLogin">Login</button>
        </div>
      </form>
    </div>
  </div>
</section>

<script>
async function procesarLogin(e) {
  e.preventDefault();
  const f = document.getElementById('loginForm');
  const username = f.username.value.trim();
  const password = f.password.value;
  const btn = document.getElementById('btnLogin');
  const msg = document.getElementById('loginMsg');

  if (!username || !password) {
    msg.textContent = 'Completa usuario y contraseña.';
    return;
  }

  btn.disabled = true;
  const t0 = btn.textContent;
  btn.textContent = 'Ingresando...';
  msg.textContent = '';

  try {
    const res = await fetch('api/login.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      credentials: 'include', // usa la cookie de sesión de PHP
      body: JSON.stringify({ username, password })
    });
    const data = await res.json().catch(()=> ({}));

    if (!res.ok) throw new Error(data.message || 'Error de autenticación');
    // éxito: redirige al dashboard/home
    window.location.href = 'index.php';
  } catch (err) {
    msg.textContent = err.message;
  } finally {
    btn.disabled = false;
    btn.textContent = t0;
  }
}
</script>
</body>
</html>
