<?php
require_once __DIR__ . "/database.php";

$db = new Database();
$conn = $db->connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Definir la carpeta donde se guardarán las fotos. 
    // Asegúrate de que esta carpeta exista y tenga permisos de escritura.
    // **CORRECCIÓN:** Se añade una barra diagonal al final de la ruta.
    $upload_dir = __DIR__ . "/../images/articulos/"; 

    // Recuperar los datos del formulario
    $nombre = $_POST["nombreArticulo"] ?? '';
    $descripcion = $_POST["descripcion"] ?? '';
    
    // Validar y procesar la imagen
    if (isset($_FILES["fotoArticulo"]) && $_FILES["fotoArticulo"]["error"] == UPLOAD_ERR_OK) {
        $foto_temp_name = $_FILES["fotoArticulo"]["tmp_name"];
        $foto_original_name = basename($_FILES["fotoArticulo"]["name"]);
        
        // Generar un nombre único para el archivo para evitar colisiones
        $extension = pathinfo($foto_original_name, PATHINFO_EXTENSION);
        $foto_unique_name = uniqid() . "." . $extension;
        
        // **CORRECCIÓN:** La concatenación de la ruta ahora es correcta.
        $foto_path = $upload_dir . $foto_unique_name; 

        // Mover el archivo subido a la carpeta de destino
        if (move_uploaded_file($foto_temp_name, $foto_path)) {
            // La imagen se guardó correctamente, ahora guarda la información en la base de datos.
            
            // Usar una tabla de 'articulos' en lugar de 'usuarios'
            $sql = "INSERT INTO articulos (nombreArticulo, descripcion, rutaFoto)
                    VALUES (:nombreArticulo, :descripcion, :rutaFoto)";
            $stmt = $conn->prepare($sql);
            
            // Asignar los parámetros
            $stmt->bindParam(':nombreArticulo', $nombre);
            $stmt->bindParam(':descripcion', $descripcion);
            
            // Guardar la ruta del archivo. Se recomienda guardar la ruta relativa
            // para que la aplicación sea más portable entre servidores.
            $relative_path = "images/articulos/" . $foto_unique_name;
            $stmt->bindParam(':rutaFoto', $relative_path); 

            if ($stmt->execute()) {
                header("Location: ../index.html");
                exit;
            } else {
                echo "❌ Error al guardar el artículo.";
                // Si la base de datos falla, es buena práctica borrar el archivo subido
                unlink($foto_path);
            }
        } else {
            echo "❌ Error al subir la imagen. Revisa los permisos del directorio 'images/articulos'.";
        }
    } else {
        echo "❌ No se ha subido ninguna foto o ha ocurrido un error.";
    }
}
?>