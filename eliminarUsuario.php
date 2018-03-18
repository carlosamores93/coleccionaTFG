<?php

	include("conectar.php");
	include("eliminarDirectorio.php");

	$link = conectarBBDD();
	// Añadir esta linea de codigo para poner acentos y ñ
	mysqli_query($link, "SET NAMES 'utf8'");


	$usuario = $_GET['usuario'];
	$tipo = $_GET['tipo'];


	if($tipo == "Profesor"){
		// Borramos SU  directorio  y todo su contendio
		eliminarDir("img/profesores/$usuario");
		// Borramos en la tabla de profesores
		$sql = "DELETE FROM profesores WHERE  UsuarioProfesor='$usuario'";


	}else{
		// Borramos en la tabla alumnos
		// Borramos SU  directorio  y todo su contendio
		eliminarDir("img/alumnos/$usuario");
		// Borramos en la tabla de alumnos
		$sql = "DELETE FROM alumnos WHERE  UsuarioAlumno='$usuario'";


	}


	$borrar = mysqli_query($link, $sql);
	if(!$borrar){
		die("No borrado de la base de datos: ". mysql_error());
	}

	// Cerrar conexion con la bbdd
	mysqli_close($link);

	if($tipo == "Profesor"){
		//echo "<h1> <a href='../html/index.html'> Usuario ya registrado, elija otro nombre de usuario. </a> </h1>";
		header("Location: superListarProfesores.php");
	}else{
		//echo "<h1> <a href='../html/index.html'> Usuario ya registrado, elija otro nombre de usuario. </a> </h1>";
		header("Location: superListarAlumnos.php");
	}

	
	
?>







