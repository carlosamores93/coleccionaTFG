<?php

    include_once("js/validarUsuario.js");
    

    if (!isset($_SESSION)){
        session_start();
        $page = $_SESSION["page"];
        $_SESSION["page"] = "superRegistrarUsuario.php";
        //echo $_SESSION["super"];
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
                        <li><a href="inicioSuper.php"><i class="fa fa-home fa-fw" aria-hidden="true"></i>&nbsp;Inicio</a></li>
                        <li><a href="superListarProfesores.php">Profesores</a></li>
                        <li><a href="superListarAlumnos.php">Alumnos</a></li>
                        <li><a href="superListarColecciones.php">Colecciones</a></li>
                        <li class="active"><a href="superRegistrarUsuario.php">Nuevo usuario</a></li>
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
                        <h2><strong>Nuevo Usuario</strong></h2>
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
							<form action="registrarUsuario.php" method="post" onsubmit="return validarUsuario()"
                            enctype="multipart/form-data" class="checkout" name="checkout">
                                <div id="customer_details" class="col2-set">
									<div class="col-1">
										
										<label class="" >Tipo de usuario </label>
                                        
                                        <select id="billing_tipo" name="billing_tipo">
                                            <option value="Usuario"> Elija el tipo de usuario </option>
                                            <option value="Profesor"> Profesor </option>
                                            <option value="Alumno"> Alumno </option>
                                        </select>                                        

                                        <label class="" >Nombre </label>
                                        <input type="text" value="" placeholder="Nombre" 
                                        id="billing_first_name" name="billing_first_name" class="input-text " required>

                                        <label class="" >Apellidos </label>
                                        <input type="text" value="" placeholder="Apellidos" 
                                        id="billing_last_name" name="billing_last_name" class="input-text " required>

                                        <label class="" >Usuario</label>
                                        <input type="text" value="" placeholder="Usuario" 
                                        id="billing_user" name="billing_user" class="input-text " required>

                                        <label class="" >Email</label>
                                        <input type="email" value="" placeholder="Correo electrónico" 
                                        id="billing_email" name="billing_email" class="input-text " required>
                                        <br>
                                        
                                        <label class="" > Contraseña </label>
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
									<input type="submit" value="Registrarse" class="button">
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