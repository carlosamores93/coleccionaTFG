<?php
    if (!isset($_SESSION)){
        session_start();
        $page = $_SESSION["page"];
        $_SESSION["page"] = "misProfesores.php";
        //echo $_SESSION["super"];
    }

    
    if (!$_SESSION["loginAlumno"]) {
        header("Location: $page");
    }
	
	function mostrarMisProfesores() {

		$yoAlumno = $_SESSION["usuario"];
		
        $link = conectarBBDD();
        // Añadir esta linea de codigo para poner acentos y ñ
        mysqli_query($link, "SET NAMES 'utf8'");
        
		$query="SELECT profesores.UsuarioProfesor, profesores.NombreProfesor, profesores.ApellidosProfesor, profesores.FotoProfesor
		FROM profesores
		WHERE profesores.UsuarioProfesor IN 
        (SELECT mis_alumnos.UsuarioProfesor FROM mis_alumnos 
            WHERE mis_alumnos.UsuarioAlumno = '$yoAlumno' AND mis_alumnos.PuedeJugar='si') 
			
        ORDER BY profesores.NombreProfesor ASC";		
     


        if ($result = mysqli_query($link, $query)) {

            // fetch associative array 
            while ($row = mysqli_fetch_assoc($result)) {
                $profesor = $row["UsuarioProfesor"];
                $foto = $row["FotoProfesor"];
				$nombre = $row["NombreProfesor"];
				$apellidos = $row["ApellidosProfesor"];
				
				
				 echo '
                <div class="col-md-3 col-sm-6">
                    <div class="single-shop-product">
                        <div class="product-upper">';                    
                                echo "<img class='imagenUsuario' src='$foto' alt=''>                           
                        </div>";
                        echo "<h2>$nombre </h2> <h2>$apellidos</h2><br><br>             
                    </div>
                </div>";


            }

            // free result set 
            mysqli_free_result($result);
        }

        // Cerrar conexion con la bbdd
        mysqli_close($link);
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
                        <h1><a href="inicioAlumno.php"><img src="img/colecciona.png"></a></h1>
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
                        <li><a href="inicioAlumno.php"><i class="fa fa-home fa-fw" aria-hidden="true"></i>&nbsp;Inicio</a></li>
                        <li><a href="coleccionesNuevas.php">Nuevas</a></li>
						<li><a href="coleccionesEmpezadas.php">Empezadas</a></li>                        
                        <li><a href="coleccionesTerminadas.php">Terminadas</a></li>  
						<li class="active"><a href="misProfesores.php">Mis profesores</a></li> 
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
                        <h2><strong>Mis profesores</strong></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="single-product-area">
        <div class="zigzag-bottom"></div>

        <div class="container">

            <div class="single-sidebar2">
                <form action="" method="post" enctype="multipart/form-data">
                    <label class="" >Buscar profesores </label>
                    <input type="search"  placeholder="" name="billing_tipo_search" >
                    <select id="billing_tipo" name="billing_tipo">
                        <option value=""> Filtrar por... </option>
                        <option value="Nombre"> Nombre </option>
                        <option value="Apellido"> Apellido </option>
                    </select> 
                    <input type="submit" value="Buscar">
                </form>
            </div>

            <br>
            <div class="row">

			
				 <?php
					mostrarMisProfesores();
				?>
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