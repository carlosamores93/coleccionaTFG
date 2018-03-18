<?php

	include_once("conectar.php");
	$link = conectarBBDD();
	mysqli_query($link, "SET NAMES 'utf8'");

    if (!isset($_SESSION)){
        session_start();
    }
	$coleccion = $_SESSION["coleccion"];
    $usuario = $_SESSION["usuario"];

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

    //$urlFichas = "img/profesores/$usuario/$coleccion/fichas";
    //echo "URL fichas: $urlFichas";
    if (file_exists("$nombreCorrecto.zip")) {
        if(!unlink("$nombreCorrecto.zip")){
            echo "No borrado fichero.";
        }else{
            echo "El zip se ha borrado.";
        }
    } else {
        echo "El fichero no existe creamos uno nuevo.";
    }

    $zipname = "$nombreCorrecto.zip";
    $zip = new ZipArchive;
    if ($zip->open($zipname, ZipArchive::CREATE) === TRUE) {  
        $query="SELECT FotoFicha
        FROM fichas WHERE NombreColeccion = '$coleccion' ";
        if ($result = mysqli_query($link, $query)) {
            // fetch associative array 
            while ($row = mysqli_fetch_assoc($result)) {
                $urlFotoFicha = $row["FotoFicha"];
                $fotoFicha = basename($urlFotoFicha);
                if($zip->addFile($urlFotoFicha, $fotoFicha)){
                    //echo "Fichero añadido\n";
                }else{
                    echo "Fallo, fichero no añadido\n";
                    //die();
                }
            }
            mysqli_free_result($result);
        }else{
            echo "NADA";
        }

    } else {
        echo 'falló al crear el zip';
        die();
    }
    $zip->close();
    // Cerrar conexion con la bbdd
    mysqli_close($link);


    if(file_exists($zipname)){ 

        header('Content-Type: application/x-zip-compressed'); 
        header("Content-Disposition: attachment; filename=.$zipname"); 
        header("Content-Transfer-Encoding: binary");
        readfile($zipname); 

        unlink($zipname); 
    }

?>







