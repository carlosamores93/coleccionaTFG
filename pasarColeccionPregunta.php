<?php

    $nombreColeccion = $_GET['nombreColeccion'];
    $pregunta = $_GET['idPregunta'];


    if (!isset($_SESSION)){
        session_start();
        $_SESSION["pregunta"] = $pregunta;
        $_SESSION["coleccion"] = $nombreColeccion;
    }

    //echo $_SESSION["pregunta"];
    //echo $_SESSION["coleccion"];

    header("Location: detallesPregunta.php");

?>
