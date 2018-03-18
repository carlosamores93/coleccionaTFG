<?php
    if (!isset($_SESSION)){
        session_start();
    }

    include_once("conectar.php");


    
    if(isset($_SESSION["alumno"])){
        $usuario = $_SESSION["alumno"];
    }else{
        $usuario = $_SESSION["usuario"];
    }
    //echo "$usuario";
    ///echo "$tipo";
    $link = conectarBBDD();
    // Añadir esta linea de codigo para poner acentos y ñ
    mysqli_query($link, "SET NAMES 'utf8'");



    // Obtenemos cuantas colecciones estoy jugando y metemos en la bbdd
    $query = "SELECT COUNT(*) AS coleccionesJuego FROM juega_colecciones 
    WHERE UsuarioAlumno='$usuario' AND EstadoColeccion='juego'";
    if ($result = mysqli_query($link, $query)) {
        /* fetch associative array */
        while ($row = mysqli_fetch_assoc($result)) {
            $coleccionesJuego = $row["coleccionesJuego"];
        }
         /* free result set */
        mysqli_free_result($result);
    }
    // Tenemos el numero de preguntas de la coleccion.
    //echo "$numPreguntas";
    $sql = "UPDATE alumnos SET ColeccionesJuego='$coleccionesJuego' WHERE UsuarioAlumno='$usuario'";
    $modificar = mysqli_query($link, $sql);
    if(!$modificar){
        die("No modificado a la base de datos colecciones jugando de la tabla alumnos: ". mysql_error());
    }
    // Obtenemos cuantas colecciones que he termiando  y metemos en la bbdd
    $query = "SELECT COUNT(*) AS coleccionesFin FROM juega_colecciones 
    WHERE UsuarioAlumno='$usuario' AND EstadoColeccion='terminada'";
    if ($result = mysqli_query($link, $query)) {
        /* fetch associative array */
        while ($row = mysqli_fetch_assoc($result)) {
            $coleccionesFin = $row["coleccionesFin"];
        }
         /* free result set */
        mysqli_free_result($result);
    }
    // Tenemos el numero de preguntas de la coleccion.
    //echo "$numPreguntas";
    $sql = "UPDATE alumnos SET ColeccionesFin='$coleccionesFin' WHERE UsuarioAlumno='$usuario'";
    $modificar = mysqli_query($link, $sql);
    if(!$modificar){
        die("No modificado a la base de datos colecciones fin de la tabla alumnos: ". mysql_error());
    }
    // Obtenemos elñ numnero de fichasd totales no repertidfosd que he conseguidop
    $query = "SELECT SUM(FichasConseguidas) AS fichasTotales FROM juega_colecciones 
    WHERE UsuarioAlumno='$usuario'";
    if ($result = mysqli_query($link, $query)) {
        /* fetch associative array */
        while ($row = mysqli_fetch_assoc($result)) {
            $fichasTotales = $row["fichasTotales"];
        }
         /* free result set */
        mysqli_free_result($result);
    }
    // Tenemos el numero de preguntas de la coleccion.
    //echo "$numPreguntas";
    $sql = "UPDATE alumnos SET NumeroFichas='$fichasTotales' WHERE UsuarioAlumno='$usuario'";
    $modificar = mysqli_query($link, $sql);
    if(!$modificar){
        die("No modificado a la base de datosNumeroFichas de la tabla alumnos: ". mysql_error());
    }



    
    // Cerrar conexion con la bbdd
    mysqli_close($link);



?>

