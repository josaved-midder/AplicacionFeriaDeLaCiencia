-- Base de datos DONEX
CREATE DATABASE IF NOT EXISTS donexdb;
USE donexdb;

-- Tabla de usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('admin','usuario') DEFAULT 'usuario'
);

-- Tabla de categorias
CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);

-- Tabla de articulos
CREATE TABLE articulos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    descripcion TEXT,
    id_usuario INT,
    id_categoria INT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (id_categoria) REFERENCES categorias(id) ON DELETE SET NULL
);

-- Tabla de transacciones
CREATE TABLE transacciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_articulo INT,
    id_donante INT,
    id_receptor INT,
    tipo ENUM('donacion','intercambio'),
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_articulo) REFERENCES articulos(id),
    FOREIGN KEY (id_donante) REFERENCES usuarios(id),
    FOREIGN KEY (id_receptor) REFERENCES usuarios(id)
);

-- Insertamos categorías iniciales
INSERT INTO categorias (nombre) VALUES 
('Ropa'), 
('Electrodomésticos'), 
('Libros'), 
('Juguetes');

-- Usuarios de prueba (contraseña: 123456)
INSERT INTO usuarios (nombre, correo, password, rol) 
VALUES ('Admin Demo', 'admin@donex.com', '$2y$10$WzCjC8Nn5Hq1a4U6H5Hoxe5EkjwSksZ5Foe1q5V.WcBkUrtIMXr1C', 'admin');

INSERT INTO usuarios (nombre, correo, password, rol) 
VALUES ('Usuario Demo', 'usuario@donex.com', '$2y$10$WzCjC8Nn5Hq1a4U6H5Hoxe5EkjwSksZ5Foe1q5V.WcBkUrtIMXr1C', 'usuario');
