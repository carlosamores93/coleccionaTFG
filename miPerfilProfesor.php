<?php

    include_once("js/validarModificacionPerfil.js");

    if (!isset($_SESSION)){
        session_start();
        $page = $_SESSION["page"];
        $_SESSION["page"] = "miPerfilProfesor.php";
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

    $usuario = $_SESSION['usuario'];
    //echo "$usuario";
    $link = conectarBBDD();
    // Añadir esta linea de codigo para poner acentos y ñ
    mysqli_query($link, "SET NAMES 'utf8'");
	
    $query="SELECT NombreProfesor, ApellidosProfesor, FotoProfesor, CorreoProfesor FROM profesores
    WHERE UsuarioProfesor = '$usuario' ";
    if ($result = mysqli_query($link, $query)) {
        // fetch associative array 
        while ($row = mysqli_fetch_assoc($result)) {
            $nombre = $row["NombreProfesor"];
            $apellidos = $row["ApellidosProfesor"];
            $foto = $row["FotoProfesor"];
            $correo = $row["CorreoProfesor"];
        }

        // free result set 
        mysqli_free_result($result);
    }

    $query = "SELECT COUNT(*) AS numeroColecciones FROM colecciones 
    WHERE UsuarioProfesor='$usuario' ";
    if ($result = mysqli_query($link, $query)) {
        /* fetch associative array */
        while ($row = mysqli_fetch_assoc($result)) {
            $numeroColecciones = $row["numeroColecciones"];
        }
         /* free result set */
        mysqli_free_result($result);
    }
    
    
    // Cerrar conexion con la bbdd
    mysqli_close($link);

?>


	<div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2><strong><?php echo "$nombre $apellidos";?></strong></h2>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End Page title area -->
	
   
    <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                              
                <div class="col-md-11">
                    <div class="product-content-right">
                                               
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="product-images">
                                    <div class="product-main-img">
                                        <img src="<?php echo "$foto";?>" alt="">
                                    </div>
                                    
                                </div>
                            </div>
                            
							<div class="col-sm-6">
                                <div class="product-inner">
								
																 
                                    <div role="tabpanel">
                                        <ul class="product-tab" role="tablist">
                                            <li role="presentation" class="active"><a href="#detalles" aria-controls="home" role="tab" data-toggle="tab">Detalles</a></li>
                                            <li role="presentation"><a href="#modificar" aria-controls="profile" role="tab" data-toggle="tab">Modificar</a></li>
											<li role="presentation"><a href="#eliminar" aria-controls="hola" role="tab" data-toggle="tab">Eliminar</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane fade in active" id="detalles">
												
												<div class="product-inner-price">

                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <h3>Usuario</h3>
                                                            <font color="#5a88ca">
                                                                <label>
                                                                    <h4>
                                                                        <strong>
                                                                            <?php echo "$usuario";?>
                                                                        </strong>
                                                                    </h4>
                                                                </label>
                                                            </font>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <h3>Correo</h3>
                                                            <font color="#5a88ca">
                                                                <label>
                                                                    <h4>
                                                                        <strong>
                                                                            <?php echo "$correo";?>
                                                                        </strong>
                                                                    </h4>
                                                                </label>
                                                            </font>                                                        
                                                        </div>
                                                    </div>



                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <h3>Nombre</h3>
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
                                                            <h3>Apellidos</h3>
                                                            <font color="#5a88ca">
                                                                <label>
                                                                    <h4>
                                                                        <strong>
                                                                            <?php echo "$apellidos";?>
                                                                        </strong>
                                                                    </h4>
                                                                </label>
                                                            </font>                                                        
                                                        </div>
                                                    </div>



                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <h3>Colecciones creadas</h3>
                                                            <font color="#5a88ca">
                                                                <label>
                                                                    <h4>
                                                                        <strong>
                                                                            <?php echo "$numeroColecciones";?>
                                                                        </strong>
                                                                    </h4>
                                                                </label>
                                                            </font>
                                                        </div>
                                                    </div>
													
													
												</div>
												
																								
											</div>
                                            <div role="tabpanel" class="tab-pane fade" id="modificar">
                                                
												<form action="modificarProfesor.php" method="post" enctype="multipart/form-data" 
                                                class="checkout" name="checkout" onsubmit="return validarPerfil()">
													<div id="customer_details" class="col2-set">
														<div class="col-1">															
																														
															<label class="" >Nombre </label>
															<input type="text" value="<?php echo "$nombre";?>" 
                                                            placeholder="Nombre" id="billing_first_name" 
                                                            name="billing_first_name" class="input-text " required>

															<label class="" >Apellidos </label>
															<input type="text" value="<?php echo "$apellidos";?>" 
                                                            placeholder="Apellidos" id="billing_last_name" 
                                                            name="billing_last_name" class="input-text " required>
															
															<label class="" >Email</label>
															<input type="email" value="<?php echo "$correo";?>" 
                                                            placeholder="Correo electrónico" id="billing_email" name="billing_email" class="input-text " required>
															<br>
															
															<label class="" > Nueva Contraseña </label>
															<input type="password" value="" placeholder="Contraseña" 
                                                            id="billing_pass1" name="billing_pass1" class="input-text " required>
															<br>
														   
															<label class="" >Repite contraseña </label>
															<input type="password" value="" placeholder="Contraseña" 
                                                            id="billing_pass2" name="billing_pass2" class="input-text " required>
															<br>
														   
															<label class="" >Selecciona una imagen </label>
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
											<div role="tabpanel" class="tab-pane fade" id="eliminar" align="center">
                                                <h2>¿Estás seguro que quieres eliminar tu perfil?</h2>
												 <form action="eliminarProfesor.php" 
                                                    method="post" enctype="multipart/form-data" class="checkout" name="checkout">
                                                    <p><input type="submit" value="Sí, estoy seguro"></p>
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