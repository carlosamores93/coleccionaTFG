<?php

    include_once("conectar.php");

    if (!isset($_SESSION)){
        session_start();
    }

	

    
    if (isset($_GET['usuario'])){
        $alumno = $_GET['usuario'];
    }
	
	 if (isset($_GET['coleccion'])){
        $nombreColeccion = $_GET['coleccion'];
    }

   

    $link = conectarBBDD();
    // Añadir esta linea de codigo para poner acentos y ñ
    mysqli_query($link, "SET NAMES 'utf8'");
   
 
    // Modificamos en la tabla de profesores
    $sql = "UPDATE juega_colecciones SET EstadoColeccion ='bloqueada'
    WHERE UsuarioAlumno='$alumno' AND NombreColeccion='$nombreColeccion'";
    $modificar = mysqli_query($link, $sql);
    if(!$modificar){
        die("No modificado a la base de datos mis_lumnos: ". mysql_error());
    }
    // Cerrar conexion con la bbdd
    mysqli_close($link);

    if (isset($_GET['perfil'])){
        header("Location: detallesAlumnoColeccion.php");
    }else{
        header("Location: listarAlumnosBloqueados.php");
    }
?>