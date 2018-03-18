<?php


	include("conectar.php");

	$link = conectarBBDD();
	// Añadir esta linea de codigo para poner acentos y ñ
	mysqli_query($link, "SET NAMES 'utf8'");

	if (!isset($_SESSION)){
		session_start();
	}
	$usuario = $_SESSION['usuario'];
	

	// Vamos a obtener los valores del formulario
	$nombre = $_POST['billing_first_name'];
	$apellidos = $_POST['billing_last_name'];
	$correo = $_POST['billing_email'];
	$pass = $_POST['billing_pass1'];
	$passUsuario = md5($pass);

/*
	echo "$usuario";
	echo "$nombre";
	echo "$apellidos";
	echo "$correo";
	echo "$imagen2subir";
*/

	$imagen2subir = basename($_FILES["billing_imagen"]["name"]);
	if($imagen2subir == NULL){ // Si no ha elegido foto, le ponemos una foto por defecto.
		// Modificamos en la tabla de profesores
		$sql = "UPDATE profesores SET NombreProfesor='$nombre', ApellidosProfesor='$apellidos', CorreoProfesor='$correo',
		PasswordProfesor='$passUsuario' WHERE UsuarioProfesor='$usuario'";
		$modificar = mysqli_query($link, $sql);
		if(!$modificar){
			die("No modificado a la base de datos: ". mysql_error());
		}
	}else{ 

		// antes de cargar la nueva foto, borramos la foto anterior.
		$query="SELECT FotoProfesor FROM profesores WHERE UsuarioProfesor = '$usuario'";            
	    if ($result = mysqli_query($link, $query)) {
	        // fetch associative array 
	        while ($row = mysqli_fetch_assoc($result)) {
	            $foto = $row["FotoProfesor"];
	        }
	        // free result set 
	        mysqli_free_result($result);
	    }
	    // Borrar si no es la foto por defecto
	    $fotoPorDefecto="img/men.png";
		// Borra la foto antiogua.
		if($foto != $fotoPorDefecto){
			if(!unlink("$foto")){
				echo "No borrado la foto del profesor";
			}
		}
		

		// Metemos la foto que el ha elegido
		$uploads_dir = "img/profesores/$usuario";
		$tmp_name = $_FILES["billing_imagen"]["tmp_name"];
		//echo "<p> tmp = $tmp_name </p>";
		$imagen = basename($_FILES["billing_imagen"]["name"]);
		//echo "<p> imagen = $imagen </p>";
		if(!move_uploaded_file($tmp_name, "$uploads_dir/$imagen")){
			echo "Fallo al modificar la imagen del profesor.";

		}

		// Modificamos en la tabla de profesores
		$sql = "UPDATE profesores SET NombreProfesor='$nombre', ApellidosProfesor='$apellidos', 
		CorreoProfesor='$correo', PasswordProfesor='$passUsuario', FotoProfesor='$uploads_dir/$imagen'
		WHERE UsuarioProfesor='$usuario'";
		$modificar = mysqli_query($link, $sql);
		if(!$modificar){
			die("No modificado a la base de datos: ". mysql_error());
		}
	}

	// Cerrar conexion con la bbdd
	mysqli_close($link);
	header("Location: miPerfilProfesor.php");


?>







