<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Login</title>
  <link rel="stylesheet" href="css/styleLogin.css" />
</head>
<body>
<section>
  <?php for ($i=0;$i<160;$i++): ?><span></span><?php endfor; ?>
  <div class="signin">
    <div class="content">
      <h2>Sign In</h2>

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
          <a href="register">Signup</a>
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

  if (!username || !password) { msg.textContent = 'Completa usuario y contraseña.'; return; }

  btn.disabled = true; const t = btn.textContent; btn.textContent = 'Ingresando...'; msg.textContent = '';

  try {
    const res = await fetch('api/login', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      credentials: 'include',
      body: JSON.stringify({ username, password })
    });
    const data = await res.json().catch(()=> ({}));
    if (!res.ok) throw new Error(data.message || 'Error de autenticación');

    window.location.href = 'dashboard';
  } catch (err) {
    msg.textContent = err.message;
  } finally {
    btn.disabled = false; btn.textContent = t;
  }
}
</script>
</body>
</html>
