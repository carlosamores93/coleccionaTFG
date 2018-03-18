<?php

	include_once("conectar.php");

	$link = conectarBBDD();
	// Añadir esta linea de codigo para poner acentos y ñ
	mysqli_query($link, "SET NAMES 'utf8'");



	$nombreColeccion = $_GET['nombreColeccion'];
	$idPregunta = $_GET['idPregunta'];


	// Borramos en la tabla de alumnos
	$sql = "DELETE FROM preguntas WHERE  idPregunta='$idPregunta'";
	$borrar = mysqli_query($link, $sql);
	if(!$borrar){
		die("No borrado de la base de datos: ". mysql_error());
	}


/*
	// Actualizamos el numero de preguntas de la coleccion.
    $sql = "UPDATE colecciones SET NumeroPreguntas=NumeroPreguntas-1 WHERE NombreColeccion='$nombreColeccion'";
	$modificar = mysqli_query($link, $sql);
	if(!$modificar){
		die("No modificado a la base de datos: ". mysql_error());
	}
	*/

	// Cerrar conexion con la bbdd
	mysqli_close($link);
	header("Location: listarPreguntas.php");
	
?>







