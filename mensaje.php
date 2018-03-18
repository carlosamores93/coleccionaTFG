<?php
	

	$mensaje = "Línea 1\r\nLínea 2\r\nLínea 3";

	// Si cualquier línea es más larga de 70 caracteres, se debería usar wordwrap()
	$mensaje = wordwrap($mensaje, 70, "\r\n");

	// Enviarlo
	if(mail('vacabezas@ucm.es', 'Mi título', $mensaje)){
		echo "enviado...";
	}else{
		echo "no enviado";
	}

	// Enviarlo
	if(mail('caamores@ucm.es', 'Mi título', $mensaje)){
		echo "enviado...";
	}else{
		echo "no enviado";
	}

?>