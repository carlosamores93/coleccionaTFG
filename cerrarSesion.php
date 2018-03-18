<?php
	if (!isset($_SESSION)){
		session_start();
	}


	/*
	$user = $_SESSION["super"];
	echo "$user";
	$kl = 'klkkkkkkkk';
	echo "$kl";
	*/

	// destruyo la sesión 
    unset($_SESSION);
	//Free all session variables
	session_unset();
	//Destruye toda la información registrada de una sesión
	session_destroy();
	
	header('Location: index.php');
	
?>







