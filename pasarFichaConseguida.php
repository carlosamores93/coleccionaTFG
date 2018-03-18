<?php

    $ficha = $_GET['idFicha'];


    if (!isset($_SESSION)){
        session_start();
        $_SESSION["fichaConseguida"] = $ficha;
    }

    //echo $_SESSION["ficha"];
    //echo $_SESSION["coleccion"];

    header("Location: verFicha.php");

?>
