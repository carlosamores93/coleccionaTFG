<?php


	include_once("conectar.php");
	include_once("eliminarDirectorio.php");

	$link = conectarBBDD();
	// Añadir esta linea de codigo para poner acentos y ñ
	mysqli_query($link, "SET NAMES 'utf8'");

	if (!isset($_SESSION)){
		session_start();
	}
	$usuario = $_SESSION['usuario'];
	



	// Vamos a obtener los valores del formulario
	$nuevoUsuario = $_POST['billing_usuario'];
	$nombre = $_POST['billing_first_name'];
	$apellidos = $_POST['billing_last_name'];
	$pass = $_POST['billing_pass1'];
	$passUsuario = md5($pass);

/*
	echo "$usuario";
	echo "$nombre";
	echo "$apellidos";
	echo "$imagen2subir";
*/


	if($usuario != $nuevoUsuario){

		// Primero comporbar que el nuevo nombre de usuario no exista ni en la tabla profsores ni alumnos ni en la de super
		$sqlProfesor = "SELECT * FROM profesores 
		WHERE UsuarioProfesor='$nuevoUsuario'";
		$resultadoProfesor = mysqli_query($link, $sqlProfesor);
		$num_rows_profesor = mysqli_num_rows($resultadoProfesor);
		echo "$num_rows_profesor";
		// Buscamos ne la tabla alumnos
		$sql = "SELECT * FROM alumnos
		WHERE UsuarioAlumno='$nuevoUsuario'";
		$retval = mysqli_query($link, $sql);
		$num_rows = mysqli_num_rows($retval);
		echo "$num_rows";

		$sqlSuper = "SELECT * FROM superadmin
		WHERE UsuarioSuper='$nuevoUsuario'";
		$retvalSuper = mysqli_query($link, $sqlSuper);
		$num_rows_super = mysqli_num_rows($retvalSuper);
		echo "$num_rows_super";

		if( $num_rows_profesor == 0 && $num_rows == 0 && $num_rows_super == 0){ 
		// Es que no tenemos registrado en la base de datos ese usuario.
			// Borramos la carpeta anterior donde guardaba su foto
			if (file_exists("img/super/$usuario")) {
			    echo "El fichero  existe";
			    // Si el directorio existe lo borramos entero
			    // Borramos SU  directorio  y todo su contendio
				eliminarDir("img/super/$usuario");
			}
			// Creamos la carpeta para el nuevo usuario super
			if(!mkdir("img/super/$nuevoUsuario", 0755)) {
			    die('Fallo al crear las carpeta del super.');
			}


			$imagen2subir = basename($_FILES["billing_imagen"]["name"]);
			if($imagen2subir == NULL){ // Si no ha elegido foto, le ponemos una foto por defecto.
				$fotoSuper = "img/super.png";
				$sql = "UPDATE superadmin SET UsuarioSuper='$nuevoUsuario', NombreSuper='$nombre', ApellidosSuper='$apellidos',
				PasswordSuper='$passUsuario', FotoSuper='$fotoSuper' WHERE UsuarioSuper='$usuario'";
				$modificar = mysqli_query($link, $sql);
				if(!$modificar){
					die("No modificado a la base de datos1: ". mysql_error());
				}
				$_SESSION['usuario'] = "$nuevoUsuario";
			}else{
				// Metemos la foto que el ha elegido
				$uploads_dir = "img/super/$nuevoUsuario";
				$tmp_name = $_FILES["billing_imagen"]["tmp_name"];
				$imagen = basename($_FILES["billing_imagen"]["name"]);
				if(!move_uploaded_file($tmp_name, "$uploads_dir/$imagen")){
					die('Fallo al modificar la imagen del super.');
				}

				// Modificamos en la tabla de profesores
				$sql = "UPDATE superadmin SET UsuarioSuper='$nuevoUsuario', NombreSuper='$nombre', ApellidosSuper='$apellidos', 
				PasswordSuper='$passUsuario', FotoSuper='$uploads_dir/$imagen'
				WHERE UsuarioSuper='$usuario'";
				$modificar = mysqli_query($link, $sql);
				if(!$modificar){
					die("No modificado a la base de datos2: ". mysql_error());
				}
				$_SESSION['usuario'] = "$nuevoUsuario";
			}













		}





	}else{
		// Si el usuario no se cambia, solo cambiamos la foto y los datos de la tabla.

		$imagen2subir = basename($_FILES["billing_imagen"]["name"]);
		if($imagen2subir == NULL){ // Si no ha elegido foto, le ponemos una foto por defecto.
			$sql = "UPDATE superadmin SET NombreSuper='$nombre', ApellidosSuper='$apellidos',
			PasswordSuper='$passUsuario' WHERE UsuarioSuper='$usuario'";
			$modificar = mysqli_query($link, $sql);
			if(!$modificar){
				die("No modificado a la base de datos1: ". mysql_error());
			}
		}else{
			// antes de cargar la nueva foto, borramos la foto anterior.
			$query="SELECT FotoSuper FROM superadmin WHERE UsuarioSuper = '$usuario'";            
		    if ($result = mysqli_query($link, $query)) {
		        // fetch associative array 
		        while ($row = mysqli_fetch_assoc($result)) {
		            $foto = $row["FotoSuper"];
		        }
		        // free result set 
		        mysqli_free_result($result);
		    }
		    // Borrar si no es la foto por defecto
		    $fotoPorDefecto="img/super.png";
			// Borra la foto antiogua.
			if($foto != $fotoPorDefecto){
				if(!unlink("$foto")){
					die("No borrado la foto del super");
				}
			}
			

			// Metemos la foto que el ha elegido
			$uploads_dir = "img/super/$usuario";
			$tmp_name = $_FILES["billing_imagen"]["tmp_name"];
			$imagen = basename($_FILES["billing_imagen"]["name"]);
			if(!move_uploaded_file($tmp_name, "$uploads_dir/$imagen")){
				die('Fallo al modificar la imagen del super.');
			}

			// Modificamos en la tabla de profesores
			$sql = "UPDATE superadmin SET NombreSuper='$nombre', ApellidosSuper='$apellidos', 
			PasswordSuper='$passUsuario', FotoSuper='$uploads_dir/$imagen'
			WHERE UsuarioSuper='$usuario'";
			$modificar = mysqli_query($link, $sql);
			if(!$modificar){
				die("No modificado a la base de datos2: ". mysql_error());
			}
		}
	}


	

	// Cerrar conexion con la bbdd
	mysqli_close($link);
	header("Location: miPerfilSuper.php");

?>







