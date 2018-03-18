<?php

    include_once("conectar.php");

    if (!isset($_SESSION)){
        session_start();
    }

    $profe = $_SESSION["usuario"];

    
    if (isset($_GET['usuario'])){
        $alumno = $_GET['usuario'];
    }else{
        $alumno = $_SESSION['alumno'];
    }

    if (isset($_GET['lista'])){
        $lista = $_GET['lista'];
    }

    $link = conectarBBDD();
    // Añadir esta linea de codigo para poner acentos y ñ
    mysqli_query($link, "SET NAMES 'utf8'");
   
 
    // Modificamos en la tabla de profesores
    $sql = "UPDATE mis_alumnos SET PuedeJugar='si', Visto='si'
    WHERE UsuarioAlumno='$alumno' AND UsuarioProfesor='$profe'";
    $modificar = mysqli_query($link, $sql);
    if(!$modificar){
        die("No modificado a la base de datos mis_lumnos: ". mysql_error());
    }
    // Cerrar conexion con la bbdd
    mysqli_close($link);

    if($lista == "si"){
        header("Location: listarAlumnos.php");
    }else{
        header("Location: detallesAlumno.php");
    }

?>