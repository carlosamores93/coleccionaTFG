<?php
	

	include_once("conectar.php");

	$link = conectarBBDD();

	// Añadir esta linea de codigo para poner acentos y ñ
	mysqli_query($link, "SET NAMES 'utf8'");

	

	// Vamos a obtener los valores del formulario
	$nombreColeccion = $_POST['billing_nombre_coleccion'];
	$nombreColeccionCorrecto = $_POST['billing_nombre2_coleccion'];
	$temaColeccion = $_POST['billing_tema_coleccion'];
	$claveColeccion = $_POST['billing_clave'];
	$numVidas = $_POST['billing_vidas'];
	$precioVida = $_POST['billing_precio_vida'];
	$fichasFaciles = $_POST['billing_fichas_faciles'];
	$fichasMedio = $_POST['billing_fichas_medio'];
	$fichasDificiles = $_POST['billing_fichas_dificiles'];
	$respuesta = $_POST['billing_respuesta'];



	$sql = "SELECT * FROM colecciones WHERE NombreColeccion='$nombreColeccion'";
	$resultado = mysqli_query($link, $sql);
	$num_rows = mysqli_num_rows($resultado);

	
	if( $num_rows == 0){
		//echo "<p> Coleccion no registrada, podemos regitrar una nueva </p>";

		// Creamos la carpeta que va a contener las fichas y la foto de la coleccion.
		if (!isset($_SESSION)){
			session_start();
		}
		$usuario = $_SESSION["usuario"];
		//echo "$user";
		
		// Creamos la carperta de la coleccion
		if(!mkdir("img/profesores/$usuario/$nombreColeccion", 0755)) {
		    die('Fallo al crear la carpeta de la coleccion.');
		}
		// Creamos la carperta para conterner las fichas de las colecciones.
		if(!mkdir("img/profesores/$usuario/$nombreColeccion/fichas", 0755)) {
		    die('Fallo al crear la carpeta de la coleccion.');
		}


		$imagen2subir = basename($_FILES["billing_imagen"]["name"]);

		if($imagen2subir == NULL){
			$dir = 'img';
			$imagen = "coleccionIcono.png";
		}else{
			$dir = "img/profesores/$usuario/$nombreColeccion";
			$tmp_name = $_FILES["billing_imagen"]["tmp_name"];
			//echo "<p> tmp = $tmp_name </p>";
			$imagen = basename($_FILES["billing_imagen"]["name"]);
			//echo "<p> imagen = $imagen </p>";
			if(!move_uploaded_file($tmp_name, "$dir/$imagen")){
				die('Fallo subir la imagen de la coleccion.');
			}
		}


		// Subimos el archvio pdf final de la coleccion
		$tipo_archivo = $_FILES['billing_imagen_pdf']['type'];
		if(strpos($tipo_archivo, "pdf") ){
			$dir_pdf = "img/profesores/$usuario/$nombreColeccion";
			$tmp_name_pdf = $_FILES["billing_imagen_pdf"]["tmp_name"];
			//echo "<p> tmp = $tmp_name </p>";
			$pdf = basename($_FILES["billing_imagen_pdf"]["name"]);
			if(!move_uploaded_file($tmp_name_pdf, "$dir_pdf/$pdf")){
				die('Fallo subir el pdf a la coleccion.');
			}		
			$urlPdf="$dir_pdf/$pdf";	
		}else{
			$urlPdf="";
		}


		$no = "no";
		// Insertamos los datos en la tabla colecciones
		$insertar = "INSERT INTO colecciones 
		( NombreColeccion, UsuarioProfesor, NombreColeccionCorrecto, 
			TemaColeccion, Clave, FotoColeccion, PdfColeccion, Vida, 
			PrecioVida, FichasFaciles, FichasMedio, FichasDificiles,
			NumeroFichas, NumeroPreguntas, AlumnosJugando, AlumnosFin, Publicar, MostrarRespuesta) 
		VALUES ('$nombreColeccion', '$usuario', '$nombreColeccionCorrecto' ,
			'$temaColeccion', '$claveColeccion', '$dir/$imagen', '$urlPdf', '$numVidas', 
			'$precioVida', '$fichasFaciles', '$fichasMedio', '$fichasDificiles',
			'0', '0', '0', '0', 'NO', '$respuesta')";
		$meter = mysqli_query($link, $insertar);
		if(!$meter){
			die("No insertado a la base de datos: ". mysql_error());
		}else{

			// Cerrar conexion con la bbdd
			mysqli_close($link);
			//echo "<h1> <a href='../html/index.html'> Usuario registrado correctamente.  </a> </h1>";
			header('Location: coleccionRegistrada.php');
		}

	}else{
		
		// Cerrar conexion con la bbdd
		mysqli_close($link);
		//echo "<h1> <a href='../html/index.html'> Usuario registrado correctamente.  </a> </h1>";
		header('Location: coleccionNoRegistrada.php');
	}



?>







