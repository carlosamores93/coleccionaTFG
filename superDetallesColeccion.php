<?php
    if (!isset($_SESSION)){
        session_start();
        $page = $_SESSION["page"];
        $_SESSION["page"] = "superDetallesColeccion.php";
        //echo $_SESSION["super"];
    } 

    if ((!isset($_SESSION['profesor'])) && (!isset($_SESSION['coleccion']))) {
        header("Location: $page");
    } 

    if (!$_SESSION["loginSuper"]) {
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
                        <h1><a href="inicioSuper.php"><img src="img/colecciona.png"></a></h1>
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
                        <li><a href="inicioSuper.php"> <i class="fa fa-home fa-fw" aria-hidden="true"></i>&nbsp;Inicio</a></li>
                        <li><a href="superListarProfesores.php">Profesores</a></li>
                        <li><a href="superListarAlumnos.php">Alumnos</a></li>
                        <li><a href="superListarColecciones.php">Colecciones</a></li>
                        <li><a href="superRegistrarUsuario.php">Nuevo usuario</a></li>
                    </ul>
                </div>  
            </div>
        </div>
    </div> <!-- End mainmenu area -->


<?php

    $nombre = $_SESSION['coleccion'];
    $usuario = $_SESSION['profesor'];

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





    $query="SELECT NombreColeccionCorrecto, TemaColeccion, Clave, FotoColeccion, 
    Vida, PrecioVida, NumeroFichas, NumeroPreguntas, AlumnosJugando, AlumnosFin, Publicar
    FROM colecciones WHERE NombreColeccion = '$nombre' ";
    if ($result = mysqli_query($link, $query)) {
        // fetch associative array 
        while ($row = mysqli_fetch_assoc($result)) {
            $nombreCorrecto = $row["NombreColeccionCorrecto"];
            $tema = $row["TemaColeccion"];
            $clave = $row["Clave"];
            $foto = $row["FotoColeccion"];
            $vidas = $row["Vida"];
            $monedas = $row["PrecioVida"];
            $fichas = $row["NumeroFichas"];
            $preguntas = $row["NumeroPreguntas"];
            $jugando = $row["AlumnosJugando"];
            $finalizado = $row["AlumnosFin"];
            $publicar = $row["Publicar"];

        }

        // free result set 
        mysqli_free_result($result);
    }else{
        echo "$nombre";
    }


    $query="SELECT NombreProfesor, ApellidosProfesor
    FROM profesores WHERE UsuarioProfesor = '$usuario' ";
    if ($result = mysqli_query($link, $query)) {
        // fetch associative array 
        while ($row = mysqli_fetch_assoc($result)) {
            $nombreProfe = $row["NombreProfesor"];
            $apellidosProfe = $row["ApellidosProfesor"];

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

<!--
										<div class="form-row place-order">
											<a href="listarFichas.php?nombreColeccion=<?php echo "$nombre";?>">
                                                <input type="submit" value="Ver Fichas" class="button">
                                            </a>
											<a href="listarPreguntas.php?nombreColeccion=<?php echo "$nombre";?>">
                                                <input type="submit" value="Ver Preguntas" class="button">
                                            </a>
                                            <br>
										</div>
                                        <div class="form-row place-order">
                                            <br>
                                            <a href="crearFicha.php?nombreColeccion=<?php echo "$nombre";?>">
                                                <input type="submit" value="Nueva Ficha" class="button">
                                            </a>
                                            <a href="crearPregunta.php?nombreColeccion=<?php echo "$nombre";?>">
                                                <input type="submit" value="Nueva Pregunta" class="button">
                                            </a>
                                        </div>
                                        <div class="form-row place-order">
                                            <br>
                                            <a href="crearPreguntaFicha.php?nombreColeccion=<?php echo "$nombre";?>">
                                                <input type="submit" value="Nueva Pregunta-Ficha" class="button">
                                            </a>

                                        </div>
-->

                                    </div>
						
                                </div>
                            </div>
                            
							<div class="col-sm-6">
                                <div class="product-inner">
								
																 
                                    <div role="tabpanel">
                                        <ul class="product-tab" role="tablist">
                                            <li role="presentation" class="active"><a href="#detalles" aria-controls="home" role="tab" data-toggle="tab">Detalles</a></li>
                                        <!--<li role="presentation">
                                                <a href="#modificar" aria-controls="profile" role="tab" data-toggle="tab">Modificar</a>
                                            </li>
                                            <li role="presentation">
                                                <a href="#exportar" aria-controls="profile" role="tab" data-toggle="tab">Exportar</a>
                                            </li>
                                        -->
											<li role="presentation"><a href="#eliminar" aria-controls="hola" role="tab" data-toggle="tab">Eliminar</a></li>
											
										</ul>
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane fade in active" id="detalles">


                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <h3>Profesor</h3>
                                                            <font color="#5a88ca">
                                                                <label>
                                                                    <h4>
                                                                        <strong>
                                                                            <?php echo "$nombreProfe $apellidosProfe";?>
                                                                        </strong>
                                                                    </h4>
                                                                </label>
                                                            </font>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <h3>Nombre coleccion</h3>
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

                                                   
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <h3>Nº Preguntas </h3>
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
                                                        <h3>Nº Fichas</h3>
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


<!--
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


															<label class="" >Número de vidas inicial</label>
															<input type="number" value="<?php echo "$vidas";?>" 
                                                            min="1" max="500"
                                                            placeholder="  Vidas" id="billing_vidas" 
                                                            name="billing_vidas" class="input-text " required>

															<label class="" >Precio de una vida</label>
															<input type="number" value="<?php echo "$monedas";?>" 
                                                            min="1" max="500"
                                                            placeholder="  Precio" id="billing_precio_vida" 
                                                            name="billing_precio_vida" class="input-text " required>

                                                             <label class="" >Publicar coleccion</label>
                                                            <?php 
                                                            if($publicar == "no"){
                                                                echo '
                                                                <input type="radio" name="billing_publicar" value="si"> Publicar<br>
                                                                <input type="radio" name="billing_publicar" value="no" checked> No publicar
                                                                ';
                                                            }else{
                                                                echo '
                                                                <input type="radio" name="billing_publicar" value="si" checked> Publicar<br>
                                                                <input type="radio" name="billing_publicar" value="no"> No publicar
                                                                ';
                                                            }

                                                            ?>

                                                           
                                                            

															<br>
															<br>
															<label class="" >Selecciona una imagen para la colección</label>
															<input  type="file" id="billing_imagen" name="billing_imagen" size="1">



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
                                                
                                                <h2 align="center">¿Quieres exportar la coleccion a un documento PDF?</h2>
                                                <form action="exportarColeccion.php?nombreColeccion=<?php echo "$nombre";?>" 
                                                    method="post" enctype="multipart/form-data" class="checkout" name="checkout">
                                                    <p class="parrafo" ><input type="submit" value="exportar"></p>
                                                </form>
                                                
                                            </div>
											
-->

											<div role="tabpanel" class="tab-pane fade" id="eliminar">
                                                
                                                <h2 align="center">¿Estás seguro de eliminar esta colección?</h2>
                                                <form action="superEliminarColeccion.php?<?php echo "nombreColeccion=$nombre&usuario=$usuario";?>" 
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