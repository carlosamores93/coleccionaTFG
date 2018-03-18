<?php

    include_once("js/validarColeccion.js");

    if (!isset($_SESSION)){
        session_start();
        $page = $_SESSION["page"];
        $_SESSION["page"] = "crearColeccion.php";
        //echo $_SESSION["super"];
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
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/estilo.css">

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
                        <li class="active"><a href="crearColeccion.php">Nueva Coleccion</a></li>
                    </ul>
                </div>  
            </div>
        </div>
    </div> <!-- End mainmenu area -->


    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2><strong>Nueva Colección</strong></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>


   
    <div class="maincontent-area">
        <div class="zigzag-bottom">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
					<div class="col-md-4">                  
					</div>
					<div class="col-md-8">
						<div class="product-content-right">
							<form action="registrarColeccion.php" method="post" enctype="multipart/form-data" onsubmit="return validarColeccion()"
                            class="checkout" name="checkout">
                                <div id="customer_details" class="col2-set">
									<div class="col-1">

                                        <label class="" >Nombre de la colección</label>
                                        <input type="text" value="" title="Nombre único para cada colección, como máximo 20 caracteres" 
                                        placeholder="Nombre" id="billing_nombre_coleccion" 
                                        name="billing_nombre_coleccion" 
                                        maxlength="20" class="input-text " required>

                                        <label class="" >Nombre de la colección correcto </label>
                                        <input type="text" value="" title="Este campo acepta ñ y acentos." 
                                        placeholder="Nombre correcto" id="billing_nombre2_coleccion" 
                                        name="billing_nombre2_coleccion" 
                                        maxlength="60" class="input-text " required>


                                        <label class="" >Tema de la coleccción </label>
                                        <input type="text" value="" placeholder="Tema" 
                                        id="billing_tema_coleccion" name="billing_tema_coleccion" 
                                        maxlength="60" class="input-text " required>

                                        

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label class="" >Clave de la coleccción </label>
                                                <input type="text" value="" placeholder="Clave, máximo 5 letras" 
                                                id="billing_clave" name="billing_clave" maxlength="5" class="input-text " required>
                                            </div>

                                            <div class="col-sm-6">
                                                <label class="" > Mostrar respuesta </label>
                                                <select id="billing_respuesta" name="billing_respuesta" required>
                                                    <option value=""> Mostrar respuesta correcta de la pregunta </option>
                                                    <option value="SI"> SI </option>
                                                    <option value="NO"> NO </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label class="" >Vidas iniciales</label>
                                                <input type="number" min="1" value="" placeholder="Vidas" 
                                                id="billing_vidas" name="billing_vidas" class="input-text " required>
                                            </div>

                                            <div class="col-sm-6">
                                                <label class="" >Precio de una vida</label>
                                                <input type="number" min="1" value="" placeholder="Monedas para conseguir una vida" 
                                                id="billing_precio_vida" name="billing_precio_vida" class="input-text " 
                                                title="Numero de monedas que equivalen a una vida" required>
                                            </div>
                                        </div>

                                        

                                        <div class="row">
                                            <div class="col-sm-12" align='center'>
                                                <label class="" >Precio de las fichas</label>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="" >Fáciles</label>
                                                <input type="number" min="1" value="" 
                                                title="Precio de las fichas fáciles" 
                                                id="billing_fichas_faciles" name="billing_fichas_faciles" 
                                                class="input-text " required>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="" >Medio</label>
                                                <input type="number" min="1" value=""
                                                title="Precio de las fichas de nivel medio"  
                                                id="billing_fichas_medio" name="billing_fichas_medio" 
                                                class="input-text " required>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="" >Difíciles</label>
                                                <input type="number" min="1" value=""
                                                title="Precio de las fichas difíciles"  
                                                id="billing_fichas_dificiles" name="billing_fichas_dificiles" 
                                                class="input-text " required>
                                            </div>
                                        </div>

                                        

                                        <label class="" >Selecciona una imagen para la colección</label>
                                        <input  type="file" id="billing_imagen" name="billing_imagen" size="1">

                                        <br>
                                        <label class="" >Selecciona el PDF FINAL de la colección</label>
                                        <input  type="file" id="billing_imagen_pdf" name="billing_imagen_pdf" size="1">

									</div>
								</div>
								<br>
                                <br>
								<div class="form-row place-order">
									<input type="submit" value="Crear coleccion" class="button">
                                    <input type="reset" value="Borrar todo" class="button"> 	
								</div>
							</form>                    
						</div>                    
					</div>
                </div>
            </div>
        </div>
    </div> <!-- End main content area -->
       
	
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