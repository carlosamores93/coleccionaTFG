<?php
	function conectarBBDD(){


		/*
		$enlace = mysqli_connect("127.0.0.1", "mi_usuario", "mi_contraseña", "mi_bd");

		if (!$enlace) {
		    echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
		    echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
		    echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
		    exit;
		}
		*/

		/*
		// Para conectar a locahost
		$enlace = mysqli_connect("localhost", "root", "", "colecciona");
		if (!$enlace) {
		    echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
		    echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
		    echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
		    exit();
		}

		return $enlace;
		*/



		// Para conectar con el servidor
		$enlace = mysqli_connect("mysql.hostinger.es", "u762666411_user", "colecciona", "u762666411_bb");
		if (!$enlace) {
		    echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
		    echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
		    echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
		    exit;
		}
		return $enlace;

		// Para conectar con el servidor que nos da el profesor
/*		
		$enlace = mysqli_connect("localhost", "colecciona", "alumnos2203.,", "colecciona");
		if (!$enlace) {
		    echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
		    echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
		    echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
		    exit;
		}
		return $enlace;
*/		




	}
?>