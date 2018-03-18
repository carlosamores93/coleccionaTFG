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
    $xml .= '<ListaFichas>';
    $xml .= "\n\t";


	$query="SELECT DificultadFicha, Descripcion, FotoFicha, NumeroFicha
    FROM fichas WHERE NombreColeccion = '$coleccion' 
    ORDER BY NumeroFicha";
    if ($result = mysqli_query($link, $query)) {
        // fetch associative array 
        while ($row = mysqli_fetch_assoc($result)) {
            $dificultad = $row["DificultadFicha"];
            $descripcion = $row["Descripcion"];
            $urlFotoFicha = $row["FotoFicha"];
            $fotoFicha = basename($urlFotoFicha);
            $numeroFicha = $row["NumeroFicha"];
            $xml .= '<Ficha>';
            $xml .= "\n\t\t";
            $xml .= '<DificultadFicha>'."$dificultad".'</DificultadFicha>';
            $xml .= "\n\t\t";
            $xml .= '<Descripcion>'."$descripcion".'</Descripcion>';
            $xml .= "\n\t\t";
            $xml .= '<FotoFicha>'."$fotoFicha".'</FotoFicha>';
            $xml .= "\n\t\t";
            $xml .= '<NumeroFicha>'."$numeroFicha".'</NumeroFicha>';
            $xml .= "\n\t";
			$xml .= '</Ficha>';
			$xml .= "\n\t";

        }

        // free result set 
        mysqli_free_result($result);
    }else{
        echo "NADA";
    }
    $xml .= "\n";
    $xml .= '</ListaFichas>';

    $nombre = "$nombreCorrecto.xml";
    $archivo = fopen($nombre, "w");
    fwrite($archivo, $xml);
    fclose($archivo);


    header('Content-type: application/xml');
    // Se llamará downloaded.pdf
    header("Content-Disposition: attachment; filename=$nombreCorrecto Fichas.xml");
    // La fuente de PDF se encuentra en original.pdf
    readfile("$nombreCorrecto.xml");


    // Borramosel documento xml creado.
    if(!unlink("$nombreCorrecto.xml")){
        echo "No borrado xml de preguntas";
    }

	// Cerrar conexion con la bbdd
	mysqli_close($link);


?>







