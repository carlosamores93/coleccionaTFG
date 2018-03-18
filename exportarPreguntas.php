<?php
	

	include_once("conectar.php");
	$link = conectarBBDD();
	mysqli_query($link, "SET NAMES 'utf8'");

    if (!isset($_SESSION)){
        session_start();
    }
	$coleccion = $_SESSION["coleccion"];

	$query="SELECT NombreColeccionCorrecto
    FROM colecciones WHERE NombreColeccion = '$coleccion' ";
    if ($result = mysqli_query($link, $query)) {
        // fetch associative array 
        while ($row = mysqli_fetch_assoc($result)) {
            $nombreCorrecto = $row["NombreColeccionCorrecto"];
        }
        mysqli_free_result($result);
    }else{
        echo "$coleccion";
    }


    //header("Content-type: text/xml");


	$xml = '<?xml version="1.0" encoding="utf-8"?>';
    $xml .= "\n";
    $xml .= '<ListaPreguntas>';
    


	$query="SELECT DificultadPregunta, Tiempo, 
    Monedas, Enunciado, RespuestaCorrecta, RespuestaIncorrecta1, RespuestaIncorrecta2,
    RespuestaIncorrecta3
    FROM preguntas WHERE NombreColeccion = '$coleccion' ";
    if ($result = mysqli_query($link, $query)) {
        // fetch associative array 
        while ($row = mysqli_fetch_assoc($result)) {
            $xml .= "\n\t";
            $dificultad = $row["DificultadPregunta"];
            $tiempo = $row["Tiempo"];
            $monedas = $row["Monedas"];
            $enunciado = $row["Enunciado"];
            $correcta = $row["RespuestaCorrecta"];
            $incorrecta1 = $row["RespuestaIncorrecta1"];
            $incorrecta2 = $row["RespuestaIncorrecta2"];
            $incorrecta3 = $row["RespuestaIncorrecta3"];
            $xml .= '<Pregunta>';
            $xml .= "\n\t\t";
            $xml .= '<DificultadPregunta>'."$dificultad".'</DificultadPregunta>';
            $xml .= "\n\t\t";
            $xml .= '<Tiempo>'."$tiempo".'</Tiempo>';
            $xml .= "\n\t\t";
            $xml .= '<Monedas>'."$monedas".'</Monedas>';
            $xml .= "\n\t\t";
            $xml .= '<Enunciado>'."$enunciado".'</Enunciado>';
            $xml .= "\n\t\t";
            $xml .= '<RespuestaCorrecta>'."$correcta".'</RespuestaCorrecta>';
            $xml .= "\n\t\t";
            $xml .= '<RespuestaIncorrecta1>'."$incorrecta1".'</RespuestaIncorrecta1>';
            $xml .= "\n\t\t";
            $xml .= '<RespuestaIncorrecta2>'."$incorrecta2".'</RespuestaIncorrecta2>';
            $xml .= "\n\t\t";
            $xml .= '<RespuestaIncorrecta3>'."$incorrecta3".'</RespuestaIncorrecta3>';
            $xml .= "\n\t";
			$xml .= '</Pregunta>';

        }

        // free result set 
        mysqli_free_result($result);
    }else{
        echo "NADA";
    }

    $xml .= "\n";
    $xml .= '</ListaPreguntas>';


    $nombre = "$nombreCorrecto.xml";
    $archivo = fopen($nombre, "w");
    fwrite($archivo, $xml);
    fclose($archivo);


    header('Content-type: application/xml');
    // Se llamará downloaded.pdf
    header("Content-Disposition: attachment; filename=$nombreCorrecto Preguntas.xml");
    // La fuente de PDF se encuentra en original.pdf
    readfile("$nombreCorrecto.xml");

    // Borramosel documento xml creado.
    if(!unlink("$nombreCorrecto.xml")){
        echo "No borrado xml de preguntas";
    }

	// Cerrar conexion con la bbdd
	mysqli_close($link);


?>







