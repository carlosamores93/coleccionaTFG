<?php

    $profesor = $_GET['usuario'];
    $nombreColeccion = $_GET['nombreColeccion'];


    if (!isset($_SESSION)){
        session_start();
        $_SESSION["profesor"] = $profesor;
        $_SESSION["coleccion"] = $nombreColeccion;
    }

    //echo $_SESSION["profesor"];
    //echo $_SESSION["coleccion"];

    header("Location: superDetallesColeccion.php");

?>
