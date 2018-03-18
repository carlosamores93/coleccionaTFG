<?php


    $coleccion = $_GET['nombreColeccion'];


    if (!isset($_SESSION)){
        session_start();
        $_SESSION["coleccionEmpezada"] = $coleccion;
    }

    //echo $_SESSION["coleccionEmpezada"];

    header("Location: coleccionJugar.php");

?>
