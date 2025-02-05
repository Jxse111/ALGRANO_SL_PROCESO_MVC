CREATE DATABASE IF NOT EXISTS algrano;
USE algrano;
-- Tabla Usuario
CREATE TABLE IF NOT EXISTS usuario (
    DNI CHAR(9) NOT NULL PRIMARY KEY,
    usuario VARCHAR(30) NOT NULL,
    contraseña CHAR(255) NOT NULL,
    direccion VARCHAR(100) NOT NULL,
    correo VARCHAR(50) UNIQUE NOT NULL,
    fec_nac DATE NOT NULL,
    codigo_rol CHAR(9) NOT NULL,
    FOREIGN KEY (codigo_rol) REFERENCES rol(id_rol) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
--Tabla Rol
CREATE TABLE IF NOT EXISTS rol(
    id_rol CHAR(9) NOT NULL PRIMARY KEY,
    rol VARCHAR(30)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
-- Tabla Cliente
CREATE TABLE IF NOT EXISTS cliente (
    DNI_Cliente CHAR(9) NOT NULL,
    codigo CHAR(9) NOT NULL,
    usuario VARCHAR(30) NOT NULL,
    contraseña CHAR(255) NOT NULL,
    direccion VARCHAR(100) NOT NULL,
    correo VARCHAR(50) UNIQUE NOT NULL,
    fec_nac DATE NOT NULL,
    PRIMARY KEY (DNI_Cliente, codigo),
    FOREIGN KEY (DNI_Cliente) REFERENCES usuario(DNI) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
-- Tabla Empleado
CREATE TABLE IF NOT EXISTS empleado (
    DNI_Empleado CHAR(9) NOT NULL PRIMARY KEY,
    usuario VARCHAR(30) NOT NULL,
    contraseña CHAR(255) NOT NULL,
    direccion VARCHAR(100) NOT NULL,
    telefono VARCHAR(15) NOT NULL,
    correo VARCHAR(50) UNIQUE NOT NULL,
    fec_alta DATE NOT NULL,
    puesto VARCHAR(30),
    departamento VARCHAR(30) FOREIGN KEY (DNI_Empleado) REFERENCES usuario(DNI) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
-- Tabla Productos
CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    tipo ENUM('Grano', 'Molido') NOT NULL,
    origen VARCHAR(100),
    precio DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
-- Tabla Pedido
CREATE TABLE IF NOT EXISTS pedido (
    codigo VARCHAR(30) NOT NULL PRIMARY KEY,
    codigo_cliente CHAR(9) NOT NULL,
    nombre VARCHAR(30) NOT NULL,
    tipo ENUM('Grano', 'Molido') NOT NULL,
    precio_total DECIMAL(10, 2) NOT NULL,
    fecha_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado ENUM(
        'Pendiente',
        'Pagado',
        'Enviado',
        'Entregado',
        'Cancelado'
    ) DEFAULT 'Pendiente',
    FOREIGN KEY (codigo_cliente) REFERENCES cliente(codigo) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
-- Tabla Detalles Pedido (relación entre pedido y productos)
CREATE TABLE IF NOT EXISTS detalle_pedido (
    id_detalle INT AUTO_INCREMENT PRIMARY KEY,
    codigo_pedido VARCHAR(30) NOT NULL,
    id_producto INT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10, 2) NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (codigo_pedido) REFERENCES pedido(codigo) ON DELETE CASCADE,
    FOREIGN KEY (id_producto) REFERENCES productos(id) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
-- Tabla Envios
CREATE TABLE IF NOT EXISTS envios (
    id_envio INT AUTO_INCREMENT PRIMARY KEY,
    codigo_pedido VARCHAR(30) NOT NULL,
    direccion_envio VARCHAR(255) NOT NULL,
    transportista VARCHAR(50),
    estado_envio ENUM('En preparación', 'Enviado', 'Entregado') DEFAULT 'En preparación',
    fecha_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (codigo_pedido) REFERENCES pedido(codigo) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;