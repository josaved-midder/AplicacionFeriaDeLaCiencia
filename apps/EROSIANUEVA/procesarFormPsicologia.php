<?php
require_once __DIR__ . "/database.php";


$db = new Database();
$conn = $db->connect();

if ($_SERVER["REQUEST_METHOD"]=="POST")
{
   $nombre = $_POST ["nombreFormpsicologia"];
   $pregunta = $_POST ["descripcionFormPsicologia"];


   $sql = "INSERT INTO formulario (nombre, pregunta)
        VALUES (:nombre, :pregunta)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':nombre', $nombre);
$stmt->bindParam(':pregunta', $pregunta);

if ($stmt->execute()) {
    echo "✅ pregunta enviada.";
    header("location: Registro.html");

} else {
    echo "❌ pregunta no enviada.";
}
   
}
?>