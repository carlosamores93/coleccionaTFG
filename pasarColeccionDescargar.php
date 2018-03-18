<?php


    $coleccion = $_GET['nombreColeccion'];


    if (!isset($_SESSION)){
        session_start();
        $_SESSION["coleccionTerminada"] = $coleccion;
    }

    //echo $_SESSION["coleccionTerminada"];

    header("Location: descargarColeccion.php");

?>
