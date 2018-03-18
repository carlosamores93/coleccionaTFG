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
	$nombreColeccion = $_SESSION['coleccion'];
	

	// Vamos a obtener los valores del formulario
	$dificultad = $_POST['billing_dificultad'];
	$orden = $_POST['billing_orden'];

	$dir = "img/profesores/$usuario/$nombreColeccion/fichas";
	$tmp_name = $_FILES["billing_imagen"]["tmp_name"];
	$imagen = basename($_FILES["billing_imagen"]["name"]);

	$descripcion = $_POST['billing_descripcion'];


	$sql = "SELECT * FROM fichas WHERE NombreColeccion = '$nombreColeccion' AND FotoFicha='$dir/$imagen'";
	$resultado = mysqli_query($link, $sql);
	$num_rows = mysqli_num_rows($resultado);
	if( $num_rows == 0){
/*
		echo "$usuario ---------";
		echo "$nombreColeccion ----------- ";
		echo "$dificultad ----------";
		echo "$descripcion ------------- ";
		echo "$dir/$imagen ---------------";
*/

		// Metemos la ficha en la carpeta de la respecta colecciones
		if(move_uploaded_file($tmp_name, "$dir/$imagen")){
			// Insertamos los datos en la tabla fichas
			$insertar = "INSERT INTO fichas ( NombreColeccion, DificultadFicha, Descripcion, FotoFicha, NumeroFicha) 
			VALUES ('$nombreColeccion', '$dificultad', '$descripcion' ,'$dir/$imagen', '$orden')";
			$meter = mysqli_query($link, $insertar);
			if(!$meter){
				die("No insertado a la base de datos: ". mysql_error());
			}
		}else{
			echo "tmp_name=$tmp_name --- dir=$dir ---- imagen=$imagen";
			die('Fallo subir la ficha.');
		}

		/*
		// Actualizamos el numnero de ficha a la coleccion
	    $sql = "UPDATE colecciones SET NumeroFichas=NumeroFichas+1 WHERE NombreColeccion='$nombreColeccion'";
		$modificar = mysqli_query($link, $sql);
		if(!$modificar){
			die("No modificado a la base de datos: ". mysql_error());
		}
		*/


		// Cerrar conexion con la bbdd
		mysqli_close($link);
		//echo "<h1> <a href='../html/index.html'> Usuario registrado correctamente.  </a> </h1>";
		header("Location: fichaRegistrada.php");

	}else{
		// Cerrar conexion con la bbdd
		mysqli_close($link);
		header("Location: fichaNoRegistrada.php");
	}



?>







