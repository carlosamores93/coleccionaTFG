<?php
    include_once("conectar.php");
    $link = conectarBBDD();
    mysqli_query($link, "SET NAMES 'utf8'");

    if (!isset($_SESSION)){
        session_start();
    }
    $coleccion = $_SESSION["coleccion"];
    $profesor = $_SESSION["usuario"];


    $query="SELECT NombreColeccionCorrecto
    FROM colecciones WHERE NombreColeccion = '$coleccion' ";
    if ($result = mysqli_query($link, $query)) {
        // fetch associative array 
        while ($row = mysqli_fetch_assoc($result)) {
            $nombreCorrecto = $row["NombreColeccionCorrecto"];
        }
        mysqli_free_result($result);
    }else{
        echo "$coleccion";
    }

    $query="SELECT NombreProfesor, ApellidosProfesor
    FROM profesores WHERE UsuarioProfesor = '$profesor' ";
    if ($result = mysqli_query($link, $query)) {
        // fetch associative array 
        while ($row = mysqli_fetch_assoc($result)) {
            $nombreProfe = $row["NombreProfesor"];
            $apellidosProfe = $row["ApellidosProfesor"];
        }
        mysqli_free_result($result);
    }else{
        echo "$coleccion";
    }
    
 
    require_once 'PHPExcel/PHPExcel.php';
    $objPHPExcel = new PHPExcel();

    //Informacion del excel
    $objPHPExcel->
    getProperties()
    ->setCreator("$nombreProfe $apellidosProfe")
    ->setLastModifiedBy("$nombreProfe $apellidosProfe")
    ->setTitle("Coleccion: $nombreCorrecto")
    ->setSubject("Informe de los alumnos")
    ->setDescription("Documento generado con PHPExcel")
    ->setKeywords("")
    ->setCategory("Colecciona");  


    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A1", "USUARIO");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("B1", "NOMBRE");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C1", "APELLIDOS");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D1", "COLECCIÓN");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E1", "FICHAS CONSEGUIDAS");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F1", "VIDAS");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G1", "MONEDAS");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H1", "PREGUNTAS ACERTADAS");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("I1", "PREGUNTAS FALLADAS");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("J1", "TIME OUT");


    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////Aqui sacamos los datos de la bbdd//////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $i=2;
    $query="SELECT *
    FROM alumnos INNER JOIN juega_colecciones ON alumnos.UsuarioAlumno = juega_colecciones.UsuarioAlumno 
    AND juega_colecciones.NombreColeccion ='$coleccion' AND juega_colecciones.EstadoColeccion ='terminada'
    ORDER BY juega_colecciones.UsuarioAlumno";
    if ($result = mysqli_query($link, $query)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $alumno = $row["UsuarioAlumno"];
            $nombreAlumno = $row["NombreAlumno"];
            $apellidosAlumno = $row["ApellidosAlumno"];
            $fichas = $row["FichasConseguidas"];
            $vidas = $row["Vidas"];
            $monedas = $row["Monedas"];
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$i, "$alumno");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, "$nombreAlumno");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$i, "$apellidosAlumno");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$i, "$nombreCorrecto");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$i, "$fichas");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$i, "$vidas");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, "$monedas");

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            $sql="SELECT SUM(Correcta) AS CorrectaColeccion
            FROM actividad_alumnos 
            WHERE NombreColeccion ='$coleccion' AND UsuarioAlumno = '$alumno'";
            if ($res = mysqli_query($link, $sql)) {

                // fetch associative array  Esto solo da una vuelta.
                while ($row = mysqli_fetch_assoc($res)) {
                    $acertadasColeccion =$row["CorrectaColeccion"];
                    }
                mysqli_free_result($res);
            }

            $sql="SELECT SUM(Incorrecta1)+SUM(Incorrecta2)+SUM(Incorrecta3) AS IncorrectaColeccion
            FROM actividad_alumnos 
            WHERE NombreColeccion ='$coleccion' AND UsuarioAlumno = '$alumno'";
            if ($res = mysqli_query($link, $sql)) {

                // fetch associative array  Esto solo da una vuelta.
                while ($row = mysqli_fetch_assoc($res)) {
                    $falladasColeccion =$row["IncorrectaColeccion"];
                    }
                mysqli_free_result($res);
            }



            $sql="SELECT SUM(TimeOut) AS TimeOutColeccion
            FROM actividad_alumnos 
            WHERE NombreColeccion ='$coleccion' AND UsuarioAlumno = '$alumno'";
            if ($res = mysqli_query($link, $sql)) {

                // fetch associative array  Esto solo da una vuelta.
                while ($row = mysqli_fetch_assoc($res)) {
                    $timeOutColeccion =$row["TimeOutColeccion"];
                    }
                mysqli_free_result($res);
            }

            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$i, "$acertadasColeccion");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$i, "$falladasColeccion");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$i, "$timeOutColeccion");


            $i++;
        }
        mysqli_free_result($result);
    }else{
        //echo "NADA";
    }


    header('Content-Type: application/vnd.ms-excel');
    header("Content-Disposition: attachment;filename=$nombreCorrecto Terminada.xlsx");
    header('Cache-Control: max-age=0');

    $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
    $objWriter->save('php://output');
    exit;

    mysqli_close($link);

?>
