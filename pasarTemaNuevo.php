<?php

    $tema = $_GET['tema'];


    if (!isset($_SESSION)){
        session_start();
        $_SESSION["tema"] = $tema;
    }

    //echo $_SESSION["tema"];

   header("Location: coleccionesTemasNuevos.php");

?>
