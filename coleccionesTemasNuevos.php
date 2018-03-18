<?php
    if (!isset($_SESSION)){
        session_start();
        $page = $_SESSION["page"];
        $_SESSION["page"] = "coleccionesTemasNuevos.php";
       
    }

    
    if (!$_SESSION["loginAlumno"]) {
        header("Location: $page");
    }

	$tema = $_SESSION["tema"];
	
	function mostrarColeccionesNuevas() {

		$tema = $_SESSION["tema"];

        $link = conectarBBDD();
        // Añadir esta linea de codigo para poner acentos y ñ
        mysqli_query($link, "SET NAMES 'utf8'");
        
		$yoAlumno = $_SESSION["usuario"];
		
        /*
		$query="SELECT colecciones.NombreColeccion, colecciones.UsuarioProfesor, colecciones.TemaColeccion,
		colecciones.NombreColeccionCorrecto, colecciones.FotoColeccion 
		FROM colecciones 
		WHERE colecciones.NombreColeccion NOT IN 
        (SELECT juega_colecciones.NombreColeccion 
            FROM juega_colecciones 
                WHERE juega_colecciones.UsuarioAlumno = '$yoAlumno' ) 
        ORDER BY IdColeccion ASC";
        */
        /*
        $query="SELECT NombreColeccion, UsuarioProfesor, TemaColeccion,
        NombreColeccionCorrecto, FotoColeccion 
        FROM colecciones 
        WHERE Publicar = 'si' AND NombreColeccion NOT IN 
        (SELECT NombreColeccion FROM juega_colecciones 
            WHERE UsuarioAlumno = '$yoAlumno' ) 
        ORDER BY IdColeccion ASC";
        */


        // Aqui  mostrar los colecciones de los temas nuevos
      
            $query="SELECT NombreColeccion, UsuarioProfesor, TemaColeccion,
            NombreColeccionCorrecto, FotoColeccion 
            FROM colecciones 
            WHERE Publicar = 'si' AND NombreColeccion NOT IN 
            (SELECT NombreColeccion FROM juega_colecciones 
                WHERE UsuarioAlumno = '$yoAlumno' )
            AND (TemaColeccion LIKE '%$tema%')
            ORDER BY IdColeccion ASC";


        if ($result = mysqli_query($link, $query)) {

            // fetch associative array 
            while ($row = mysqli_fetch_assoc($result)) {
                $nombreCorrecto = $row["NombreColeccionCorrecto"];
                $foto = $row["FotoColeccion"];
				$nombreColeccion = $row["NombreColeccion"];
				$tema = $row["TemaColeccion"];
				$profesor = $row["UsuarioProfesor"];


                // Sacar el nombre y apellidos del profesor.
                $query="SELECT NombreProfesor, ApellidosProfesor FROM profesores WHERE UsuarioProfesor = '$profesor'";        
                if ($res = mysqli_query($link, $query)) {
                    // fetch associative array 
                    while ($row = mysqli_fetch_assoc($res)) {
                        $nombreProfesor = $row["NombreProfesor"];
                        $apellidosProfesor = $row["ApellidosProfesor"];
                    }
                    // free result set 
                    mysqli_free_result($res);
                }

				
				 echo '<div class="col-md-3 col-sm-6">
                   <div class="single-product" align="center">
						<div class="product-carousel-price">';
						echo "<ins>$tema</ins>";							
						echo '</div>
						<div class="product-f-image" id= "product-f-image">';
							echo "<img class='imagenColeccion' src='$foto' alt=''>
							<div class='product-hover'>
								<a class='add-to-cart-link' data-toggle='collapse' href='#$nombreColeccion' aria-expanded='false'>
									<i class='fa fa-hand-o-right' aria-hidden='true'></i>Empezar									
								</a>		
							</div>
						</div>
						<div class='zigzag-bottom'>";
						echo "<form action='comprobarJugar.php?nombreColeccion=$nombreColeccion&nombreProfesor=$profesor' enctype='multipart/form-data' method='post' id='$nombreColeccion' class='login collapse' align='center'>";
							echo '<div class="col-md-6">
								<input type="text" id="clave" name="clave" 
								maxlength="5" class="input-text" placeholder="Clave" 
								title="Maximo 5 caracteres."
								required>
								
							</div>
							<div class="col-md-6">
								<input type="submit" value="Validar" name="validar" class="button">
							</div>
						</form>		
						</div>';
						echo "<h2>$nombreCorrecto</h2>
						<div class='product-carousel-price'>
							<ins> $nombreProfesor $apellidosProfesor</ins>					
                        </div><br><br>                    
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
						<li><a href="misProfesores.php">Mis profesores</a></li> 
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
                        <h2><strong>Colecciones nuevas de <?php echo "$tema";?> </strong></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="single-product-area">
        <div class="zigzag-bottom"></div>

        <div class="container">

            <div class="row">

			
				 <?php
					mostrarColeccionesNuevas();
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