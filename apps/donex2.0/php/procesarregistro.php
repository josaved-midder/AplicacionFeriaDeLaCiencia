<?php
require_once __DIR__ . "/database.php";

$db = new Database();
$conn = $db->connect();

if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $nombre = $_POST["nombre"] ?? '';
    $correo = $_POST["correo"] ?? '';
    // evita acentos en el name del input: usa name="contrasena"
    //$pass   = password_hash($_POST["contrasena"], PASSWORD_BCRYPT);
    $pass = $_POST['Contraseña'] ??'';
    $rol    = 'administrador';

    $sql = "INSERT INTO usuarios (nombre, correo, `contraseña`, tipo_usuario)
            VALUES (:nombre, :correo, :pass, :rol)";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':pass', $pass);
    $stmt->bindParam(':rol', $rol);

    if ($stmt->execute()) {
        // no hagas echo antes de header
        header("Location: ../index.php");
        exit;
    } else {
        echo "❌ Error al crear usuario.";
        header("Location: procesarregistro.php");
        exit;
    }
}
