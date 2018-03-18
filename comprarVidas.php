<?php
	

	include_once("conectar.php");
	$link = conectarBBDD();
	// Añadir esta linea de codigo para poner acentos y ñ
	mysqli_query($link, "SET NAMES 'utf8'");

	if (!isset($_SESSION)){
		session_start();
	}

	$usuario = $_SESSION["usuario"];
	$coleccion = $_SESSION["coleccionEmpezada"];

	$query="SELECT PrecioVida
    FROM colecciones WHERE NombreColeccion = '$coleccion' ";
    if ($result = mysqli_query($link, $query)) {
        // fetch associative array 
        while ($row = mysqli_fetch_assoc($result)) {
            $precioDeUnaVida = $row["PrecioVida"];
        }
        // free result set 
        mysqli_free_result($result);
    }else{
        echo "NADAAAAAAA";
    }

    //echo "Precio de una vida = $precioDeUnaVida\n";

    $query="SELECT Monedas
    FROM juega_colecciones WHERE NombreColeccion = '$coleccion' AND UsuarioAlumno = '$usuario' ";
    if ($result = mysqli_query($link, $query)) {
        // fetch associative array 
        while ($row = mysqli_fetch_assoc($result)) {
            $monedas = $row["Monedas"];
        }
        // free result set 
        mysqli_free_result($result);
    }else{
        echo "NADAAAAAAA";
    }

    //echo "Monedas =$monedas";

    // Hago la resta para tener una vida mas
    $monedasRestantes= $monedas - $precioDeUnaVida;

    //echo "nomevdas restantes = $monedasRestantes";

    $sql = "UPDATE juega_colecciones SET Vidas=Vidas+1, Monedas='$monedasRestantes' 
    WHERE NombreColeccion='$coleccion' AND UsuarioAlumno= '$usuario'";
	$modificar = mysqli_query($link, $sql);
	if(!$modificar){
		die("No modificado a la base de datos : ". mysql_error());
	}

	mysqli_close($link);
	header("Location: coleccionJugar.php");

?>







