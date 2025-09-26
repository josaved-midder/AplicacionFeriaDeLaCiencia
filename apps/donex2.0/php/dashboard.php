<?php
// Inicia la sesión para proteger la página
session_start();

// Verifica si el usuario ha iniciado sesión y tiene el rol 'administrador'
// Si no, lo redirige a la página de inicio de sesión


require_once 'database.php';

// Conexión a la base de datos
$db = new Database();
$conn = $db->connect();

// --- Consulta para obtener todos los usuarios ---
$sql_usuarios = "SELECT id_usuario, nombre, correo, tipo_usuario FROM usuarios";
$stmt_usuarios = $conn->prepare($sql_usuarios);
$stmt_usuarios->execute();
$usuarios = $stmt_usuarios->fetchAll(PDO::FETCH_ASSOC);

// --- Consulta para obtener todos los artículos ---
$sql_articulos = "SELECT id, nombreArticulo, descripcion, rutaFoto FROM articulos";
$stmt_articulos = $conn->prepare($sql_articulos);
$stmt_articulos->execute();
$articulos = $stmt_articulos->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Donex</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container-fluid {
            margin-top: 20px;
        }
        .card {
            margin-bottom: 20px;
        }
        .table-responsive {
            margin-top: 15px;
        }
        .logout-btn {
            position: absolute;
            top: 20px;
            right: 20px;
        }
        h1, h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        .btn-logout {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <a href="logout.php" class="btn btn-danger logout-btn">Cerrar Sesión</a>
        <h1>Dashboard de Administración</h1>
        
        <div class="card">
            <div class="card-header">
                <h2>Tabla de Usuarios</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID Usuario</th>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Rol</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuarios as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['id_usuario']); ?></td>
                                <td><?php echo htmlspecialchars($user['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($user['correo']); ?></td>
                                <td><?php echo htmlspecialchars($user['tipo_usuario']); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h2>Tabla de Artículos</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID Artículo</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Imagen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($articulos as $articulo): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($articulo['id']); ?></td>
                                <td><?php echo htmlspecialchars($articulo['nombreArticulo']); ?></td>
                                <td><?php echo htmlspecialchars($articulo['descripcion']); ?></td>
                                <td><img src="<?php echo htmlspecialchars($articulo['rutaFoto']); ?>" alt="Imagen del Artículo" style="width: 100px; height: auto;"></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>