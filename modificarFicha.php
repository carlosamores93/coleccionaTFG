<?php


	include_once("conectar.php");

	$link = conectarBBDD();
	// Añadir esta linea de codigo para poner acentos y ñ
	mysqli_query($link, "SET NAMES 'utf8'");


	if (!isset($_SESSION)){
		session_start();
	}

	// Obtener el usuario
	$usuario = $_SESSION["usuario"];

	// Obtenemos el nombre de la coleccion
	$nombreColeccion = $_GET['nombreColeccion'];
	// Obtengo el id de la ficha
	$idFicha = $_GET['idFicha'];

	// Vamos a obtener los valores del formulario
	$dificultad = $_POST['billing_dificultad'];
	$descripcion = $_POST['billing_descripcion'];
	$orden = $_POST['billing_orden'];

/*

	echo "$idFicha  <--- IdFicha*****";
	echo "NombreColeccion=$nombreColeccion    ----- usuario=$usuario";
	echo "$dificultad ------------------ ";
	echo "$descripcion";

*/

	$imagen2subir = basename($_FILES["billing_imagen"]["name"]);
	if($imagen2subir == NULL){ // Si no ha elegido foto, le dejamos la foto de antes
		$sql = "UPDATE fichas SET DificultadFicha='$dificultad', NumeroFicha='$orden', Descripcion='$descripcion' WHERE IdFicha='$idFicha'";
		$modificar = mysqli_query($link, $sql);
		if(!$modificar){
			die("No modificado a la base de datos: ". mysql_error());
		}
		// Cerrar conexion con la bbdd
		mysqli_close($link);
		//echo "<h1> <a href='../html/index.html'> Usuario ya registrado, elija otro nombre de usuario. </a> </h1>";
		header("Location: detallesFicha.php");
	}else{ // Metemos la foto que el ha elegido
		$uploads_dir = "img/profesores/$usuario/$nombreColeccion/fichas";
		$tmp_name = $_FILES["billing_imagen"]["tmp_name"];
		$imagen = basename($_FILES["billing_imagen"]["name"]);
		

		// Comporbamos que la ficha
		$sql = "SELECT * FROM fichas WHERE NombreColeccion = '$nombreColeccion' AND FotoFicha='$uploads_dir/$imagen'";
		$resultado = mysqli_query($link, $sql);
		$num_rows = mysqli_num_rows($resultado);
		if( $num_rows == 0){

			// Borrar la foto ya que vamos a asignare otra foto a la ficha
			$query="SELECT FotoFicha FROM fichas WHERE IdFicha = '$idFicha'";            
		    if ($result = mysqli_query($link, $query)) {
		        // fetch associative array 
		        while ($row = mysqli_fetch_assoc($result)) {
		            $foto = $row["FotoFicha"];
		        }
		        // free result set 
		        mysqli_free_result($result);
		    }
			// Borra la foto antiogua.
			if(file_exists($foto)){
				unlink($foto);
			}


			if(!move_uploaded_file($tmp_name, "$uploads_dir/$imagen")){
				die('Fallo al modificar la imagen de la coleccion.');
			}
			// Modificamos en la tabla de profesores
			$sql = "UPDATE fichas SET DificultadFicha='$dificultad', 
			Descripcion='$descripcion', NumeroFicha='$orden', FotoFicha='$uploads_dir/$imagen' WHERE IdFicha='$idFicha'";
			$modificar = mysqli_query($link, $sql);
			if(!$modificar){
				die("No modificado a la base de datos: ". mysql_error());
			}
			// Cerrar conexion con la bbdd
			mysqli_close($link);
			//echo "<h1> <a href='../html/index.html'> Usuario ya registrado, elija otro nombre de usuario. </a> </h1>";
			header("Location: detallesFicha.php");
		}else{
			// Cerrar conexion con la bbdd
			mysqli_close($link);
			header("Location: fichaNoModificada.php");
		}

		
	}


?>







