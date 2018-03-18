<?php
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
        $_SESSION["page"] = "noLogin.php";
    }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="icon" href="img/icono.png">
    <title>Colecciona</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
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
							<p>
								<input type="text" id="username" name="username" class="input-text" placeholder="Usuario" required>
							</p>
							<input type="password" id="password" name="password" class="input-text" placeholder="Contraseña" required>
							<input type="submit" value="Login" name="login" class="button">
						</form>
					</div>
	
					<a href="registrarse.php">
						<div class="shopping-item">
							<span class="cart-amunt">Registrarse</span>
						</div>
					</a>

                </div>


            </div>
        </div>
    </div> <!-- End site branding area -->


    <br>
    <br>
    <br>
    <div class="maincontent-area">
        <div class="zigzag-bottom">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <br>
                    <br>
                    <br>
                    <br>
                    <h3 class="section-title">
                        <span class="cart-amunt">
                        Error al meter el usuario o constraseña.
                        </span>
                    </h3> 
                    <br>
                    <br>
                    <br>
                    <br>
                           
                </div>
            </div>
        </div>
    </div> <!-- End main content area -->

    <br>
    <br>
    <br>
    <br>

    

    
    <?php
        require("footerVisitas.php");
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