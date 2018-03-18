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

	echo "$profe";
	echo "$alumno";

    $link = conectarBBDD();
    // Añadir esta linea de codigo para poner acentos y ñ
    mysqli_query($link, "SET NAMES 'utf8'");
   
 
    // Modificamos en la tabla de profesores
    $sql = "UPDATE mis_alumnos SET Visto='si'
    WHERE UsuarioAlumno='$alumno' AND UsuarioProfesor='$profe'";
    $modificar = mysqli_query($link, $sql);
    if(!$modificar){
        die("No modificado a la base de datos mis_lumnos: ". mysql_error());
    }
    // Cerrar conexion con la bbdd
    mysqli_close($link);

    header("Location: pasarAlumno.php?usuario=$alumno");
   

?>