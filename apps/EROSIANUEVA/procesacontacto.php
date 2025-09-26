<?php
require_once __DIR__ . "/database.php";

$db = new Database();
$conn = $db->connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $numero = $_POST["numero"];
    $asunto = $_POST["asunto"];
    $mensaje = $_POST["mensaje"];

    $sql = "INSERT INTO contacto (nombre, correo, numero, asunto, mensaje)
             VALUES (:nombre, :correo, :numero, :asunto, :mensaje)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':numero', $numero);
    $stmt->bindParam(':asunto', $asunto);
    $stmt->bindParam(':mensaje', $mensaje);

    if ($stmt->execute()) {
        echo "✅ tu mensaje fue enviado con exito.";
    } else {
        echo "❌ mensaje no resivido.";
    }
}
?>