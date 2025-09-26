<?php
require_once __DIR__ . "/database.php";

$db = new Database();
$conn = $db->connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $q1 = $_POST["q1"];
    $q2 = $_POST["q2"];
    $q3 = $_POST["q3"]; 
    $q4 = $_POST["q4"]; 
    $q5 = $_POST["q5"]; 
    $q6 = $_POST["q6"];
    $descripcionFormPregunta = $_POST["descripcionFormPregunta"];

    
    $sql = "INSERT INTO formulario_ansiedad (q1, q2, q3, q4, q5, q6, descripcionFormPregunta)
            VALUES (:q1, :q2, :q3, :q4, :q5, :q6, :descripcionFormPregunta)";
            
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':q1', $q1);
    $stmt->bindParam(':q2', $q2);
    $stmt->bindParam(':q3', $q3);
    $stmt->bindParam(':q4', $q4);
    $stmt->bindParam(':q5', $q5);
    $stmt->bindParam(':q6', $q6);
    $stmt->bindParam(':descripcionFormPregunta', $descripcionFormPregunta);


    if ($stmt->execute()) {
        echo "✅ Usuario creado correctamente.";
        
      //  header("Location: Psicologia.html");
       // exit();

    } else {
        echo "❌ Error al crear usuario.";
    }
}
?>