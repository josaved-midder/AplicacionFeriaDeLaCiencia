<?php
declare(strict_types=1);

// Normaliza la ruta aunque la app esté en subcarpeta (p.ej. /AplicacionFeriaDeLaCiencia/Public)
$path  = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);             // p.ej. /.../Public/index.php
$base  = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');                  // p.ej. /.../Public
$route = preg_replace('#^' . preg_quote($base, '#') . '#', '', $path);  // p.ej. /index.php o /login
$route = ltrim($route, '/');

// Tratar index.php como raíz y quitar extensión .php en rutas
if ($route === '' || $route === 'index.php') $route = '/';
if (substr($route, -4) === '.php') $route = '/' . basename($route, '.php');
if ($route[0] !== '/') $route = '/' . $route;

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
