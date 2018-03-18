<?php

    $ficha = $_GET['idFicha'];
    $monedasGastar = $_GET['monedasGastar'];


    if (!isset($_SESSION)){
        session_start();
        $_SESSION["fichaParaBanca"] = $ficha;
        $_SESSION["monedasGastar"] = $monedasGastar;
    }

    //echo "$monedasGastar";
	//echo $_SESSION["fichaParaBanca"];

    //$_SESSION["page"] = "XXX";
/*
    echo "Holaaaaaa";
    echo $_SESSION["fichaParaBanca"];
    echo $_SESSION["monedasGastar"];
    echo $_SESSION["coleccionEmpezada"];
*/

    header("Location: jugarBanca.php");

?>
