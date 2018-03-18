<?php
    include_once("js/validarModificacionColeccion.js");


    if (!isset($_SESSION)){
        session_start();
        $page = $_SESSION["page"];
        $_SESSION["page"] = "detallesColeccion.php";
        //echo $_SESSION["super"];
    }

    if (!isset($_SESSION['coleccion'])) {
        header("Location: $page");
    } 
    
    if (!$_SESSION["loginProfesor"]) {
        header("Location: $page");
    }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="img/icono.png">
    <title>Colecciona</title>
    
    <!-- Google Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200,300,700,600' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,100' rel='stylesheet' type='text/css'>
    
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    
    <!-- Custom CSS -->
	<link rel="stylesheet" href="css/estilo.css">
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

   
    
    <div class="site-branding-area">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="logo">
                        <h1><a href="inicioProfesor.php"><img src="img/colecciona.png"></a></h1>
                    </div>
                </div>

				<?php
					require("usuario.php");
				?>
				
            </div>
        </div>
    </div> <!-- End site branding area -->  

    
    <div class="mainmenu-area">
        <div class="container">
            <div class="row">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div> 
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="inicioProfesor.php"><i class="fa fa-home fa-fw" aria-hidden="true"></i>&nbsp;Inicio</a></li>
                        <li><a href="listarAlumnos.php">Alumnos</a></li>
                        <li><a href="listarColecciones.php">Colecciones</a></li>
                        <li><a href="estadisticasProfesor.php">Estadísticas</a></li>
						<li><a href="crearColeccion.php">Nueva Coleccion</a></li>
                    </ul>
                </div>  
            </div>
        </div>
    </div> <!-- End mainmenu area -->


