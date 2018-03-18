<?php

    $coleccion = $_GET['nombreColeccion'];


    if (!isset($_SESSION)){
        session_start();
        $_SESSION["coleccion"] = $coleccion;
    }

    echo $_SESSION["coleccion"];

    header("Location: detallesColeccion.php");

?>
