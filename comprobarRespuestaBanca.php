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
	$idFicha = $_SESSION["fichaParaBanca"];


	$respuesta = $_POST['billing_respuesta'];
    $idPregunta = $_GET['idPregunta'];
	
	
	//echo "Usuario =$usuario -- coleccion = $coleccion -- Respuesta=$respuesta  -- idPre=$idPregunta -- idFicha=$idFicha";


    // Moneda suqe voy a restar, falle o acierte la pregunta.
    $monedasGastar = $_SESSION["monedasGastar"];

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

		
	    $sql = "UPDATE juega_colecciones SET Monedas=Monedas-'$monedasGastar'
	    WHERE NombreColeccion='$coleccion' AND UsuarioAlumno= '$usuario'";
		$modificar = mysqli_query($link, $sql);
		if(!$modificar){
			die("No modificado a la base de datos al RESTAR las monedas: ". mysql_error());
		}



		// Añadir la ficha que he ganado.
		// Buscamos ne la tabla 
		$sql = "SELECT * FROM mis_fichas
		WHERE UsuarioAlumno='$usuario' AND IdFicha = '$idFicha'";
		$retval = mysqli_query($link, $sql);
		$num_rows = mysqli_num_rows($retval);
		if($num_rows == 0){ // No hay la ficha, tenemos que añadirla
			$insertar = "INSERT INTO mis_fichas (UsuarioAlumno, IdFicha, NumeroFichas) 
			VALUES ('$usuario', '$idFicha', '1')";
			$meter = mysqli_query($link, $insertar);
			if(!$meter){
				die("No insertado a la base de datos mis_fichas: ". mysql_error());
			}

			// Actualizar el numero de fichas conseguidas en juega colecciones.
			$sql = "UPDATE juega_colecciones SET FichasConseguidas=FichasConseguidas+1 
		    WHERE NombreColeccion='$coleccion' AND UsuarioAlumno= '$usuario'";
			$modificar = mysqli_query($link, $sql);
			if(!$modificar){
				die("No modificado a la base de datos juega_colecciones : ". mysql_error());
			}

			// Vamos la coleccion y sacamos el numero de fichas que tiene
			$query="SELECT NumeroFichas
	        FROM colecciones WHERE NombreColeccion = '$coleccion' ";
	        if ($result = mysqli_query($link, $query)) {
	            // fetch associative array 
	            while ($row = mysqli_fetch_assoc($result)) {
	                $totalesFichas = $row["NumeroFichas"];
	            }
	            // free result set 
	            mysqli_free_result($result);
	        }else{
	            echo "NADAAAAAAA";
	        }

	        $query="SELECT FichasConseguidas
	        FROM juega_colecciones WHERE NombreColeccion = '$coleccion' AND UsuarioAlumno ='$usuario' ";
	        if ($result = mysqli_query($link, $query)) {
	            // fetch associative array 
	            while ($row = mysqli_fetch_assoc($result)) {
	                $fichasConseguidas = $row["FichasConseguidas"];
	            }
	            // free result set 
	            mysqli_free_result($result);
	        }else{
	            echo "NADAAAAAAA";
	        }

	        // Comporbar que las fichas totales y las conseguidas sean iguales, si es asi hemos terminado la coleccion.
	        if($fichasConseguidas == $totalesFichas){ // Hemos terminado la coleccion
	        	// Actualizar el numero de fichas conseguidas en juega colecciones.
				$sql = "UPDATE juega_colecciones SET EstadoColeccion='terminada' 
			    WHERE NombreColeccion='$coleccion' AND UsuarioAlumno= '$usuario'";
				$modificar = mysqli_query($link, $sql);
				if(!$modificar){
					die("No modificado a la base de datos juega_colecciones : ". mysql_error());
				}
				mysqli_close($link);
				header("Location: coleccionesTerminadas.php");

	        }else{
	        	mysqli_close($link);
				header("Location: coleccionJugar.php");

	        }


		}else{ // Incrementar en uno la ficha
			$sql = "UPDATE mis_fichas SET NumeroFichas=NumeroFichas+1 
		    WHERE UsuarioAlumno='$usuario' AND IdFicha= '$idFicha'";
			$modificar = mysqli_query($link, $sql);
			if(!$modificar){
				die("No modificado a la base de datos al incrementar las fichas: ". mysql_error());
			}

			mysqli_close($link);
			header("Location: coleccionJugar.php");
		}



	}else{


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

        
		
		// Restarmonedas la tabla juega colecciones y las monedas
		$sql = "UPDATE juega_colecciones SET Monedas=Monedas-'$monedasGastar' 
		WHERE NombreColeccion='$coleccion' AND UsuarioAlumno= '$usuario'";
		$modificar = mysqli_query($link, $sql);
		if(!$modificar){
			die("No modificado a la base de datos al restar una vida : ". mysql_error());
		}


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
		
		// Salgo a jugar coleccion
		mysqli_close($link);
		header("Location: coleccionJugar.php");

	}
?>







