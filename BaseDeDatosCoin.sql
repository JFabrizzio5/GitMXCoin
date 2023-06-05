drop database if exists Jos5Dev;
Create database Jos5Dev;

USE Jos5Dev;

CREATE TABLE archivos1 (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(255),
  tipo VARCHAR(100),
  tamaño INT,
  contenido LONGBLOB
);

CREATE TABLE usuarios (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(50) NOT NULL,
  email VARCHAR(100) NOT NULL,
  contrasena VARCHAR(100) NOT NULL,
  direccion_billetera VARCHAR(100) NOT NULL,
  saldo_criptomonedas DECIMAL(10, 2) NOT NULL DEFAULT 0
);

CREATE TABLE archivos (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(100) NOT NULL,
  descripcion TEXT,
  ruta_almacenamiento VARCHAR(255) NOT NULL,
  id_usuario_propietario INT NOT NULL,
  precio_criptomonedas DECIMAL(10, 2) NOT NULL DEFAULT 0,
  fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_usuario_propietario) REFERENCES usuarios(id)
);




select * from archivos1;
select * from usuarios;
