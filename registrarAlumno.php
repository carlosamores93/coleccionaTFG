<?php


	include("conectar.php");

	$link = conectarBBDD();

	// Añadir esta linea de codigo para poner acentos y ñ
	mysqli_query($link, "SET NAMES 'utf8'");


	// Vamos a obtener los valores del formulario
	$nombre = $_POST['billing_first_name'];
	$apellidos = $_POST['billing_last_name'];
	$usuario = $_POST['billing_user'];
	$correo = $_POST['billing_email'];
	// El js comprueba que las dos contraseñas insertadas seran iguales
	$pass = $_POST['billing_pass1'];
	$passUsuario = md5($pass);

	echo "$nombre";
	echo "$apellidos";
	echo "$usuario";

	
	$sqlProfesor = "SELECT * FROM profesores 
	WHERE UsuarioProfesor='$usuario'";
	$resultadoProfesor = mysqli_query($link, $sqlProfesor);
	$num_rows_profesor = mysqli_num_rows($resultadoProfesor);

	echo "$num_rows_profesor";


	// Buscamos ne la tabla 
	$sql = "SELECT * FROM alumnos
	WHERE UsuarioAlumno='$usuario'";
	$retval = mysqli_query($link, $sql);
	$num_rows = mysqli_num_rows($retval);

	echo "$num_rows";


	if( $num_rows_profesor == 0 && $num_rows == 0){ // Es que no tenemos registrado en la base de datos ese usuario.

		
/*
	$sql = "SELECT * FROM alumnos, profesores 
	WHERE alumnos.UsuarioAlumno = '$usuario' OR profesores.UsuarioProfesor='$usuario'";
	$retval = mysqli_query($link, $sql);
	$num_rows = mysqli_num_rows($retval);
	echo "$num_rows";
	if($num_rows == 0){
*/
		// Creamos la carpeta para el alumno
		if(!mkdir("img/alumnos/$usuario", 0755)) {
		    die('Fallo al crear las carpeta del alumno.');
		}
		
		// basename() may prevent filesystem traversal attacks;
		$imagen2subir = basename($_FILES["billing_imagen"]["name"]);
		if($imagen2subir == NULL){ // Si no ha elegido foto, le ponemos una foto por defecto.
			$uploads_dir = 'img';
			$imagen = "men.png";
		}else{ // Metemos la foto que el ha elegido
			$uploads_dir = "img/alumnos/$usuario";
			$tmp_name = $_FILES["billing_imagen"]["tmp_name"];
			//echo "<p> tmp = $tmp_name </p>";
			$imagen = basename($_FILES["billing_imagen"]["name"]);
			//echo "<p> imagen = $imagen </p>";
			if(!move_uploaded_file($tmp_name, "$uploads_dir/$imagen")){
				die('Fallo subir la imagen del alumno.');
			}
		}





		// Ingresar los datos en la tabla de alumnos
		$insertar = "INSERT INTO alumnos (UsuarioAlumno, NombreAlumno, ApellidosAlumno, CorreoAlumno,
		PasswordAlumno, FotoAlumno, ColeccionesJuego, ColeccionesFin, NumeroFichas, PreguntasAcertadas, PreguntasFalladas) 
		VALUES ('$usuario', '$nombre', '$apellidos', '$correo', '$passUsuario', '$uploads_dir/$imagen', '0', '0', '0', '0', '0')";
		$meter = mysqli_query($link, $insertar);
		if(!$meter){
			die("No insertado a la base de datos: ". mysql_error());
		}else{
			
			// Cerrar conexion con la bbdd
			mysqli_close($link);
			//echo "<h1> <a href='../html/index.html'> Usuario registrado correctamente.  </a> </h1>";
			header('Location: alumnoRegistrado.php');
		}

	}else{
		// Cerrar conexion con la bbdd
		mysqli_close($link);
		//echo "<h1> <a href='../html/index.html'> Usuario ya registrado, elija otro nombre de usuario. </a> </h1>";
		header('Location: alumnoNoRegistrado.php');
	}


?>







