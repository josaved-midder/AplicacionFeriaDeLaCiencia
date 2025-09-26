<?php
declare(strict_types=1);

// Normaliza la ruta aunque la app esté en subcarpeta
$path  = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);             // p.ej. /.../Public/index.php
$base  = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');                  // p.ej. /.../Public
$route = preg_replace('#^' . preg_quote($base, '#') . '#', '', $path);  // p.ej. /index.php o /login
$route = rtrim($route, '/');

// Tratar index.php como raíz
if ($route === '' || $route === 'index.php') {
  $route = '/';
} else {
  // Si viene con .php (login.php, register.php…), quita la extensión
  if (substr($route, -4) === '.php') {
    $route = '/' . basename($route, '.php'); // -> /login, /register, /dashboard
  } elseif ($route[0] !== '/') {
    $route = '/' . $route;
  }
}

switch ($route) {
  // Vistas
  case '/':
  case '/login':
    require __DIR__ . '/../src/views/login.php';
    break;

  case '/register':
    require __DIR__ . '/../src/views/register.php';
    break;

  case '/dashboard':
    require __DIR__ . '/../src/views/dashboard.php';
    break;

  // APIs
  case '/api/login':
    require __DIR__ . '/api/login.php';
    break;

  case '/api/register':
    require __DIR__ . '/api/register.php';
    break;

  case '/api/logout':
    require __DIR__ . '/api/logout.php';
    break;

  default:
    http_response_code(404);
    echo '404';
}
