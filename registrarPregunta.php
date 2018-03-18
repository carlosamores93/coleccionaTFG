<?php
	

	include_once("conectar.php");

	$link = conectarBBDD();

	// Añadir esta linea de codigo para poner acentos y ñ
	mysqli_query($link, "SET NAMES 'utf8'");

	if (!isset($_SESSION)){
		session_start();
	}

	// Obtenemos el nombre de la coleccion
	$nombreColeccion = $_SESSION['coleccion'];


	// Vamos a obtener los valores del formulario
	$dificultad = $_POST['billing_dificultad'];
	$tiempo = $_POST['billing_tiempo'];
	$monedas = $_POST['billing_monedas'];
	$enunciado = $_POST['billing_enunciado'];
	$respuestaCorrecta = $_POST['billing_correcta'];
	$respuesta1Incorrecta = $_POST['billing_incorrecta1'];
	$respuesta2Incorrecta = $_POST['billing_incorrecta2'];
	$respuesta3Incorrecta = $_POST['billing_incorrecta3'];
	
		


	// Ingresar los datos en la tabla de preguntas
	$insertar = "INSERT INTO preguntas (
	NombreColeccion, DificultadPregunta,
	Tiempo, Monedas, Enunciado, RespuestaCorrecta, RespuestaIncorrecta1,
	RespuestaIncorrecta2, RespuestaIncorrecta3, 
	Frecuencia, Fallos, Aciertos ) 
	VALUES ('$nombreColeccion','$dificultad',
	'$tiempo', '$monedas','$enunciado','$respuestaCorrecta', '$respuesta1Incorrecta',
	'$respuesta2Incorrecta', '$respuesta3Incorrecta', 
	'0','0', '0')";
	$meter = mysqli_query($link, $insertar);
	if(!$meter){
		die("No insertado a la base de datos: ". mysql_error());
	}else{

		/*
		// Actualizamos el numero de preguntas de la coelccion
	    $sql = "UPDATE colecciones SET NumeroPreguntas=NumeroPreguntas+1 WHERE NombreColeccion='$nombreColeccion'";
		$modificar = mysqli_query($link, $sql);
		if(!$modificar){
			die("No modificado a la base de datos: ". mysql_error());
		}
		*/
		
		// Cerrar conexion con la bbdd
		mysqli_close($link);
		//echo "<h1> <a href='../html/index.html'> Usuario registrado correctamente.  </a> </h1>";
		header("Location: listarPreguntas.php");
	}
	
?>







