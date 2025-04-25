<?php
session_start();
require_once '../Modelo/Algrano.php';
require_once '../Modelo/Producto.php';

// Inicializa la cesta si no existe
if (!isset($_SESSION['cesta'])) {
    $_SESSION['cesta'] = []; // Inicializa la cesta como un array vacío
}

$conexionBD = Algrano::conectarAlgranoMySQLi();

// Maneja el cierre de sesión
if (isset($_POST['logoff'])) {
    session_destroy();
    header('Location: login.php');
    exit();
}

// Maneja la adición de productos a la cesta
if (isset($_POST['enviar']) && isset($_POST['producto'])) {
    $_SESSION['cesta'][] = $_POST['producto'];
}

// Maneja la compra
if (isset($_POST['comprar'])) {
    header('Location: comprar.php');
    exit();
}

$productos = Producto::listarProductos(); // Obtiene los productos
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Productos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        #productos {
            margin: 20px;
        }

        .producto-item {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
        }

        .producto-item label {
            font-weight: bold;
        }

        .botones {
            margin-top: 10px;
        }

        footer {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>

<body>
    <h1>Lista de Productos</h1>
    <div id='productos'>
        <ul>
            <?php foreach ($productos as $producto) { ?>
                <li class="producto-item">
                    <label>Nombre:</label> <?php echo $producto['nombre']; ?><br>
                    <label>Precio:</label> <?php echo $producto['precioUnitario']; ?> €<br>
                    <form action="" method="post" class="botones">
                        <input type="hidden" name="producto" value="<?php echo $producto['idProducto']; ?>">
                        <button type="submit" name="enviar">Añadir</button>
                    </form>
                </li>
            <?php } ?>
        </ul>
    </div>
    <form method="post">
        <button type='submit' name='comprar'>Comprar</button>
    </form>
    <footer>
        <form method='post' action=''>
            <div class='desconexion'>
                <input type='submit' name='logoff' value='Cerrar Sesión'>
            </div>
        </form>
    </footer>
</body>

</html>