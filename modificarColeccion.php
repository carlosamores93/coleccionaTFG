<?php


	include_once("conectar.php");

	$link = conectarBBDD();
	// Añadir esta linea de codigo para poner acentos y ñ
	mysqli_query($link, "SET NAMES 'utf8'");


	if (!isset($_SESSION)){
		session_start();
	}
	$usuario = $_SESSION['usuario'];

	$nombre = $_SESSION['coleccion'];


	// Vamos a obtener los valores del formulario
	$nombreCorrecto = $_POST['billing_nombre_coleccion'];
	$tema = $_POST['billing_tema_coleccion'];
	$clave = $_POST['billing_clave'];
	$vidas = $_POST['billing_vidas'];
	$monedas = $_POST['billing_precio_vida'];
	$fichasFaciles = $_POST['billing_fichas_faciles'];
	$fichasMedio = $_POST['billing_fichas_medio'];
	$fichasDificiles = $_POST['billing_fichas_dificiles'];
	$publicar = $_POST['billing_publicar'];
	$respuesta = $_POST['billing_respuesta'];



	// Subimos el archvio pdf final de la coleccion
	$tipo_archivo = $_FILES['billing_imagen_pdf']['type'];
	if(strpos($tipo_archivo, "pdf") ){

		// Ante de el nuevo PDF , borramos en anterios
		$query="SELECT PdfColeccion FROM colecciones WHERE NombreColeccion = '$nombre'";            
	    if ($result = mysqli_query($link, $query)) {
	        // fetch associative array 
	        while ($row = mysqli_fetch_assoc($result)) {
	            $pdfBorrar = $row["PdfColeccion"];
	        }
	        // free result set 
	        mysqli_free_result($result);
	    }
	    // Borrar si no es la foto por defecto
	    $pdfPorDefecto="";
		// Borra la foto antiogua.
		if($pdfBorrar != $pdfPorDefecto){
			// Borra la foto antiogua.
			if(!unlink("$pdfBorrar")){
				die("No borrado la pdf de la coleccion");
			}
		}


		$dir_pdf = "img/profesores/$usuario/$nombre";
		$tmp_name_pdf = $_FILES["billing_imagen_pdf"]["tmp_name"];
		$pdf = basename($_FILES["billing_imagen_pdf"]["name"]);
		if(!move_uploaded_file($tmp_name_pdf, "$dir_pdf/$pdf")){
			die('Fallo subir el pdf a la coleccion.');
		}
		$hayPDF="SI";

	}else{
		$hayPDF="NO";
	}

	$imagen2subir = basename($_FILES["billing_imagen"]["name"]);
	if($imagen2subir == NULL){ // Si no ha elegido foto, le dejamos la foto de antes

		if($hayPDF == "SI"){
			$sql = "UPDATE colecciones SET NombreColeccionCorrecto='$nombreCorrecto', 
			TemaColeccion='$tema', Clave='$clave',
			Vida='$vidas', PrecioVida='$monedas',
			FichasFaciles='$fichasFaciles', FichasMedio='$fichasMedio', FichasDificiles='$fichasDificiles',
			Publicar='$publicar', MostrarRespuesta='$respuesta',
			PdfColeccion='$dir_pdf/$pdf'
			WHERE NombreColeccion='$nombre'";
			$modificar = mysqli_query($link, $sql);
			if(!$modificar){
				die("No modificado a la base de datos: ". mysql_error());
			}
		}else{
			$sql = "UPDATE colecciones SET NombreColeccionCorrecto='$nombreCorrecto', 
			TemaColeccion='$tema', Clave='$clave',
			Vida='$vidas', PrecioVida='$monedas',
			FichasFaciles='$fichasFaciles', FichasMedio='$fichasMedio', FichasDificiles='$fichasDificiles',
			Publicar='$publicar', MostrarRespuesta='$respuesta'
			WHERE NombreColeccion='$nombre'";
			$modificar = mysqli_query($link, $sql);
			if(!$modificar){
				die("No modificado a la base de datos: ". mysql_error());
			}
		}

	}else{ 


		// Ante de meter la nueva foto, borramos la anterior foto.
		$query="SELECT FotoColeccion FROM colecciones WHERE NombreColeccion = '$nombre'";            
	    if ($result = mysqli_query($link, $query)) {
	        // fetch associative array 
	        while ($row = mysqli_fetch_assoc($result)) {
	            $foto = $row["FotoColeccion"];
	        }
	        // free result set 
	        mysqli_free_result($result);
	    }

	    // Borrar si no es la foto por defecto
	    $fotoPorDefecto="img/coleccionIcono.png";
		// Borra la foto antiogua.
		if($foto != $fotoPorDefecto){
			// Borra la foto antiogua.
			if(!unlink("$foto")){
				die("No borrado la foto de la coleccion");
			}
		}

		// Metemos la foto que el ha elegido
		$uploads_dir = "img/profesores/$usuario/$nombre";
		$tmp_name = $_FILES["billing_imagen"]["tmp_name"];
		//echo "<p> tmp = $tmp_name </p>";
		$imagen = basename($_FILES["billing_imagen"]["name"]);
		//echo "<p> imagen = $imagen </p>";
		if(!move_uploaded_file($tmp_name, "$uploads_dir/$imagen")){
			die('Fallo al modificar la imagen de la coleccion.');
		}



		if($hayPDF == "NO"){
			// Modificamos en la tabla de colecciones
			$sql = "UPDATE colecciones SET NombreColeccionCorrecto='$nombreCorrecto', 
			TemaColeccion='$tema', Clave='$clave',
			Vida='$vidas', PrecioVida='$monedas',
			FichasFaciles='$fichasFaciles', FichasMedio='$fichasMedio', FichasDificiles='$fichasDificiles',
			Publicar='$publicar', FotoColeccion='$uploads_dir/$imagen',
			MostrarRespuesta='$respuesta'
			WHERE NombreColeccion='$nombre'";
			$modificar = mysqli_query($link, $sql);
			if(!$modificar){
				die("No modificado a la base de datos: ". mysql_error());
			}
		}else{
			// Modificamos en la tabla de colecciones
			$sql = "UPDATE colecciones SET NombreColeccionCorrecto='$nombreCorrecto', 
			TemaColeccion='$tema', Clave='$clave',
			Vida='$vidas', PrecioVida='$monedas',
			FichasFaciles='$fichasFaciles', FichasMedio='$fichasMedio', FichasDificiles='$fichasDificiles',
			Publicar='$publicar', FotoColeccion='$uploads_dir/$imagen',
			MostrarRespuesta='$respuesta', PdfColeccion='$dir_pdf/$pdf'
			WHERE NombreColeccion='$nombre'";
			$modificar = mysqli_query($link, $sql);
			if(!$modificar){
				die("No modificado a la base de datos: ". mysql_error());
			}
		}
		
	}


	// Si no ha elegido pdf y quiere borrar el actual, lo borramos
	$borrarPdfActual= $_POST['borrar_pdf'];
	if($hayPDF == "NO" && $borrarPdfActual == "SI"){
		// Vamos a borrar el actual pdf
		//echo "Borrar el actrual pdf";
		$query="SELECT PdfColeccion FROM colecciones WHERE NombreColeccion = '$nombre'";            
	    if ($result = mysqli_query($link, $query)) {
	        // fetch associative array 
	        while ($row = mysqli_fetch_assoc($result)) {
	            $pdfBorrar = $row["PdfColeccion"];
	        }
	        // free result set 
	        mysqli_free_result($result);
	    }
	    // Borrar si no es la foto por defecto
	    $pdfPorDefecto="";
		// Borra la foto antiogua.
		if($pdfBorrar != $pdfPorDefecto){
			// Borra la foto antiogua.
			if(!unlink("$pdfBorrar")){
				die("No borrado la pdf de la coleccion");
			}
		}
		$sql = "UPDATE colecciones SET PdfColeccion=''
		WHERE NombreColeccion='$nombre'";
		$modificar = mysqli_query($link, $sql);
		if(!$modificar){
			die("No modificado a la base de datos deoues de borrar el pdf de la coleccion. ". mysql_error());
		}
	}




	// Cerrar conexion con la bbdd
	mysqli_close($link);
	header("Location: detallesColeccion.php");
	

?>







