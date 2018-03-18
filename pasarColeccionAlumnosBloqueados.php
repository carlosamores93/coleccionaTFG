<?php


    $coleccion = $_GET['coleccion'];


    if (!isset($_SESSION)){
        session_start();
        $_SESSION["coleccion"] = $coleccion;
    }

    //echo $_SESSION["coleccion"];

    header("Location: listarAlumnosBloqueados.php");

?>
