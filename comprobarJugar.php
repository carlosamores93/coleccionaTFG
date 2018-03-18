<?php
	

	include_once("conectar.php");

	$link = conectarBBDD();
	
	if (!isset($_SESSION)){
			session_start();
	}

	// Añadir esta linea de codigo para poner acentos y ñ
	mysqli_query($link, "SET NAMES 'utf8'");

	$usuario = $_SESSION["usuario"];
	$claveColeccion = $_POST['clave'];
	echo "$claveColeccion";
	
	
    // Obtengo el nombre de la coleccion
    $nombreColeccion = $_GET['nombreColeccion'];
	$nombreProfesor = $_GET['nombreProfesor'];
	
	echo "$nombreColeccion";
	echo "$nombreProfesor";


	$sql = "SELECT * FROM mis_alumnos WHERE UsuarioAlumno='$usuario' AND UsuarioProfesor='$nombreProfesor'";
	$resultado = mysqli_query($link, $sql);
	$num_rows = mysqli_num_rows($resultado);

	if( $num_rows == 0){

		
		// Añadimos a la base de datos
		$puedoJugar = "no";
		$visto = "no";
		// Insertamos los datos en la tabla colecciones
		$insertar = "INSERT INTO mis_alumnos ( UsuarioProfesor, UsuarioAlumno ,PuedeJugar, Visto) 
		VALUES ('$nombreProfesor', '$usuario', '$puedoJugar', '$visto')";
		$meter = mysqli_query($link, $insertar);
		if(!$meter){
			die("No insertado a la base de datos: ". mysql_error());
		}else{

			// Cerrar conexion con la bbdd
			mysqli_close($link);
			//echo "Espera a que el profe te de de alta";	
			header('Location: pidiendoAlta.php');
		}

	}else{
		
		if ($result = mysqli_query($link, $sql)) {
				// fetch associative array 
			while ($row = mysqli_fetch_assoc($result)) {
				$puedoJugar = $row["PuedeJugar"];
			}
			// free result set 
			mysqli_free_result($result);
		}
		
		if($puedoJugar=="no"){
			
			// Cerrar conexion con la bbdd
			mysqli_close($link);
			
			//echo "Ten paciencia, el profesor pronto te dará de alta";	
			header('Location: esperandoAlta.php');
			
		}else{
			
			$sql = "SELECT Clave FROM colecciones WHERE nombreColeccion='$nombreColeccion'";
			if ($result = mysqli_query($link, $sql)) {
				// fetch associative array 
				while ($row = mysqli_fetch_assoc($result)) {
					$clave = $row["Clave"];
				}
				// free result set 
				mysqli_free_result($result);
			}
			

			if($clave!=$claveColeccion){
				
				// Cerrar conexion con la bbdd
				mysqli_close($link);
				//echo "Las claves no coinciden";
				header('Location: claveIncorrecta.php');
				
			}else{
			
				$estado="juego";
				$fichas="0";
				$monedas="0";
				// Obtenr el numero de vidas iniciales de unac oelccion
				$sql = "SELECT Vida FROM colecciones WHERE nombreColeccion='$nombreColeccion'";
				if ($result = mysqli_query($link, $sql)) {
					// fetch associative array 
					while ($row = mysqli_fetch_assoc($result)) {
						$vidas = $row["Vida"];
					}
					// free result set 
					mysqli_free_result($result);
				}
				// Insertamos los datos en la tabla colecciones
				$insertar = "INSERT INTO juega_colecciones 
				(UsuarioAlumno, NombreColeccion, EstadoColeccion, FichasConseguidas, Monedas, Vidas) 
				VALUES ('$usuario','$nombreColeccion', '$estado', '$fichas', '$monedas','$vidas')";
				$meter = mysqli_query($link, $insertar);
				if(!$meter){
					die("No insertado a la base de datos: ". mysql_error());
				}else{

					// Cerrar conexion con la bbdd
					mysqli_close($link);
					//echo "tendria que ir a jugar";
					$_SESSION["coleccionEmpezada"] =  $nombreColeccion;
					header('Location: coleccionJugar.php');
				}
		
			}

				
		}
				
	}

?>