<?php

    include_once("conectar.php");
    $nombre = $_SESSION["coleccion"];

    $link = conectarBBDD();
    // Añadir esta linea de codigo para poner acentos y ñ
    mysqli_query($link, "SET NAMES 'utf8'");



    // Obtenemos el numero de fichas y metemos en la bbdd(actualizar)
    $query = "SELECT COUNT(*) AS numFichas FROM fichas WHERE NombreColeccion='$nombre'";
    if ($result = mysqli_query($link, $query)) {
        /* fetch associative array */
        while ($row = mysqli_fetch_assoc($result)) {
            $numFichas = $row["numFichas"];
        }
         /* free result set */
        mysqli_free_result($result);
    }
    // Tenemos el numero de fichas de la coleccion.
    //echo "$numFichas";
    $sql = "UPDATE colecciones SET NumeroFichas='$numFichas' WHERE NombreColeccion='$nombre'";
    $modificar = mysqli_query($link, $sql);
    if(!$modificar){
        die("No modificado a la base de datos: ". mysql_error());
    }



    // Obtenemos el numero de preguntas y metemos en la bbdd
    $query = "SELECT COUNT(*) AS numPreguntas FROM preguntas WHERE NombreColeccion='$nombre'";
    if ($result = mysqli_query($link, $query)) {
        /* fetch associative array */
        while ($row = mysqli_fetch_assoc($result)) {
            $numPreguntas = $row["numPreguntas"];
        }
         /* free result set */
        mysqli_free_result($result);
    }
    // Tenemos el numero de preguntas de la coleccion.
    //echo "$numPreguntas";
    $sql = "UPDATE colecciones SET NumeroPreguntas='$numPreguntas' WHERE NombreColeccion='$nombre'";
    $modificar = mysqli_query($link, $sql);
    if(!$modificar){
        die("No modificado a la base de datos: ". mysql_error());
    }


    // Obtenemos el numero de alukmnos jugando la coleccion y metemos en la bbdd
    $query = "SELECT COUNT(*) AS numAlumnosJugando FROM juega_colecciones 
    WHERE NombreColeccion='$nombre' AND EstadoColeccion='juego'";
    if ($result = mysqli_query($link, $query)) {
        /* fetch associative array */
        while ($row = mysqli_fetch_assoc($result)) {
            $jugando = $row["numAlumnosJugando"];
        }
         /* free result set */
        mysqli_free_result($result);
    }
    // Tenemos el numero de preguntas de la coleccion.
    //echo "$numPreguntas";
    $sql = "UPDATE colecciones SET AlumnosJugando='$jugando' WHERE NombreColeccion='$nombre'";
    $modificar = mysqli_query($link, $sql);
    if(!$modificar){
        die("No modificado a la base de datos alumnos jugando: ". mysql_error());
    }


    // Obtenemos el numero de alukmnos que ha terminado la coleccion y metemos en la bbdd
    $query = "SELECT COUNT(*) AS numAlumnosFin FROM juega_colecciones 
    WHERE NombreColeccion='$nombre'  AND EstadoColeccion='terminada'";
    if ($result = mysqli_query($link, $query)) {
        /* fetch associative array */
        while ($row = mysqli_fetch_assoc($result)) {
            $finalizado = $row["numAlumnosFin"];
        }
         /* free result set */
        mysqli_free_result($result);
    }
    // Tenemos el numero de preguntas de la coleccion.
    //echo "$numPreguntas";
    $sql = "UPDATE colecciones SET AlumnosFin='$finalizado' WHERE NombreColeccion='$nombre'";
    $modificar = mysqli_query($link, $sql);
    if(!$modificar){
        die("No modificado a la base de datos alumnos finalizado: ". mysql_error());
    }

	$query = "SELECT COUNT(*) AS numAlumnosBloq FROM juega_colecciones 
    WHERE NombreColeccion='$nombre'  AND EstadoColeccion='bloqueada'";
    if ($result = mysqli_query($link, $query)) {
        /* fetch associative array */
        while ($row = mysqli_fetch_assoc($result)) {
            $bloqueados = $row["numAlumnosBloq"];
        }
         /* free result set */
        mysqli_free_result($result);
    }
    $sql = "UPDATE colecciones SET AlumnosBloqueados='$bloqueados' WHERE NombreColeccion='$nombre'";
    $modificar = mysqli_query($link, $sql);
    if(!$modificar){
        die("No modificado a la base de datos alumnos finalizado: ". mysql_error());
    }



    $query="SELECT NombreColeccionCorrecto, TemaColeccion, Clave, FotoColeccion, PdfColeccion,
    Vida, PrecioVida, FichasFaciles, FichasMedio, FichasDificiles,
    NumeroFichas, NumeroPreguntas, AlumnosJugando, AlumnosFin, Publicar, MostrarRespuesta
    FROM colecciones WHERE NombreColeccion = '$nombre' ";
    if ($result = mysqli_query($link, $query)) {
        // fetch associative array 
        while ($row = mysqli_fetch_assoc($result)) {
            $nombreCorrecto = $row["NombreColeccionCorrecto"];
            $tema = $row["TemaColeccion"];
            $clave = $row["Clave"];
            $foto = $row["FotoColeccion"];
            $pdf = $row["PdfColeccion"];
            $vidas = $row["Vida"];
            $monedas = $row["PrecioVida"];
            $fichaFacil = $row["FichasFaciles"];
            $fichaMedio = $row["FichasMedio"];
            $fichaDificil = $row["FichasDificiles"];
            $fichas = $row["NumeroFichas"];
            $preguntas = $row["NumeroPreguntas"];
            $jugando = $row["AlumnosJugando"];
            $finalizado = $row["AlumnosFin"];
            $publicar = $row["Publicar"];
            $respuesta = $row["MostrarRespuesta"];

        }

        // free result set 
        mysqli_free_result($result);
    }else{
        echo "$nombre";
    }


    // Cerrar conexion con la bbdd
    mysqli_close($link);

