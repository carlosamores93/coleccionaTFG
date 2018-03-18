<?php


	include_once("conectar.php");

	$link = conectarBBDD();
	// Añadir esta linea de codigo para poner acentos y ñ
	mysqli_query($link, "SET NAMES 'utf8'");


	// Obtenemos el nombre de la coleccion
	$nombreColeccion = $_GET['nombreColeccion'];
	// Obtengo el id de la pregunta
	$idPregunta = $_GET['idPregunta'];


	// Vamos a obtener los valores del formulario
	$dificultad = $_POST['billing_dificultad'];
	$tiempo = $_POST['billing_tiempo'];
	$monedas = $_POST['billing_monedas'];
	$enunciado = $_POST['billing_enunciado'];
	$respuestaCorrecta = $_POST['billing_correcta'];
	$respuesta1Incorrecta = $_POST['billing_incorrecta1'];
	$respuesta2Incorrecta = $_POST['billing_incorrecta2'];
	$respuesta3Incorrecta = $_POST['billing_incorrecta3'];



	$sql = "UPDATE preguntas SET DificultadPregunta='$dificultad',
	Tiempo='$tiempo', Monedas='$monedas', Enunciado='$enunciado',
	RespuestaCorrecta='$respuestaCorrecta', 
	RespuestaIncorrecta1='$respuesta1Incorrecta',
	RespuestaIncorrecta2='$respuesta2Incorrecta',
	RespuestaIncorrecta3='$respuesta3Incorrecta'
	WHERE IdPregunta='$idPregunta'";
	$modificar = mysqli_query($link, $sql);
	if(!$modificar){
		die("No modificado a la base de datos: ". mysql_error());
	}

	// Cerrar conexion con la bbdd
	mysqli_close($link);
	//echo "<h1> <a href='../html/index.html'> Usuario ya registrado, elija otro nombre de usuario. </a> </h1>";
	header("Location: detallesPregunta.php");



?>







