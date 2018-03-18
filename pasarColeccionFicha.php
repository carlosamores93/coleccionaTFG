<?php

    $nombreColeccion = $_GET['nombreColeccion'];
    $ficha = $_GET['idFicha'];


    if (!isset($_SESSION)){
        session_start();
        $_SESSION["ficha"] = $ficha;
        $_SESSION["coleccion"] = $nombreColeccion;
    }

    //echo $_SESSION["ficha"];
    //echo $_SESSION["coleccion"];

    header("Location: detallesFicha.php");

?>