?>



	<div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2><strong>Coleccion: <?php echo "$nombreCorrecto";?></strong></h2>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End Page title area -->
	
   
    <div class="single-product-area">
        <div class="zigzag-bottom">
		
		</div>
		
        <div class="container">
            <div class="row">
			
                <div class="col-md-11">
                    <div class="product-content-right">
                                               
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="product-images">
                                    <div class="product-main-img">
                                        <img src="<?php echo "$foto";?>" alt=""><br><br>
										<div class="form-row place-order">
											<a href="listarFichas.php">
                                                <input type="submit" value="Ver Fichas" class="button">
                                            </a>
											<a href="listarPreguntas.php">
                                                <input type="submit" value="Ver Preguntas" class="button">
                                            </a>
                                            <br>
										</div>
                                        <div class="form-row place-order">
                                            <br>
                                            <a href="crearFicha.php">
                                                <input type="submit" value="Nueva Ficha" class="button">
                                            </a>
                                            <a href="crearPregunta.php">
                                                <input type="submit" value="Nueva Pregunta" class="button">
                                            </a>
                                        </div>
                                    </div>
						
                                </div>
                            </div>
                            
							<div class="col-sm-6">
                                <div class="product-inner">
                                    <div role="tabpanel">
                                        <ul class="product-tab" role="tablist">
                                            <li role="presentation" class="active"><a href="#detalles" aria-controls="home" role="tab" data-toggle="tab">Detalles</a></li>
                                            <li role="presentation"><a href="#modificar" aria-controls="profile" role="tab" data-toggle="tab">Modificar</a></li>
                                            <li role="presentation">
                                                <a href="#exportar" aria-controls="profile" role="tab" data-toggle="tab">Exportar</a>
                                            </li>
                                            <li role="presentation">
                                                <a href="#importar" aria-controls="profile" role="tab" data-toggle="tab">Importar</a>
                                            </li>
											<li role="presentation"><a href="#eliminar" aria-controls="hola" role="tab" data-toggle="tab">Eliminar</a></li>
											
										</ul>
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane fade in active" id="detalles">


                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <h3>Nombre único</h3>
                                                            <font color="#5a88ca">
                                                                <label>
                                                                    <h4>
                                                                        <strong>
                                                                            <?php echo "$nombre";?>
                                                                        </strong>
                                                                    </h4>
                                                                </label>
                                                            </font>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <h3>Nombre correcto</h3>
                                                        <font color="#5a88ca">
                                                            <label>
                                                                <h4>
                                                                    <strong>
                                                                        <?php echo "$nombreCorrecto";?>
                                                                    </strong>
                                                                </h4>
                                                            </label>
                                                        </font>                                                        
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <h3>Tema</h3>
                                                        <font color="#5a88ca">
                                                            <label>
                                                                <h4>
                                                                    <strong>
                                                                        <?php echo "$tema";?>
                                                                    </strong>
                                                                </h4>
                                                            </label>
                                                        </font>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <h3>Clave</h3>
                                                        <font color="#5a88ca">
                                                            <label>
                                                                <h4>
                                                                    <strong>
                                                                        <?php echo "$clave";?>
                                                                    </strong>
                                                                </h4>
                                                            </label>
                                                        </font>                                                        
                                                    </div>
                                                </div>

                                                

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <h3>Publicada</h3>
                                                        <font color="#5a88ca">
                                                            <label>
                                                                <h4>
                                                                    <strong>
                                                                        <?php echo "$publicar";?>
                                                                    </strong>
                                                                </h4>
                                                            </label>
                                                        </font>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <h3>Mostrar respuestas</h3>
                                                        <font color="#5a88ca">
                                                            <label>
                                                                <h4>
                                                                    <strong>
                                                                        <?php echo "$respuesta";?>
                                                                    </strong>
                                                                </h4>
                                                            </label>
                                                        </font>                                                 
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <h3>Vidas iniciales</h3>
                                                        <font color="#5a88ca">
                                                            <label>
                                                                <h4>
                                                                    <strong>
                                                                        <?php echo "$vidas";?>
                                                                    </strong>
                                                                </h4>
                                                            </label>
                                                        </font>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <h3>Precio de una vida</h3>
                                                        <font color="#5a88ca">
                                                            <label>
                                                                <h4>
                                                                    <strong>
                                                                        <?php echo "$monedas";?>
                                                                    </strong>
                                                                </h4>
                                                            </label>
                                                        </font>                                                 
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-12" align='center'>
                                                        <h3>Precio de las fichas</h3>
                                                    </div>
                                                    <div class="col-sm-4" align='center'>
                                                        <h3>Fáciles</h3>
                                                        <font color="#5a88ca">
                                                            <label>
                                                                <h4>
                                                                    <strong>
                                                                        <?php echo "$fichaFacil";?>
                                                                    </strong>
                                                                </h4>
                                                            </label>
                                                        </font>
                                                    </div>

                                                    <div class="col-sm-4" align='center'>
                                                        <h3>Medio</h3>
                                                        <font color="#5a88ca">
                                                            <label>
                                                                <h4>
                                                                    <strong>
                                                                        <?php echo "$fichaMedio";?>
                                                                    </strong>
                                                                </h4>
                                                            </label>
                                                        </font>
                                                    </div>

                                                    <div class="col-sm-4" align='center'>
                                                        <h3>Difíciles</h3>
                                                        <font color="#5a88ca">
                                                            <label>
                                                                <h4>
                                                                    <strong>
                                                                        <?php echo "$fichaDificil";?>
                                                                    </strong>
                                                                </h4>
                                                            </label>
                                                        </font>                                                 
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <h3>Alumnos en juego</h3>
                                                        <font color="#5a88ca">
                                                            <label>
                                                                <h4>
                                                                    <strong>
                                                                        <?php echo "$jugando";?>
                                                                    </strong>
                                                                    
                                                                </h4>
                                                            </label>
                                                        </font>
                                                        <a href='pasarColeccionAlumnosJugando.php?coleccion=<?php echo "$nombre";?>' >
                                                            &nbsp;&nbsp;Ver alumnos
                                                        </a>
                                                    
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <h3>Alumnos finalizada</h3>
                                                        <font color="#5a88ca">
                                                            <label>
                                                                <h4>
                                                                    <strong>
                                                                        <?php echo "$finalizado";?>
                                                                    </strong>
                                                                </h4>
                                                            </label>
                                                        </font>
                                                        <a href='pasarColeccionAlumnosTerminada.php?coleccion=<?php echo "$nombre";?>'>
                                                         &nbsp;&nbsp;Ver alumnos
                                                     </a>
                                                    
                                                                                                              
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <h3>Alumnos bloqueados</h3>
                                                        <font color="#5a88ca">
                                                            <label>
                                                                <h4>
                                                                    <strong>
                                                                        <?php echo "$bloqueados";?>
                                                                    </strong>
                                                                </h4>
                                                            </label>
                                                        </font>
                                                        <a href='pasarColeccionAlumnosBloqueados.php?coleccion=<?php echo "$nombre";?>'> 
                                                        &nbsp;&nbsp;Ver alumnos
                                                        </a>
                                                    
                                                    </div>

                                                    <div class="col-sm-6">
                                                    </div>

                                                  
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <h3>Nº preguntas</h3>
                                                        <font color="#5a88ca">
                                                            <label>
                                                                <h4>
                                                                    <strong>
                                                                        <?php echo "$preguntas";?>
                                                                    </strong>
                                                                </h4>
                                                            </label>
                                                        </font>                                                    
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <h3>Nº fichas</h3>
                                                        <font color="#5a88ca">
                                                            <label>
                                                                <h4>
                                                                    <strong>
                                                                        <?php echo "$fichas";?>
                                                                    </strong>
                                                                </h4>
                                                            </label>
                                                        </font>                                                                                                        
                                                    </div>
                                                </div>
													
                                                    

																						
											</div>



											<div role="tabpanel" class="tab-pane fade" id="modificar">
                                                
												<form action="modificarColeccion.php?nombreColeccion=<?php echo "$nombre";?>"
                                                method="post" enctype="multipart/form-data" onsubmit="return validarColeccionModificada()"
                                                class="checkout" name="checkout">
													<div id="customer_details" class="col2-set">
														<div class="col-1">

															<label class="" >Nombre correcto de la colección</label>
															<input type="text" value="<?php echo "$nombreCorrecto";?>" 
                                                            placeholder="Nombre" id="billing_nombre_coleccion" 
                                                            name="billing_nombre_coleccion" class="input-text " required>

															<label class="" >Tema de la coleccción </label>
															<input type="text" value="<?php echo "$tema";?>" 
                                                            placeholder="Tema" id="billing_tema_coleccion" 
                                                            name="billing_tema_coleccion" class="input-text " required>

															<label class="" >Clave de la coleccción </label>
															<input type="text" value="<?php echo "$clave";?>" 
                                                            placeholder="Clave, máximo 5 letras" title="Clave, máximo 5 letras" 
                                                            id="billing_clave" name="billing_clave" 
                                                            size="5" maxlength="5" class="input-text " required>

                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <label class="" >Vidas iniciales</label>
                                                                    <input type="number" value="<?php echo "$vidas";?>" 
                                                                    min="1"
                                                                    placeholder="Vidas" id="billing_vidas" 
                                                                    name="billing_vidas" class="input-text " required>
                                                                </div>

                                                                <div class="col-sm-6">
                                                                    <label class="" >Precio de una vida</label>
                                                                    <input type="number" value="<?php echo "$monedas";?>" 
                                                                    min="1"
                                                                    placeholder="Precio" id="billing_precio_vida" 
                                                                    name="billing_precio_vida" class="input-text " required>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-sm-12" align='center'>
                                                                    <label class="" >Precio de las fichas</label>
                                                                </div>

                                                                <div class="col-sm-4" align='center'>
                                                                    <label class="" >Fáciles</label>
                                                                    <input type="number" value="<?php echo $fichaFacil;?>" 
                                                                    min="1" id="billing_fichas_faciles" 
                                                                    name="billing_fichas_faciles" class="input-text " required>
                                                                </div>

                                                                <div class="col-sm-4" align='center'>
                                                                    <label class="" >Medio</label>
                                                                    <input type="number" value="<?php echo $fichaMedio;?>" 
                                                                    min="1" id="billing_fichas_medio" 
                                                                    name="billing_fichas_medio" class="input-text " required>
                                                                </div>

                                                                <div class="col-sm-4" align='center'>
                                                                    <label class="" >Dificiles</label>
                                                                    <input type="number" value="<?php echo $fichaDificil;?>" 
                                                                    min="1" id="billing_fichas_dificiles" 
                                                                    name="billing_fichas_dificiles" class="input-text " required>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <label class="" >Publicar colección</label>
                                                                        <?php 
                                                                        if($publicar == "NO"){
                                                                            echo '
                                                                            <input type="radio" name="billing_publicar" value="SI"> Publicar** <br>
                                                                            <input type="radio" name="billing_publicar" value="NO" checked> No publicar
                                                                            ';
                                                                        }else{
                                                                            echo '
                                                                            <input type="radio" name="billing_publicar" value="SI" checked> Publicar**<br>
                                                                            <input type="radio" name="billing_publicar" value="NO"> No publicar
                                                                            ';
                                                                        }

                                                                        ?>
                                                                </div>


                                                                <div class="col-sm-6">
                                                                    <label class="" >Mostrar respuesta</label>
                                                                        <?php 
                                                                        if($respuesta == "NO"){
                                                                            echo '
                                                                            <input type="radio" name="billing_respuesta" value="SI"> Mostrar <br>
                                                                            <input type="radio" name="billing_respuesta" value="NO" checked> No mostrar
                                                                            ';
                                                                        }else{
                                                                            echo '
                                                                            <input type="radio" name="billing_respuesta" value="SI" checked> Mostrar<br>
                                                                            <input type="radio" name="billing_respuesta" value="NO"> No mostrar
                                                                            ';
                                                                        }

                                                                        ?>
                                                                </div>

                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                   <p color="red">
                                                                    <font color="red">
                                                                        <strong>
                                                                        ** Para publicar debes de tener al menos una ficha y pregunta de cada dificultad(Fácil, Medio, Difícil).
                                                                        </strong> 
                                                                    </p> 
                                                                </font>
                                                                </div>                                                                
                                                            </div>
															
															<label class="" >Selecciona nueva imagen para la colección</label>
															<input  type="file" id="billing_imagen" name="billing_imagen" size="1">
