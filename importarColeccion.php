<?php


	include_once("conectar.php");
	$link = conectarBBDD();
	mysqli_query($link, "SET NAMES 'utf8'");

	if (!isset($_SESSION)){
		session_start();
	}
	$nombreColeccion = $_SESSION['coleccion'];
	$usuario = $_SESSION['usuario'];
	//echo "$nombreColeccion";

	$query="SELECT NombreColeccionCorrecto
    FROM colecciones WHERE NombreColeccion = '$nombreColeccion' ";
    if ($result = mysqli_query($link, $query)) {
        // fetch associative array 
        while ($row = mysqli_fetch_assoc($result)) {
            $nombreCorrecto = $row["NombreColeccionCorrecto"];
        }
        mysqli_free_result($result);
    }else{
        echo "$nombreColeccion";
    }



    $contador = 0;
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////               PREGUNTAS          //////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$tipo_archivo = $_FILES['billing_preg_xml']['type'];
	//echo "$tipo_archivo";
	if(strpos($tipo_archivo, "xml") ){
		//echo "Hay preguntas";

		// Creamos la carperta para el xml
		if(!mkdir("img/profesores/$usuario/$nombreColeccion/xml", 0755)) {
			include_once("eliminarDirectorio.php");
			eliminarDir("img/profesores/$usuario/$nombreColeccion/xml");
		    //die('Fallo al crear la carpeta de la coleccion para el xml.');

		}
		$dir_xml = "img/profesores/$usuario/$nombreColeccion/xml";
		$tmp_name_xml = $_FILES["billing_preg_xml"]["tmp_name"];
		$xml = basename($_FILES["billing_preg_xml"]["name"]);
		if(!move_uploaded_file($tmp_name_xml, "$dir_xml/$xml")){
			die('Fallo subir el xml a la coleccion.');
		}
		//echo "Nombre xml=$xml";

		// Leer el archivo xml y subir a la base de datos
		$preguntas = simplexml_load_file("$dir_xml/$xml") or die("Error: Cannot create object");

		foreach($preguntas->children() as $questions) { 

		    $dificultad = $questions->DificultadPregunta;
		    $tiempo = $questions->Tiempo;
		    $monedas = $questions->Monedas;
		    $enunciado = $questions->Enunciado;
		    $respuestaCorrecta = $questions->RespuestaCorrecta;
		    $respuesta1Incorrecta = $questions->RespuestaIncorrecta1;
		    $respuesta2Incorrecta = $questions->RespuestaIncorrecta2;
		    $respuesta3Incorrecta = $questions->RespuestaIncorrecta3;
		    if($dificultad != ""){
		    	$insertar = "INSERT INTO preguntas (
				NombreColeccion, DificultadPregunta,
				Tiempo, Monedas, Enunciado, RespuestaCorrecta, RespuestaIncorrecta1,
				RespuestaIncorrecta2, RespuestaIncorrecta3, 
				Frecuencia, Fallos, Aciertos ) 
				VALUES ('$nombreColeccion','$dificultad',
				'$tiempo', '$monedas','$enunciado','$respuestaCorrecta', '$respuesta1Incorrecta',
				'$respuesta2Incorrecta', '$respuesta3Incorrecta', 
				'0','0', '0')";
				$meter = mysqli_query($link, $insertar);
				if(!$meter){
					die("No insertado a la base de datos de la tabla preguntas: ". mysql_error());
				}else{
					$contador++;
				}

		    }
		    
		}


		// Eliminar directorio del xml, solo lo usamos para importar preguntas
		include_once("eliminarDirectorio.php");
		eliminarDir("img/profesores/$usuario/$nombreColeccion/xml");

	}

	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////               FICHAS          //////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$tipo_archivo = $_FILES['billing_fichas_xml']['type'];
	//echo "$tipo_archivo";
	if(strpos($tipo_archivo, "xml") ){
		//echo "Hay fichas";

		// Creamos la carperta para el xml
		if(!mkdir("img/profesores/$usuario/$nombreColeccion/xml", 0755)) {
			include_once("eliminarDirectorio.php");
			eliminarDir("img/profesores/$usuario/$nombreColeccion/xml");
		    //die('Fallo al crear la carpeta de la coleccion para el xml.');

		}
		$dir_xml = "img/profesores/$usuario/$nombreColeccion/xml";
		$tmp_name_xml = $_FILES["billing_fichas_xml"]["tmp_name"];
		$xml = basename($_FILES["billing_fichas_xml"]["name"]);
		if(!move_uploaded_file($tmp_name_xml, "$dir_xml/$xml")){
			die('Fallo subir el xml a la coleccion.');
		}
		//echo "Nombre xml=$xml";

		// Leer el archivo xml y subir a la base de datos
		$fichas = simplexml_load_file("$dir_xml/$xml") or die("Error: Cannot create object");

		foreach($fichas->children() as $ficha) { 

		    $dificultad = $ficha->DificultadFicha;
		    $descripcion = $ficha->Descripcion;
		    $foto = $ficha->FotoFicha;
		    // Poner la url de la foto bien
		    $urlFoto = "img/profesores/$usuario/$nombreColeccion/fichas/$foto";
		    $numeroFicha = $ficha->NumeroFicha;
		    if($dificultad != ""){
		    	$insertar = "INSERT INTO fichas (
				NombreColeccion, DificultadFicha,
				Descripcion, FotoFicha, NumeroFicha) 
				VALUES ('$nombreColeccion','$dificultad',
				'$descripcion', '$urlFoto', '$numeroFicha')";
				$meter = mysqli_query($link, $insertar);
				if(!$meter){
					die("No insertado a la base de datos de la tabla fichas: ". mysql_error());
				}else{
					$contador++;
				}

		    }
		    
		}

		// Eliminar directorio del xml, solo lo usamos para importar preguntas
		include_once("eliminarDirectorio.php");
		eliminarDir("img/profesores/$usuario/$nombreColeccion/xml");

	}

	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////               FOTOS          //////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	$tipo_archivo = $_FILES['billing_fotos_zip']['type'];
	//echo "$tipo_archivo";
	//die();
	//octet-stream  // x-zip-compressed
	if((strcmp($tipo_archivo, "application/octet-stream") == 0) || (strcmp($tipo_archivo, "application/x-zip-compressed") == 0)){
		$dir_zip = "img/profesores/$usuario/$nombreColeccion";
		$tmp_name_zip = $_FILES["billing_fotos_zip"]["tmp_name"];
		$zip = basename($_FILES["billing_fotos_zip"]["name"]);
		if(!move_uploaded_file($tmp_name_zip, "$dir_zip/$zip")){
			die('Fallo subir el zip para la coleccion.');
		}
		$dir_zip = "img/profesores/$usuario/$nombreColeccion";
		$urlZip = $dir_zip.'/'.$zip;
		$dir_fichas = "img/profesores/$usuario/$nombreColeccion/fichas";

		echo "URL = $urlZip";
		$archivoZip = new ZipArchive;
		$res = $archivoZip->open($urlZip);
		if ($res === TRUE) {
			echo 'ok';
			$archivoZip->extractTo($dir_fichas);
    		$archivoZip->close();
    		$contador++;
		} else {
			echo 'falló al cargar el zip, código:' . $res;
		}
		// Eliminar el zip
		if(!unlink($urlZip)){
			echo "Zip no borrado";
		}

	}else{
		echo "_NOOOOOOOOO hay zip";
	}

	mysqli_close($link);


	if($contador > 0){
		echo "$contador";
		header("Location: exitoImportar.php");
	}else{
		header("Location: falloImportar.php");
	}

	

?>







