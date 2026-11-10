<<<<<<< HEAD
CREATE DATABASE IF NOT EXISTS filosofia_evangelio
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE filosofia_evangelio;

CREATE TABLE IF NOT EXISTS contactos (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    numero VARCHAR(30) NOT NULL,
    correo VARCHAR(150) NOT NULL,
    tema VARCHAR(30) NOT NULL,
    peticion TEXT NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
=======
CREATE DATABASE IF NOT EXISTS filosofia_evangelio
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE filosofia_evangelio;

CREATE TABLE IF NOT EXISTS contactos (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    numero VARCHAR(30) NOT NULL,
    correo VARCHAR(150) NOT NULL,
    tema VARCHAR(30) NOT NULL,
    peticion TEXT NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
>>>>>>> 2218b1da98cf761018e39d422875a7e7d85d3b72
);