<!--
                                                            <br>
                                                            <label class="" >Selecciona nuevo PDF FINAL de la colección</label>
                                                            <input  type="file" id="billing_imagen_pdf" name="billing_imagen_pdf" size="1">
-->

                                                            <?php 
                                                                if($pdf != ""){
                                                                    echo '
                                                                    <br>
                                                                    <label class="" >¿ Quieres borrar el PDF actual?</label>
                                                                    <input type="radio" name="borrar_pdf" value="SI"> Borrar pdf actual
                                                                    <input type="radio" name="borrar_pdf" value="NO" checked> Mantener pdf actual
                                                                    ';
                                                                }else{
                                                                    echo '
                                                                        <br>
                                                            <label class="" >Selecciona nuevo PDF FINAL de la colección</label>
                                                            <input  type="file" id="billing_imagen_pdf" name="billing_imagen_pdf" size="1">

                                                                    ';
                                                                }

                                                            ?>
                                                            

														</div>
													</div>
													<br>
													<br>
													<div class="form-row place-order">
														<input type="submit" value="Modificar" class="button">
														<input type="reset" value="Restaurar" class="button"> 	
													</div>
												</form>      	
												
                                            </div>

                                            <div role="tabpanel" class="tab-pane fade" id="exportar">

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <h3 align="center">XML de las preguntas</h3>
                                                        <a href="exportarPreguntas.php" target="_blank">
                                                            <p class="parrafo" ><input type="submit" value="exportar"></p>
                                                        </a>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <h3 align="center">XML de las fichas</h3>
                                                        <a href="exportarFichas.php" target="_blank">
                                                            <p class="parrafo" ><input type="submit" value="exportar"></p>
                                                        </a>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <h3 align="center">ZIP de las fichas</h3>
                                                        <a href="exportarFichasZip.php" target="_blank">
                                                            <p class="parrafo" ><input type="submit" value="exportar"></p>
                                                        </a>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <h3 align="center">PDF de la colección</h3>
                                                        <a href="exportarColeccion.php" target="_blank">
                                                            <p class="parrafo" ><input type="submit" value="exportar"></p>
                                                        </a>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <h3 align="center">Excel de los alumnos</h3>
                                                        <a href="exportarInformeAlumnos.php" target="_blank">
                                                            <p class="parrafo" ><input type="submit" value="exportar"></p>
                                                        </a>
                                                    </div>
                                                </div>
                                                
                                                
                                                
                                                

                                                
                                            </div>


                                            <div role="tabpanel" class="tab-pane fade" id="importar">
                                                <form action="importarColeccion.php" method="post" 
                                                enctype="multipart/form-data" class="checkout" name="checkout">
                                                    <h4>
                                                        Seleccione el XML que contiene las preguntas
                                                    </h4>
                                                    <input align="center" type="file" id="billing_preg_xml" name="billing_preg_xml" >
                                                    <hr>
                                                    <h4>
                                                        Seleccione el XML que contiene la descripcion de las fichas
                                                    </h4>
                                                    <input align="center" type="file" id="billing_fichas_xml" name="billing_fichas_xml">
                                                    <hr>
                                                    <h4>
                                                        Seleccione el ZIP que contiene las fotos de las fichas
                                                    </h4>
                                                    <input align="center" type="file" id="billing_fotos_zip" name="billing_fotos_zip">
                                                    <br>
                                                    <p class="parrafo" >
                                                        <input type="submit" value="importar">
                                                    </p>  
                                                </form>


                                            </div>
											
                                          
											<div role="tabpanel" class="tab-pane fade" id="eliminar">
                                                
                                                <h2 align="center">¿Estás seguro de eliminar esta colección?</h2>
                                                <form action="eliminarColeccion.php?nombreColeccion=<?php echo "$nombre";?>" 
                                                    method="post" enctype="multipart/form-data" class="checkout" name="checkout">
                                                    <p class="parrafo" ><input type="submit" value="Sí, estoy seguro"></p>
                                                </form>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
							
                        </div>
                        
                    </div>                    
                </div>
            </div>
        </div>
		
    </div>
       
	
    <?php
        require("footer.php");
    ?>
   
    <!-- Latest jQuery form server -->
    <script src="https://code.jquery.com/jquery.min.js"></script>
    
    <!-- Bootstrap JS form CDN -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    
    <!-- jQuery sticky menu -->
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    
    <!-- jQuery easing -->
    <script src="js/jquery.easing.1.3.min.js"></script>
    
    <!-- Main Script -->
    <script src="js/main.js"></script>
    
    <!-- Slider -->
    <script type="text/javascript" src="js/bxslider.min.js"></script>
	<script type="text/javascript" src="js/script.slider.js"></script>
  </body>
</html>