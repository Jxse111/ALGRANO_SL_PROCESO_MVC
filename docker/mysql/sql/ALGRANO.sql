CREATE DATABASE IF NOT EXISTS algrano;
USE algrano;
/*FALTA INFORMACIÓN EN LA TABLA CLIENTE*/
CREATE TABLE IF NOT EXISTS `cliente` (
    `codigo` char(9) NOT NULL,
    `usuario` varchar(30) DEFAULT NULL,
    `contraseña` char(255) DEFAULT NULL,
    `dirección` varchar(30) DEFAULT NULL,
    `correo` varchar(30) DEFAULT NULL,
    `fec_nac` date DEFAULT NULL,
    PRIMARY KEY (`codigo`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci
/*INSERCIÓN DE REGISTROS DE EJEMPLO*/
INSERT INTO Cliente
VALUES(
        "CL1",
        "Jxse.zzz",
        "soyclientedealgrano1",
        "Camino de la goleta,21",
        "josemartinez@gmail.com",
        '28/06/2003'
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
/*FALTA INFORMACIÓN EN LA TABLA EMPLEADO*/
CREATE TABLE `empleado` (
    `DNI` char(9) NOT NULL,
    `usuario` varchar(30) DEFAULT NULL,
    `contraseña` char(255) DEFAULT NULL,
    `dirección` varchar(30) DEFAULT NULL,
    `teléfono` int DEFAULT NULL,
    `correo` varchar(30) DEFAULT NULL,
    `fec_alta` date DEFAULT NULL,
    PRIMARY KEY (`DNI`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*FALTA INFORMACIÓN EN LA TABLA PEDIDO*/
CREATE TABLE `pedido` (
    `codigo_cliente` char(9) DEFAULT NULL,
    `codigo` varchar(30) NOT NULL,
    `nombre` varchar(30) DEFAULT NULL,
    `tipo` enum('Grano', 'Molido') DEFAULT NULL,
    `precio_total` int(11) DEFAULT NULL,
    PRIMARY KEY (`codigo`),
    KEY `fk_codigo_cliente` (`codigo_cliente`),
    CONSTRAINT `fk_codigo_cliente` FOREIGN KEY (`codigo_cliente`) REFERENCES `cliente` (`codigo`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci