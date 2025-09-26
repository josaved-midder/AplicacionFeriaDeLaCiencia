<?php
session_start();
require_once 'database.php';

if (isset($_POST['email']) && isset($_POST['password'])) {
    $db = new Database();
    $conn = $db->connect();

    $correo = $_POST['email'];
    $pass = $_POST['password'];

    // Se cambió 'password' por 'contraseña' en la consulta SQL
    $sql = "SELECT * FROM usuarios WHERE correo = :correo";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':correo', $correo);
    $stmt->execute();
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    echo$pass;

    if ($user) {
        // Se cambió 'password' por 'contraseña' para verificar el hash
        if ($pass== $user['contraseña']) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['rol'] = $user['rol'];

            // Redirige al dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            // Contraseña incorrecta
           echo '<pre>'; // Añade etiquetas <pre> para un formato más legible
print_r($user);
echo '</pre>';
           // header("Location: ../login.html?error=password");
           /// exit();
        }
    } else {
        // Usuario no encontrado
        header("Location: ../login.html?error=user");
        exit();
    }
} else {
    // Si no se enviaron datos, redirige de vuelta al login
    header("Location: ../login.html");
    exit();
}
?>