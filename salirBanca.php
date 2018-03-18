<?php
	

	include_once("conectar.php");
	$link = conectarBBDD();
	// Añadir esta linea de codigo para poner acentos y ñ
	mysqli_query($link, "SET NAMES 'utf8'");

	if (!isset($_SESSION)){
		session_start();
	}
    $_SESSION["page"] = "inicioAlumno.php";

	$usuario = $_SESSION["usuario"];
	$coleccion = $_SESSION["coleccionEmpezada"];
	$monedasGastar = $_SESSION["monedasGastar"];

    // Restar una vida a la tabla juega colecciones
    $sql = "UPDATE juega_colecciones SET Monedas=Monedas-'$monedasGastar'
    WHERE NombreColeccion='$coleccion' AND UsuarioAlumno= '$usuario'";
    $modificar = mysqli_query($link, $sql);
    if(!$modificar){
        die("No modificado a la base de datos al restar monedas : ". mysql_error());
    }

    // Restar una vida a la tabla juega colecciones
    $sql = "UPDATE juega_colecciones SET Monedas=Monedas-'$monedasGastar'
    WHERE NombreColeccion='$coleccion' AND UsuarioAlumno= '$usuario'";
    $modificar = mysqli_query($link, $sql);
    if(!$modificar){
        die("No modificado a la base de datos al restar una vida y monedas : ". mysql_error());
    }

    if(isset($_GET['idPregunta'])){
        $idPregunta = $_GET['idPregunta'];
        // Hemos fallado la preguntas, por lo tanto actualizamos la tabla actidad_alumnos
        $sql = "SELECT * FROM actividad_alumnos WHERE UsuarioAlumno='$usuario' AND IdPregunta='$idPregunta'";
        $resultado = mysqli_query($link, $sql);
        $num_rows = mysqli_num_rows($resultado);
        if( $num_rows == 0){
            // No hay resultados, tenemos que meter en la base de datos
            // Se te acabó el tiempo
            $insertar = "INSERT INTO actividad_alumnos
            (UsuarioAlumno, NombreColeccion, IdPregunta, TimeOut) 
            VALUES ('$usuario','$coleccion', '$idPregunta', '1')";
            $meter = mysqli_query($link, $insertar);
            if(!$meter){
                die("No insertado a la base de datosa la tabla actividad_alumnos: ". mysql_error());
            }
        }else{
            // Tenemos que actualizar la bb de datos
            // Se te acabó el tiempo
            $sql = "UPDATE actividad_alumnos SET TimeOut=TimeOut+1 
            WHERE NombreColeccion='$coleccion' AND UsuarioAlumno= '$usuario' AND IdPregunta='$idPregunta'";
            $modificar = mysqli_query($link, $sql);
            if(!$modificar){
                die("No modificado a la base de datos actividad_alumnos timeout : ". mysql_error());
            }
        }
        
    }


    mysqli_close($link);
    header("Location: coleccionJugar.php");


?>







