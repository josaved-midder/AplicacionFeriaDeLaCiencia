<?php
class Database {

    public $host = 'localhost';
    public $db_name = 'donex';
    public $username = 'root';
    public $password = '';
    public $conn;

    // Método para conectar a la base de datos
    public function connect() {
        $this->conn = null;
        try {
            // Establece la conexión utilizando PDO
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username, $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8mb4");
        } catch(PDOException $e) {
            // Muestra un error si la conexión falla y detiene el script
            error_log("Error de conexión a la base de datos: " . $e->getMessage());
            die("Error del sistema. Por favor, intente m\u00e1s tarde.");
        }
        return $this->conn;
    }
}