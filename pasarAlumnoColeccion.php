<?php

    $alumno = $_GET['usuario'];


    if (!isset($_SESSION)){
        session_start();
        $_SESSION["alumno"] = $alumno;
    }

    echo $_SESSION["alumno"];

    header("Location: detallesAlumnoColeccion.php");

?>
