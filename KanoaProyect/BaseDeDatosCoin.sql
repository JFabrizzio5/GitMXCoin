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
  id_usuario_propietario INT NOT NULL,
  precio_criptomonedas DECIMAL(10, 2) NOT NULL DEFAULT 0,
  fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  imagen_proyecto LONGBLOB,
  Proyecto LONGBLOB,
  FOREIGN KEY (id_usuario_propietario) REFERENCES usuarios(id)
);



	CREATE TABLE tabla_imagenes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_archivo VARCHAR(255),
    tipo_archivo VARCHAR(100),
    tamano_archivo INT,
    contenido_archivo MEDIUMBLOB
);

CREATE TABLE canjeo (
  id INT AUTO_INCREMENT PRIMARY KEY,
  correo VARCHAR(255) NOT NULL,
  cantidad INT NOT NULL,
  fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE donaciones (
  id INT AUTO_INCREMENT PRIMARY KEY,
  propietario_id INT NOT NULL,
  donacion DECIMAL(10, 2) NOT NULL,
  fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (propietario_id) REFERENCES usuarios(id)
);

select * from donaciones;
select * from canjeo;
select * from tabla_imagenes;
select * from archivos;
select * from usuarios;