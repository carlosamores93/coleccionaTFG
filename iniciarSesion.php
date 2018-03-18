<?php
	include_once("conectar.php");
	$link = conectarBBDD();
	// Añadir esta linea de codigo para poner acentos y ñ
	mysqli_query($link, "SET NAMES 'utf8'");



	// Vamos a obtener los valores del formulario
	$usuario = $_POST['username'];
	$pass = $_POST['password'];
	// Encriptamos la contraseña
	$passUsuario = md5($pass);


/*
	echo "$usuario";
	echo "$pass";
	echo "$passUsuario";


*/

	////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// BUSCAMOS EN LA TABLA SUPER
	////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$super = "";
	$query="SELECT UsuarioSuper FROM superadmin WHERE UsuarioSuper='$usuario' AND PasswordSuper='$passUsuario'";            
    if ($result = mysqli_query($link, $query)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $super = $row["UsuarioSuper"];
        }
        mysqli_free_result($result);
    }
    if($super != ""){ 
    	// Hemos encontrado un super
    	if(strcmp($usuario, $super) == 0){
    		// El usuario del super es correcto, teniendo en cuenta las mayusculas y minusculas.
    		session_start();
			$_SESSION["loginSuper"] = true;
			$_SESSION["usuario"] = $usuario;
			// Cerrar conexion con la bbdd
			mysqli_close($link);
			header('Location: inicioSuper.php');
    	}else{
    		// El usuario del super no es correcto.
    		mysqli_close($link);
			header('Location: noLogin.php');
    	}
    }else{
		////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// BUSCAMOS EN LA TABLA PROFESORES
		////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$profe = "";
		$query="SELECT UsuarioProfesor FROM profesores WHERE UsuarioProfesor='$usuario' AND PasswordProfesor='$passUsuario'";            
	    if ($result = mysqli_query($link, $query)) {
	        while ($row = mysqli_fetch_assoc($result)) {
	            $profe = $row["UsuarioProfesor"];
	        }
	        mysqli_free_result($result);
	    }
	    if($profe != ""){ 
	    	// Hemos encontrado un profe
	    	if(strcmp($usuario, $profe) == 0){
	    		// El usuario del profesor es correcto, teniendo en cuenta las mayusculas y minusculas.
	    		session_start();
				$_SESSION["loginProfesor"] = true;
				$_SESSION["usuario"] = $usuario;
				// Cerrar conexion con la bbdd
				mysqli_close($link);
				header('Location: inicioProfesor.php');
	    	}else{
	    		// El usuario del profesor no es correcto.
	    		mysqli_close($link);
				header('Location: noLogin.php');
			}
    	}else{
    		////////////////////////////////////////////////////////////////////////////////////////////////////////////
			// BUSCAMOS EN LA TABLA ALUMNOS
			////////////////////////////////////////////////////////////////////////////////////////////////////////////
    		$alumno = "";
			$query="SELECT UsuarioAlumno FROM alumnos WHERE UsuarioAlumno='$usuario' AND PasswordAlumno='$passUsuario'";            
		    if ($result = mysqli_query($link, $query)) {
		        while ($row = mysqli_fetch_assoc($result)) {
		            $alumno = $row["UsuarioAlumno"];
		        }
		        mysqli_free_result($result);
		    }
		    if($alumno != ""){ 
		    	// Hemos encontrado un alumno
		    	if(strcmp($usuario, $alumno) == 0){
		    		// El usuario del alumno es correcto, teniendo en cuenta las mayusculas y minusculas.
		    		session_start();
					$_SESSION["loginAlumno"] = true;
					$_SESSION["usuario"] = $usuario;
					// Cerrar conexion con la bbdd
					mysqli_close($link);
					header('Location: inicioAlumno.php');
		    	}else{
		    		// El usuario del profesor no es correcto.
		    		mysqli_close($link);
					header('Location: noLogin.php');
				}
	    	}else{
	    		// No tenemos ese usuario registrado
	    		mysqli_close($link);
				header('Location: noLogin.php');
	    	}
    	}
    }
	
?>







