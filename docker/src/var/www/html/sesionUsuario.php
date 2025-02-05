<?php
session_start();
$caducidadSesion = 1200;
if (isset($_SESSION['hora_inicio'])) {
    $tiempoTranscurridoSesion = time() - $_SESSION['hora_inicio'];

    //Si el tiempo transcurrido se excede del límite
    if ($tiempoTranscurridoSesion > $caducidadSesion) {
        echo "Finalizando sesión...";
        session_destroy(); //Eliminamos la sesión
        header("Location: index.html"); //Redirigimos al formulario de inicio de sesión al usuario de la sesión
    }
} else {
    $_SESSION['hora_inicio'] = time();
}
//echo var_dump($_SESSION);
if (isset($_SESSION['usuario'])) {
    echo nl2br("Ya estas logeado, " . $_SESSION['rol'] . "\n");
    ?> 
    <br><br>
    <?php
    //Mostramos la web de ejemplo
//    include_once './index.html';
    ?> 
    <?php
    //Si se pulsa en cerrar sesión se borra la sesión y vuelve al formulario principal
    include_once './cerrarSesion.html';
    if (filter_has_var(INPUT_POST, "cerrarSesion")) {
        session_destroy();
    }
}

