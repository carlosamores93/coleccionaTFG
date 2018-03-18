<?php

    // REferencias a Dompdf
    use Dompdf\Dompdf;
    

	if (!isset($_SESSION)){
        session_start();
    }
    $coleccion = $_SESSION["coleccionTerminada"];

    include_once("conectar.php");
    $link = conectarBBDD();
    mysqli_query($link, "SET NAMES 'utf8'");

    $query="SELECT NombreColeccionCorrecto, PdfColeccion
    FROM colecciones WHERE NombreColeccion = '$coleccion' ";
    if ($result = mysqli_query($link, $query)) {
        // fetch associative array 
        while ($row = mysqli_fetch_assoc($result)) {
            $nombreCorrecto = $row["NombreColeccionCorrecto"];
            $pdf = $row["PdfColeccion"];
        }
        mysqli_free_result($result);
    }else{
        echo "$coleccion";
    }

    if($pdf == ""){
    	//echo "No hay PDF, tenemos que crear el pdf.";

        // include autoloader
        require_once 'dompdf/autoload.inc.php';


        // SACAR LA INFORMACION DE LA COLECCION -> FICHA Y DESCRIPCION



        $html = '<html>';
        $html .= '<head>';
        $html .='
                    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
                    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
                ';
        $html .= '</head>';
        $html .= '<body>';
        $html .= '<div class="container">';
        $html .= "<h1 align='center'> $nombreCorrecto </h1>";
                        
                    

        $query="SELECT FotoFicha, Descripcion
        FROM fichas WHERE NombreColeccion = '$coleccion'
		ORDER BY NumeroFicha ASC, IdFicha ASC";
        if ($result = mysqli_query($link, $query)) {
            // fetch associative array 
            while ($row = mysqli_fetch_assoc($result)) {
                $fotoFicha = $row["FotoFicha"];
                $descripcionFicha = $row["Descripcion"];
                $html .= "
                    <hr>
                    <br>
                    <div class='row'>
                        <div class='col-sm-6'>
                            <p align='center'>
                                <img src='$fotoFicha' style='width:90%; height:400px;'>
                            </p>
                        </div>
                        <div class='col-sm-6'>
                            <p align='justify'>
                                $descripcionFicha
                            </p>
                        </div>
                    </div>
                ";

            }
            // free result set 
            mysqli_free_result($result);
        }else{
            echo "$nombre";
        }

        $html .= '
                </div>
            </body>
        </html>';


        // Creaciuon del documento PDF
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4','portrait');
        $dompdf->render(); // Gemnera el pdf desde el contendio html
        $obtenerPDF = $dompdf->output();
        $dompdf->stream("$nombreCorrecto"); // Enviar el PDF generado al navegador
/*
        <div class="row">
            <div class="col-sm-6">
                <div class="product-images">
                    <div class="product-main-img">
                        <img src="$fotoFicha" alt="">
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="product-images">
                    <div class="product-main-img">
                        <img src="$descripcionFicha" alt="">
                    </div>
                </div>
            </div>
        </div>
*/

    }else{
    	//echo "Tenemos PDF";

    	// Vamos a mostrar un PDF
		header('Content-type: application/pdf');
		// Se llamará downloaded.pdf
		header("Content-Disposition: attachment; filename=$nombreCorrecto.pdf");
		// La fuente de PDF se encuentra en original.pdf
		readfile($pdf);

    	/*
    	$archivo = basename($pdf);
    	$file = implode("", $pdf);
    	header('Content-Type: application/octet-stream');
    	header("Content-Disposition: attachment; filename=$archivo");
    	echo $file;
    	*/

    	/*
    	header('Content-Type: application/pdf');
    	readfile($pdf);
    	*/

    }

    // Cerrar conexion con la bbdd
    mysqli_close($link);

?>
