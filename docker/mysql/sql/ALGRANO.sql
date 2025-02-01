CREATE DATABASE IF NOT EXISTS algrano;
USE algrano;

-- Tabla Cliente
CREATE TABLE IF NOT EXISTS cliente (
    codigo CHAR(9) NOT NULL PRIMARY KEY,
    usuario VARCHAR(30) NOT NULL,
    contraseña CHAR(255) NOT NULL,
    direccion VARCHAR(100) NOT NULL,
    correo VARCHAR(50) UNIQUE NOT NULL,
    fec_nac DATE NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Tabla Empleado
CREATE TABLE IF NOT EXISTS empleado (
    DNI CHAR(9) NOT NULL PRIMARY KEY,
    usuario VARCHAR(30) NOT NULL,
    contraseña CHAR(255) NOT NULL,
    direccion VARCHAR(100) NOT NULL,
    telefono VARCHAR(15) NOT NULL,
    correo VARCHAR(50) UNIQUE NOT NULL,
    fec_alta DATE NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Tabla Productos
CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    tipo ENUM('Grano', 'Molido') NOT NULL,
    origen VARCHAR(100),
    precio DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Tabla Pedido
CREATE TABLE IF NOT EXISTS pedido (
    codigo VARCHAR(30) NOT NULL PRIMARY KEY,
    codigo_cliente CHAR(9) NOT NULL,
    nombre VARCHAR(30) NOT NULL,
    tipo ENUM('Grano', 'Molido') NOT NULL,
    precio_total DECIMAL(10,2) NOT NULL,
    fecha_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('Pendiente', 'Pagado', 'Enviado', 'Entregado', 'Cancelado') DEFAULT 'Pendiente',
    FOREIGN KEY (codigo_cliente) REFERENCES cliente(codigo) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Tabla Detalles Pedido (relación entre pedido y productos)
CREATE TABLE IF NOT EXISTS detalle_pedido (
    id_detalle INT AUTO_INCREMENT PRIMARY KEY,
    codigo_pedido VARCHAR(30) NOT NULL,
    id_producto INT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
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


INSERT INTO Cliente
VALUES(
        "CL1",
        "Jxse.zzz",
        "soyclientedealgrano1",
        "Camino de la goleta,21",
        "josemartinez@gmail.com",
        '2003-06-28'
    );
INSERT INTO Cliente
VALUES (
        'CL2',
        'LorenaCerrado',
        'lorena2004',
        'Camino del pedrusco,01',
        'lorenacerrado@gmail.com',
        '1998-01-21'
    );
INSERT INTO Cliente
VALUES (
        'CL3',
        'Miguel',
        'miguelcortejo23',
        'Calle festival,11',
        'miguelcortejo23@gmail.com',
        '2000-03-10'
    );
INSERT INTO Cliente
VALUES (
        'CL4',
        'Anita19',
        'megustaelcafe',
        'Camino del piñon,18',
        'anitacafetera19@gmail.com',
        '1975-05-31'
    );
INSERT INTO Cliente
VALUES (
        'CL5',
        'DanielBlanco',
        'blancocomolaleche',
        'Camino de la pintura,14',
        'danielblanco@gmail.com',
        '2000-01-02'
    );




