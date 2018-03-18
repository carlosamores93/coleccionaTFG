<?php

	include_once("conectar.php");
	include_once("eliminarDirectorio.php");

	$link = conectarBBDD();
	// Añadir esta linea de codigo para poner acentos y ñ
	mysqli_query($link, "SET NAMES 'utf8'");




	// Usuario y nombre del la coleccion
	$usuario = $_GET['usuario'];

	$nombre = $_GET['nombreColeccion'];

	//echo "uuseraroi= $usuario ------ NombreColeccion = $nombre";


	// Borramos SU  directorio  y todo su contendio
	eliminarDir("img/profesores/$usuario/$nombre");

	// Borramos en la tabla de alumnos
	$sql = "DELETE FROM colecciones WHERE  NombreColeccion='$nombre'";
	$borrar = mysqli_query($link, $sql);
	if(!$borrar){
		die("No borrado de la base de datos: ". mysql_error());
	}


	// Cerrar conexion con la bbdd
	mysqli_close($link);
	header("Location: superListarColecciones.php");
	
?>







