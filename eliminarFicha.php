<?php

	include_once("conectar.php");

	$link = conectarBBDD();
	// Añadir esta linea de codigo para poner acentos y ñ
	mysqli_query($link, "SET NAMES 'utf8'");



	if (!isset($_SESSION)){
		session_start();
	}
	$usuario = $_SESSION['usuario'];


	$nombreColeccion = $_GET['nombreColeccion'];
	$idFicha = $_GET['idFicha'];


    $query="SELECT FotoFicha FROM fichas
    WHERE IdFicha = '$idFicha'";            
    if ($result = mysqli_query($link, $query)) {
        // fetch associative array 
        while ($row = mysqli_fetch_assoc($result)) {
            $foto = $row["FotoFicha"];
        }
        // free result set 
        mysqli_free_result($result);
    }

    //echo "Coleciojn=$nombreColeccion, idFicha=$idFicha, foto=$foto";


	// Borra la foto de la ficha
	if(!unlink("$foto")){
		die("No borrado la foto de la ficha");
	}


	// Borramos en la tabla de alumnos
	$sql = "DELETE FROM fichas WHERE  IdFicha='$idFicha'";
	$borrar = mysqli_query($link, $sql);
	if(!$borrar){
		die("No borrado de la base de datos: ". mysql_error());
	}

	/*
	// Actualizamos el numero de fichas de la coleccion.
    $sql = "UPDATE colecciones SET NumeroFichas=NumeroFichas-1 WHERE NombreColeccion='$nombreColeccion'";
	$modificar = mysqli_query($link, $sql);
	if(!$modificar){
		die("No modificado a la base de datos: ". mysql_error());
	}
	*/

	// Cerrar conexion con la bbdd
	mysqli_close($link);
	header("Location: listarFichas.php");
	
?>







