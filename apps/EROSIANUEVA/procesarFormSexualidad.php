<?php
require_once __DIR__ . "/database.php";


$db = new Database();
$conn = $db->connect();


if ($_SERVER["REQUEST_METHOD"]=="POST")
{

   $nombre = $_POST ["nombreformsexualidad"];
   $pregunta = $_POST ["descripcionformsexualidad"];


   $sql = "INSERT INTO formulario_sexualidad (nombre, descripcion)
        VALUES (:nombre, :pregunta)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':nombre', $nombre);
$stmt->bindParam(':pregunta', $pregunta);

if ($stmt->execute()) {
    echo "✅ Usuario creado correctamente.";
    header("location: Sexualidad.html");

} else {
    echo "❌ Error al crear usuario.";
}
   
}
?>