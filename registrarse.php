<?php

    include_once("js/validarAlumno.js");


    if (!isset($_SESSION)){
        session_start();
        if (isset($_SESSION["loginSuper"])) {
            $page = $_SESSION["page"];
            header("Location: $page");
        }
        if (isset($_SESSION["loginProfesor"])) {
            $page = $_SESSION["page"];
            header("Location: $page");
        }
        if (isset($_SESSION["loginAlumno"])) {
            $page = $_SESSION["page"];
            header("Location: $page");
        }
        $_SESSION["page"] = "registrarse.php";
    }


?>

<!DOCTYPE html>
<html>
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
                        <h1><a href="index.php"><img src="img/colecciona.png"></a></h1>
                    </div>
                </div>

                <div class="col-sm-6">
					 
						<div class="shopping-item">
							<a class="showlogin" data-toggle="collapse" href="#login-form-wrap" aria-expanded="false" aria-controls="login-form-wrap">
								<span class="cart-amunt"> Iniciar sesión </span>
							</a>
							<form action="iniciarSesion.php" enctype="multipart/form-data" method="post" id="login-form-wrap" class="login collapse">
								<p><input type="text" id="username" name="username" class="input-text" placeholder="Usuario" required></p>
								<input type="password" id="password" name="password" class="input-text" placeholder="Contraseña" required>
								<input type="submit" value="Login" name="login" class="button">
							</form>
						</div>
					
                </div>


            </div>
        </div>
    </div> <!-- End site branding area -->  
   
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
							<form action="registrarAlumno.php" method="post" onsubmit="return validarAlumno()"
                            enctype="multipart/form-data" >
								<div id="customer_details" class="col2-set">
									<div class="col-1">


                                        <h2 class="section-title"><span class="cart-amunt">Registrarse</span></h2>
                                        <label class="" >Nombre </label>
                                        <input type="text" value="" placeholder="Nombre" 
                                        id="billing_first_name" name="billing_first_name" class="input-text " required>

                                        <label class="" >Apellidos </label>
                                        <input type="text" value="" placeholder="Apellidos" id="billing_last_name" name="billing_last_name" class="input-text " required>

                                        <label class="" >Usuario</label>
                                        <input type="text" value="" placeholder="Usuario" 
                                        id="billing_user" name="billing_user" 
                                        title="Máximo 20 caracteres."
                                        maxlength="20" class="input-text " required>

                                        <label class="" >Email</label>
                                        <input type="email" value="" placeholder="Correo electrónico" id="billing_email" name="billing_email" class="input-text " required>
                                        <br>
                                        <br>
                                        <label class="" > Contraseña </label>
                                        <input type="password" value="" placeholder="Contraseña" id="billing_pass1" name="billing_pass1" class="input-text " required>
                                        <br>
                                        <br>
                                        <label class="" >Repite contraseña </label>
                                        <input type="password" value="" placeholder="Contraseña" id="billing_pass2" name="billing_pass2" class="input-text " required>
                                        <br>
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