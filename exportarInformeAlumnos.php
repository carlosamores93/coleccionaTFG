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
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E1", "PREGUNTA");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F1", "RESPUESTA_CORRECTA");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G1", "CORRECTA");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H1", "RESPUESTA_INCORRECTA_1");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("I1", "INCORRECTA_1");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("J1", "RESPUESTA_INCORRECTA_2");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("K1", "INCORRECTA_2");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("L1", "RESPUESTA_INCORRECTA_3");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("M1", "INCORRECTA_3");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("N1", "TIME_OUT");


    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////Aqui sacamos los datos de la bbdd//////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $i=2;
    $query="SELECT *
    FROM alumnos INNER JOIN actividad_alumnos ON alumnos.UsuarioAlumno = actividad_alumnos.UsuarioAlumno 
    AND actividad_alumnos.NombreColeccion ='$coleccion'
    ORDER BY actividad_alumnos.UsuarioAlumno, actividad_alumnos.IdPregunta";
    if ($result = mysqli_query($link, $query)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $alumno = $row["UsuarioAlumno"];
            $nombreAlumno = $row["NombreAlumno"];
            $apellidosAlumno = $row["ApellidosAlumno"];
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$i, "$alumno");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, "$nombreAlumno");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$i, "$apellidosAlumno");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$i, "$nombreCorrecto");
            $i++;
        }
        mysqli_free_result($result);
    }else{
        //echo "NADA";
    }


    $i=2;
    $query="SELECT *
    FROM actividad_alumnos INNER JOIN preguntas 
    ON (actividad_alumnos.IdPregunta = preguntas.IdPregunta) 
    AND (actividad_alumnos.NombreColeccion = preguntas.NombreColeccion)
    WHERE actividad_alumnos.NombreColeccion ='$coleccion'
    ORDER BY actividad_alumnos.UsuarioAlumno, actividad_alumnos.IdPregunta";
    if ($result = mysqli_query($link, $query)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $enunciado = $row["Enunciado"];
            $RespuestaCorrecta = $row["RespuestaCorrecta"];
            $Correcta = $row["Correcta"];
            $RespuestaIncorrecta1 = $row["RespuestaIncorrecta1"];
            $Incorrecta1 = $row["Incorrecta1"];
            $RespuestaIncorrecta2 = $row["RespuestaIncorrecta2"];
            $Incorrecta2 = $row["Incorrecta2"];
            $RespuestaIncorrecta3 = $row["RespuestaIncorrecta3"];
            $Incorrecta3 = $row["Incorrecta3"];
            $TimeOut = $row["TimeOut"];
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$i, "$enunciado");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$i, "$RespuestaCorrecta");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, "$Correcta");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$i, "$RespuestaIncorrecta1");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$i, "$Incorrecta1");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$i, "$RespuestaIncorrecta2");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$i, "$Incorrecta2");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$i, "$RespuestaIncorrecta3");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$i, "$Incorrecta3");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$i, "$TimeOut");
            $i++;
        }
        mysqli_free_result($result);
    }else{
        echo "NADA";
    }


    header('Content-Type: application/vnd.ms-excel');
    header("Content-Disposition: attachment;filename=$nombreCorrecto.xlsx");
    header('Cache-Control: max-age=0');

    $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
    $objWriter->save('php://output');
    exit;

    mysqli_close($link);

?>
