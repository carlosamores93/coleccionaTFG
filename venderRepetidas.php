<?php
	
	$ficha = $_GET['idFicha'];
		
	include_once("conectar.php");
	$link = conectarBBDD();
	// Añadir esta linea de codigo para poner acentos y ñ
	mysqli_query($link, "SET NAMES 'utf8'");
	
	if (!isset($_SESSION)){
		session_start();
	$_SESSION["fichaConseguida"] = $ficha;
	}
	
	$ficha = $_SESSION["fichaConseguida"];
	$usuario = $_SESSION["usuario"];
	$coleccion = $_SESSION["coleccionEmpezada"];

	$query="SELECT DificultadFicha
    FROM fichas WHERE IdFicha = '$ficha' ";
    if ($result = mysqli_query($link, $query)) {
        // fetch associative array 
        while ($row = mysqli_fetch_assoc($result)) {
            $dificultad = $row["DificultadFicha"];
	
        }
        // free result set 
        mysqli_free_result($result);
    }else{
        echo "NADAAAAAAA";
    }

	$query="SELECT FichasFaciles, FichasMedio, FichasDificiles
    FROM colecciones WHERE NombreColeccion = '$coleccion'";
    if ($result = mysqli_query($link, $query)) {
        // fetch associative array 
        while ($row = mysqli_fetch_assoc($result)) {
            $precioFaciles = $row["FichasFaciles"];
			$precioMedio = $row["FichasMedio"];
			$precioDificiles = $row["FichasDificiles"];

        }
        // free result set 
        mysqli_free_result($result);
    }else{
        echo "NADAAAAAAA";
    }
	
	// Hago el calculo de lo que tengo que restar por ficha repetida
    $añadirPrecioFaciles= $precioFaciles / 2;
	$añadirPrecioMedio= $precioMedio / 2;
	$añadirPrecioDificiles= $precioDificiles / 2;
	
	echo $añadirPrecioFaciles;
	echo $añadirPrecioMedio;
	echo $añadirPrecioDificiles;
	
	$query="SELECT NumeroFichas
    FROM mis_fichas WHERE IdFicha = '$ficha'  AND UsuarioAlumno= '$usuario' ";
    if ($result = mysqli_query($link, $query)) {
        // fetch associative array 
        while ($row = mysqli_fetch_assoc($result)) {
            $numFichas = $row["NumeroFichas"];
        }
        // free result set 
        mysqli_free_result($result);
    }else{
        echo "NADAAAAAAA";
    }
		
	// Actualizo el número de fichas
    $numFichasActual=$numFichas - 1;
	
	
	if($dificultad == "Fácil"){
		
		echo "facil";
	
	
	$sql = "UPDATE mis_fichas SET NumeroFichas=$numFichasActual
    WHERE UsuarioAlumno= '$usuario' AND IdFicha='$ficha'";
	$modificar = mysqli_query($link, $sql);
		if(!$modificar){
			die("No modificado a la base de datos : ". mysql_error());
		}
			
    $sql = "UPDATE juega_colecciones SET Monedas=Monedas+'$añadirPrecioFaciles' 
    WHERE NombreColeccion='$coleccion' AND UsuarioAlumno= '$usuario'";
	$modificar = mysqli_query($link, $sql);
		if(!$modificar){
			die("No modificado a la base de datos : ". mysql_error());
		}
	}
	
	
	if($dificultad == "Medio"){
		
			
		echo "medio";
	
	$sql = "UPDATE mis_fichas SET NumeroFichas=$numFichasActual
    WHERE UsuarioAlumno= '$usuario' AND IdFicha='$ficha'";
	$modificar = mysqli_query($link, $sql);
		if(!$modificar){
			die("No modificado a la base de datos : ". mysql_error());
		}
			
    $sql = "UPDATE juega_colecciones SET Monedas=Monedas+'$añadirPrecioMedio' 
    WHERE NombreColeccion='$coleccion' AND UsuarioAlumno= '$usuario'";
	$modificar = mysqli_query($link, $sql);
		if(!$modificar){
			die("No modificado a la base de datos : ". mysql_error());
		}
	}
	
	
	if($dificultad == "Difícil"){	
	
		
		echo "dificil";
	
	$sql = "UPDATE mis_fichas SET NumeroFichas=$numFichasActual
    WHERE UsuarioAlumno= '$usuario' AND IdFicha='$ficha'";
	$modificar = mysqli_query($link, $sql);
		if(!$modificar){
			die("No modificado a la base de datos : ". mysql_error());
		}
			
    $sql = "UPDATE juega_colecciones SET Monedas=Monedas+'$añadirPrecioDificiles' 
    WHERE NombreColeccion='$coleccion' AND UsuarioAlumno= '$usuario'";
	$modificar = mysqli_query($link, $sql);
		if(!$modificar){
			die("No modificado a la base de datos : ". mysql_error());
		}
	}

	mysqli_close($link);
	header("Location: coleccionJugar.php");

?>







