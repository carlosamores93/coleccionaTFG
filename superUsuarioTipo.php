<?php

    $usuario = $_GET['usuario'];
    $tipo = $_GET['tipo'];


    if (!isset($_SESSION)){
        session_start();
        $_SESSION["alumnoProfesor"] = $usuario;
        $_SESSION["tipo"] = $tipo;
    }

    //echo $_SESSION["alumnoProfesor"];
    //echo $_SESSION["tipo"];

    header("Location: superDetallesUsuario.php");

?>
