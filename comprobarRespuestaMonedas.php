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
	

	$respuesta = $_POST['billing_respuesta'];
    $idPregunta = $_GET['idPregunta'];
	
	
	//echo "Usuario =$usuario -- coleccion = $coleccion -- Respuesta=$respuesta  -- idPre=$idPregunta -- idFicha=$idFicha";

	$query="SELECT Monedas
    FROM preguntas WHERE idPregunta = '$idPregunta' ";
    if ($result = mysqli_query($link, $query)) {
        // fetch associative array 
        while ($row = mysqli_fetch_assoc($result)) {
            $monedasAGanar = $row["Monedas"];
        }
        // free result set 
        mysqli_free_result($result);
    }else{
        echo "NADAAAAAAA";
    }
	
	if($respuesta == "correcto"){

		/////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////// ACTIVIDADA ALUMNOS //////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// Hemos fallado la preguntas, por lo tanto actualizamos la tabla actidad_alumnos
        $sql = "SELECT * FROM actividad_alumnos WHERE UsuarioAlumno='$usuario' AND IdPregunta='$idPregunta'";
		$resultado = mysqli_query($link, $sql);
		$num_rows = mysqli_num_rows($resultado);
		if( $num_rows == 0){
			// No hay resultados, tenemos que meter en la base de datos
			$insertar = "INSERT INTO actividad_alumnos
			(UsuarioAlumno, NombreColeccion, IdPregunta, Correcta) 
			VALUES ('$usuario','$coleccion', '$idPregunta', '1')";
			$meter = mysqli_query($link, $insertar);
			if(!$meter){
				die("No insertado a la base de datosa la tabla actividad_alumnos: ". mysql_error());
			}
		}else{
			// Tenemos que actualizar la bb de datos
			$sql = "UPDATE actividad_alumnos SET Correcta=Correcta+1 
			WHERE NombreColeccion='$coleccion' AND UsuarioAlumno= '$usuario' AND IdPregunta='$idPregunta'";
			$modificar = mysqli_query($link, $sql);
			if(!$modificar){
				die("No modificado a la base de datos actividad_alumnos corecta : ". mysql_error());
			}
		}
		///////////////////////////////////////////////////////////////////////////////////////////////////

		// Actualizamos los aciertos de la pregunta
		$sql = "UPDATE preguntas SET Frecuencia=Frecuencia+1, Aciertos=Aciertos+1 
        WHERE IdPregunta='$idPregunta'";
        $modificar = mysqli_query($link, $sql);
        if(!$modificar){
            die("No modificado a la base de dfatos al acertar la pregunta.: ". mysql_error());
        }


        // Actualizamos los aciertos del alumno
		$sql = "UPDATE alumnos SET PreguntasAcertadas=PreguntasAcertadas+1
        WHERE UsuarioAlumno='$usuario'";
        $modificar = mysqli_query($link, $sql);
        if(!$modificar){
            die("No modificado a la base de dfatos de alumnos al acertar la pregunta.: ". mysql_error());
        }


	    $sql = "UPDATE juega_colecciones SET Monedas=Monedas+'$monedasAGanar' 
	    WHERE NombreColeccion='$coleccion' AND UsuarioAlumno= '$usuario'";
		$modificar = mysqli_query($link, $sql);
		if(!$modificar){
			die("No modificado a la base de datos al RESTAR las monedas: ". mysql_error());
		}
	
	}else{

		/////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////// ACTIVIDADA ALUMNOS //////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // Hemos fallado la preguntas, por lo tanto actualizamos la tabla actidad_alumnos
        $sql = "SELECT * FROM actividad_alumnos WHERE UsuarioAlumno='$usuario' AND IdPregunta='$idPregunta'";
		$resultado = mysqli_query($link, $sql);
		$num_rows = mysqli_num_rows($resultado);
		if( $num_rows == 0){
			// No hay resultados, tenemos que meter en la base de datos
			if($respuesta == "incorrecto1"){
				$insertar = "INSERT INTO actividad_alumnos
				(UsuarioAlumno, NombreColeccion, IdPregunta, Incorrecta1) 
				VALUES ('$usuario','$coleccion', '$idPregunta', '1')";
				$meter = mysqli_query($link, $insertar);
				if(!$meter){
					die("No insertado a la base de datosa la tabla actividad_alumnos: ". mysql_error());
				}
			}else if($respuesta == "incorrecto2"){
				$insertar = "INSERT INTO actividad_alumnos
				(UsuarioAlumno, NombreColeccion, IdPregunta, Incorrecta2) 
				VALUES ('$usuario','$coleccion', '$idPregunta', '1')";
				$meter = mysqli_query($link, $insertar);
				if(!$meter){
					die("No insertado a la base de datosa la tabla actividad_alumnos: ". mysql_error());
				}
			}else if($respuesta == "incorrecto3"){
				$insertar = "INSERT INTO actividad_alumnos
				(UsuarioAlumno, NombreColeccion, IdPregunta, Incorrecta3) 
				VALUES ('$usuario','$coleccion', '$idPregunta', '1')";
				$meter = mysqli_query($link, $insertar);
				if(!$meter){
					die("No insertado a la base de datosa la tabla actividad_alumnos: ". mysql_error());
				}
			}
			

		}else{
			// Tenemos que actualizar la bb de datos
			if($respuesta == "incorrecto1"){
				$sql = "UPDATE actividad_alumnos SET Incorrecta1=Incorrecta1+1 
				WHERE NombreColeccion='$coleccion' AND UsuarioAlumno= '$usuario' AND IdPregunta='$idPregunta'";
				$modificar = mysqli_query($link, $sql);
				if(!$modificar){
					die("No modificado a la base de datos actividad_alumnos incorecta 1 : ". mysql_error());
				}
			}else if($respuesta == "incorrecto2"){
				$sql = "UPDATE actividad_alumnos SET Incorrecta2=Incorrecta2+1 
				WHERE NombreColeccion='$coleccion' AND UsuarioAlumno= '$usuario' AND IdPregunta='$idPregunta'";
				$modificar = mysqli_query($link, $sql);
				if(!$modificar){
					die("No modificado a la base de datos actividad_alumnos incorecta 2 : ". mysql_error());
				}
			}else if($respuesta == "incorrecto3"){
				$sql = "UPDATE actividad_alumnos SET Incorrecta3=Incorrecta3+1 
				WHERE NombreColeccion='$coleccion' AND UsuarioAlumno= '$usuario' AND IdPregunta='$idPregunta'";
				$modificar = mysqli_query($link, $sql);
				if(!$modificar){
					die("No modificado a la base de datos actividad_alumnos incorecta 3 : ". mysql_error());
				}
			}
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$sql = "UPDATE preguntas SET Frecuencia=Frecuencia+1, Fallos=Fallos+1 
        WHERE IdPregunta='$idPregunta'";
        $modificar = mysqli_query($link, $sql);
        if(!$modificar){
            die("No modificado a la base de dfatos al acertar la pregunta.: ". mysql_error());
        }

        // Actualizamos los fallos del alumno
		$sql = "UPDATE alumnos SET PreguntasFalladas=PreguntasFalladas+1
        WHERE UsuarioAlumno='$usuario'";
        $modificar = mysqli_query($link, $sql);
        if(!$modificar){
            die("No modificado a la base de dfatos de alumnos al fallaar la pregunta.: ". mysql_error());
        }

	}
	
	// Salgo a jugar coleccion
	mysqli_close($link);
	header("Location: jugarMonedas.php");
?>







