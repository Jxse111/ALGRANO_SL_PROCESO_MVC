CREATE DATABASE IF NOT EXISTS algrano;

USE algrano;

-- Tabla Rol
CREATE TABLE IF NOT EXISTS rol (
    id_rol CHAR(9) NOT NULL PRIMARY KEY,
    rol VARCHAR(30)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Tabla Usuario
CREATE TABLE IF NOT EXISTS usuario (
    DNI CHAR(9) NOT NULL PRIMARY KEY,
    usuario VARCHAR(30) NOT NULL,
    contraseña CHAR(255) NOT NULL,
    direccion VARCHAR(100) NOT NULL,
    correo VARCHAR(50) UNIQUE NOT NULL,
    fec_nac DATE NOT NULL,
    id_rol_usuario CHAR(9) NOT NULL,
    FOREIGN KEY (id_rol_usuario) REFERENCES rol (id_rol) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Tabla Cliente
CREATE TABLE IF NOT EXISTS cliente (
    DNI_cliente CHAR(9) NOT NULL,
    codigo_cliente CHAR(9) NOT NULL,
    PRIMARY KEY(DNI_cliente,codigo_cliente),
    FOREIGN KEY (DNI_cliente) REFERENCES usuario (DNI) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Tabla Empleado
CREATE TABLE IF NOT EXISTS empleado (
    DNI_empleado CHAR(9) NOT NULL PRIMARY KEY,
    puesto VARCHAR(30),
    departamento VARCHAR(30),
    FOREIGN KEY (DNI_empleado) REFERENCES usuario (DNI) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Tabla Productos
CREATE TABLE IF NOT EXISTS producto (
    id_producto CHAR(9) PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    tipo ENUM('Grano', 'Molido') NOT NULL,
    descripcion TEXT,
    stock INT NOT NULL DEFAULT 0,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    origen VARCHAR(100),
    precio_ud DECIMAL(10, 2) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Tabla Realiza
CREATE TABLE IF NOT EXISTS realiza (
    DNI_usuario CHAR(9) NOT NULL,
    id_producto CHAR(9) NOT NULL,
    PRIMARY KEY(DNI_usuario, id_producto),
    FOREIGN KEY (DNI_usuario) REFERENCES usuario (DNI) ON DELETE CASCADE,
    FOREIGN KEY (id_producto) REFERENCES producto (id_producto) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Tabla Pedido
CREATE TABLE IF NOT EXISTS pedido (
    codigo_pedido CHAR(9) PRIMARY KEY,
    nombre VARCHAR(30) NOT NULL,
    tipo ENUM('Grano', 'Molido') NOT NULL,
    precio_total DECIMAL(10, 2) NOT NULL,
    fecha_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('Pendiente','Pagado','Enviado','Entregado','Cancelado') DEFAULT 'Pendiente'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Tabla Compone
CREATE TABLE IF NOT EXISTS compone(
    id_producto CHAR(9) NOT NULL,
    codigo_pedido CHAR(9) NOT NULL,
    PRIMARY KEY(id_producto, codigo_pedido),
    FOREIGN KEY (id_producto) 
    REFERENCES producto (id_producto) ON DELETE CASCADE,
    FOREIGN KEY (codigo_pedido) 
    REFERENCES pedido (codigo_pedido) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Tabla Detalles Pedido
CREATE TABLE IF NOT EXISTS detalle (
    codigo_detalle CHAR(9) PRIMARY KEY NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    cantidad_descrita INT NOT NULL,
    codigo_pedido CHAR(9) NOT NULL,
    FOREIGN KEY (codigo_pedido) REFERENCES pedido (codigo_pedido) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;