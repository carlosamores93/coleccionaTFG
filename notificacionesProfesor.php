<?php
    if (!isset($_SESSION)){
        session_start();
        $page = $_SESSION["page"];
        $_SESSION["page"] = "notificacionesProfesor.php";
        //echo $_SESSION["super"];
    }

    
    if (!$_SESSION["loginProfesor"]) {
        header("Location: $page");
    }
	
	include_once("conectar.php");
    $link = conectarBBDD();
    // Añadir esta linea de codigo para poner acentos y ñ
    mysqli_query($link, "SET NAMES 'utf8'");
	
	
	function mostrarNotificaciones() {

		$usuario = $_SESSION["usuario"];
		
		$link = conectarBBDD();
		
		// Añadir esta linea de codigo para poner acentos y ñ
		mysqli_query($link, "SET NAMES 'utf8'");
        
        $query="SELECT UsuarioAlumno, PuedeJugar, Visto FROM mis_alumnos
        WHERE UsuarioProfesor = '$usuario'
		ORDER BY IdPosicion DESC";
		
		$texto = "quiere jugar tus colecciones";
        if ($result = mysqli_query($link, $query)) {

            // fetch associative array 
            while ($row = mysqli_fetch_assoc($result)) {            
				$user = $row["UsuarioAlumno"];
				$visto = $row["Visto"];
				
				if ($visto == "no"){
					
					echo " <li><h4><strong><a href='activarVistoAlumno.php?usuario=$user'>$user &nbsp;&nbsp;&nbsp;&nbsp; $texto</a></strong></h4></li>";				
            
				}else{
					
					echo " <li><a href='pasarAlumno.php?usuario=$user'>$user &nbsp;&nbsp;&nbsp;&nbsp; $texto</a></li>";				
            
				}
			
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




     <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                  <br>
                </div>
            </div>
        </div>
    </div>


   
    <div class="single-product-area">
        
        <div class="container">
            <div class="row">
			
				<div class="col-md-4">
					<div class="single-sidebar">
						<form action="listarAlumnos.php" method="post" enctype="multipart/form-data" >
							<label class="" >Buscar alumnos </label><br>
							<input type="search"  placeholder="" name="billing_tipo_search" >
							<input type="hidden"  placeholder="" name="billing_tipo" value="" >
							
							<input type="submit" value="Buscar">
						</form>
					</div>


				<br>
					
					
               
                </div>				
				
				
                <div class="col-md-8">
				
					<h2 class="sidebar-title">Notificaciones de tus alumnos</h2>
                    <div class="single-sidebar" style="width:100%; height:400px; overflow-y: scroll;">
                       
                        <ul>     
							
							<?php
								mostrarNotificaciones();
							?> 
                            
                        </ul>
                    </div>	
					
                </div>
                
            </div>
        </div>
    </div><!-- End main content area -->
       
	
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
	
	  <!-- Gráficos -->
	<script src="Highcharts-4.1.5/js/highcharts.js"></script>
	<script src="Highcharts-4.1.5/js/highcharts-3d.js"></script>
	<script src="Highcharts-4.1.5/js/modules/exporting.js"></script>
	
  </body>
</html>