<?php
	

	include_once("conectar.php");
	$link = conectarBBDD();
	// Añadir esta linea de codigo para poner acentos y ñ
	mysqli_query($link, "SET NAMES 'utf8'");

	if (!isset($_SESSION)){
		session_start();
	}
    $_SESSION["page"] = "xxx.php";

	$usuario = $_SESSION["usuario"];
	$coleccion = $_SESSION["coleccionEmpezada"];

    // Restar una vida a la tabla juega colecciones
    $sql = "UPDATE juega_colecciones SET Vidas=Vidas-1 
    WHERE NombreColeccion='$coleccion' AND UsuarioAlumno= '$usuario'";
    $modificar = mysqli_query($link, $sql);
    if(!$modificar){
        die("No modificado a la base de datos al restar una vida : ". mysql_error());
    }


    mysqli_close($link);
    header("Location: coleccionJugar.php");


?>







