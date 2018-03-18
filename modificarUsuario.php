<?php


	include_once("conectar.php");

	$link = conectarBBDD();
	// Añadir esta linea de codigo para poner acentos y ñ
	mysqli_query($link, "SET NAMES 'utf8'");


	$usuario = $_GET['usuario'];
	$tipo = $_GET['tipo'];


	// Vamos a obtener los valores del formulario
	$nombre = $_POST['billing_first_name'];
	$apellidos = $_POST['billing_last_name'];
	$correo = $_POST['billing_email'];

/*
	echo "$nombre";
	echo "$apellidos";
	echo "$correo";
*/

	if($tipo == "Profesor"){
		// Modificamos en la tabla de profesores
		$sql = "UPDATE profesores SET NombreProfesor='$nombre', ApellidosProfesor='$apellidos', CorreoProfesor='$correo' 
		WHERE UsuarioProfesor='$usuario'";
	}else{
		// Modificamos en la tabla alumnos
		$sql = "UPDATE alumnos SET NombreAlumno='$nombre', ApellidosAlumno='$apellidos', CorreoAlumno='$correo' 
		WHERE UsuarioAlumno='$usuario'";
	}

	$modificar = mysqli_query($link, $sql);
	if(!$modificar){
		die("No modificado a la base de datos: ". mysql_error());
	}

	// Cerrar conexion con la bbdd
	mysqli_close($link);
	//echo "<h1> <a href='../html/index.html'> Usuario ya registrado, elija otro nombre de usuario. </a> </h1>";
	header("Location: superDetallesUsuario.php");


?>







