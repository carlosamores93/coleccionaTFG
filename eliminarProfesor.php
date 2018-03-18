<?php

	include("conectar.php");
	include("eliminarDirectorio.php");

	$link = conectarBBDD();
	// Añadir esta linea de codigo para poner acentos y ñ
	mysqli_query($link, "SET NAMES 'utf8'");


	if (!isset($_SESSION)){
		session_start();
	}

	$usuario = $_SESSION['usuario'];


	// Borramos SU  directorio  y todo su contendio
	eliminarDir("img/profesores/$usuario");

	
	// Borramos en la tabla de profesores
	$sql = "DELETE FROM profesores WHERE  UsuarioProfesor='$usuario'";


	$borrar = mysqli_query($link, $sql);
	if(!$borrar){
		die("No borrado de la base de datos: ". mysql_error());
	}
	// Cerrar conexion con la bbdd
	mysqli_close($link);

	// Cerrramos la sesion
	//Free all session variables
	session_unset();
	//Destruye toda la información registrada de una sesión
	session_destroy();
	header("Location: index.php");	
	

?>







