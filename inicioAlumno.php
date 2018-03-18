<?php
    

    if (!isset($_SESSION)){
        session_start();
        $page = $_SESSION["page"];
        $_SESSION["page"] = "inicioAlumno.php";
        //echo $_SESSION["super"];
    }

    
    if (!$_SESSION["loginAlumno"]) {
        header("Location: $page");
    }
	
    include_once("actualizarAlumno.php");
	
	function mostrarColeccionesNuevas() {

        $link = conectarBBDD();
        // Añadir esta linea de codigo para poner acentos y ñ
        mysqli_query($link, "SET NAMES 'utf8'");
        
        
       $yoAlumno = $_SESSION["usuario"];
	   
	    $query = "SELECT COUNT(*) AS numJuego FROM juega_colecciones WHERE UsuarioAlumno='$yoAlumno' AND EstadoColeccion='juego'";
		if ($result = mysqli_query($link, $query)) {
			/* fetch associative array */
			while ($row = mysqli_fetch_assoc($result)) {
				$numJuego = $row["numJuego"];
				
			}
			
			
			/* free result set */
			mysqli_free_result($result);
			
			
			$query="SELECT COUNT(*) AS numNuevas  
                FROM colecciones 
                WHERE Publicar = 'si' AND NombreColeccion NOT IN 
                (SELECT NombreColeccion FROM juega_colecciones 
                    WHERE UsuarioAlumno = '$yoAlumno' ) 
                ORDER BY IdColeccion ASC";  
				
				if ($result = mysqli_query($link, $query)) {
				/* fetch associative array */
				while ($row = mysqli_fetch_assoc($result)) {
					$numNuevas = $row["numNuevas"];
					
				}
					/* free result set */
					mysqli_free_result($result);
				}
			
			
				$query="SELECT NombreColeccion, UsuarioProfesor, TemaColeccion,
                NombreColeccionCorrecto, FotoColeccion 
                FROM colecciones 
                WHERE Publicar = 'si' AND NombreColeccion NOT IN 
                (SELECT NombreColeccion FROM juega_colecciones 
                    WHERE UsuarioAlumno = '$yoAlumno' ) 
                ORDER BY IdColeccion ASC";  
			
			if ($numJuego > 0 && $numNuevas < 3){
				
				
				if ($result = mysqli_query($link, $query)) {

					// fetch associative array 
					while ($row = mysqli_fetch_assoc($result)) {
						$nombreCorrecto = $row["NombreColeccionCorrecto"];
						$foto = $row["FotoColeccion"];
						$nombreColeccion = $row["NombreColeccion"];
						$tema = $row["TemaColeccion"];
						$profesor = $row["UsuarioProfesor"];
						
						
						 echo '<div class="single-product">
							<div class="product-f-image" id="product-f-image">';
								echo"<img class='imagenColeccion' src='$foto' alt=''>
								<div class='product-hover'>
									<a class='add-to-cart-link' data-toggle='collapse' href='#$nombreColeccion' aria-expanded='false'>
										<i class='fa fa-hand-o-right' aria-hidden='true'></i>Empezar                                    
									</a>        
								</div>
							</div>";
							
							echo '<div class="zigzag-bottom">';
								echo "<form action='comprobarJugar.php?nombreColeccion=$nombreColeccion&nombreProfesor=$profesor' enctype='multipart/form-data' method='post' id='$nombreColeccion' class='login collapse' align='center'>";
									echo '<div class="col-md-6">
										<input type="text" id="clave" name="clave" maxlength="5" title="Maximo 5 caracteres" class="input-text" placeholder="Clave" required>
									</div>
									<div class="col-md-6">
										<input type="submit" value="Validar" name="validar" class="button">
									</div>
								</form>     
							</div>';
							
						   echo " <h2 align='center'>  $nombreCorrecto </h2>
							<div align='center' class='product-carousel-price'>
								<ins>$tema</ins>
							</div>                            
						</div>";

					}

					// free result set 
					mysqli_free_result($result);
				}

				// Cerrar conexion con la bbdd
				mysqli_close($link);
				
				
			}else {
				
			if ($result = mysqli_query($link, $query)) {

					// fetch associative array 
					while ($row = mysqli_fetch_assoc($result)) {
						$nombreCorrecto = $row["NombreColeccionCorrecto"];
						$foto = $row["FotoColeccion"];
						$nombreColeccion = $row["NombreColeccion"];
						$tema = $row["TemaColeccion"];
						$profesor = $row["UsuarioProfesor"];
						
					
						 echo '<div class="single-product">
							<div class="product-f-image" id="product-f-image">';
								echo"<img class='imagenColeccion' src='$foto' alt=''>
								<div class='product-hover'>
									<a href='coleccionesNuevas.php' class='add-to-cart-link'>
										<i class='fa fa-hand-o-right' aria-hidden='true'></i>Empezar                                    
									</a>        
								</div>
							</div>";				
										
						   echo " <h2 align='center'>  $nombreCorrecto </h2>
							<div align='center' class='product-carousel-price'>
								<ins>$tema</ins>
							</div>                            
						</div>";

					}

					// free result set 
					mysqli_free_result($result);
				}

				// Cerrar conexion con la bbdd
				mysqli_close($link);
				
				
			}
		}
        
       

    }

	function mostrarColeccionesEmpezadas() {

        $yoAlumno = $_SESSION["usuario"];
		
        $link = conectarBBDD();
        // Añadir esta linea de codigo para poner acentos y ñ
        mysqli_query($link, "SET NAMES 'utf8'");
        
        $query="SELECT colecciones.UsuarioProfesor, colecciones.TemaColeccion,
		colecciones.NombreColeccionCorrecto, colecciones.FotoColeccion, colecciones.NombreColeccion 
		FROM colecciones, juega_colecciones
		WHERE colecciones.NombreColeccion = juega_colecciones.nombreColeccion 
		AND juega_colecciones.UsuarioAlumno = '$yoAlumno' AND  juega_colecciones.EstadoColeccion = 'juego'
        ORDER BY IdColeccion ASC";

		
		

        if ($result = mysqli_query($link, $query)) {
            // fetch associative array 
            while ($row = mysqli_fetch_assoc($result)) {
                $nombreCorrecto = $row["NombreColeccionCorrecto"];
                $foto = $row["FotoColeccion"];
				$tema = $row["TemaColeccion"];
                $nombreColeccion = $row["NombreColeccion"];
			   
							   
				 echo '
                <div class="single-product">
					<div class="product-f-image" id= "product-f-image">';
					
				echo"
                        <img class='imagenColeccion' src='$foto' alt=''>
						<div class='product-hover'>
							<a href='pasarColeccionEmpezada.php?nombreColeccion=$nombreColeccion' class='add-to-cart-link'>
								<i class='fa fa-play' aria-hidden='true'>
                                </i> 
								Continuar
							</a>
						</div>
					</div>
                    <h2 align='center'> 
                        $nombreCorrecto 
                    </h2>
					<div align='center' class='product-carousel-price'>
						<ins> $tema </ins>
					</div> 

				</div>
                
                ";   
                                
            }

            // free result set 
            mysqli_free_result($result);
        }else{
			echo "NADAAAAA";
			die();
			 echo '
                <div class="single-product">
					<div class="product-f-image" id= "product-f-image">';
					
				echo"
                        <img class='imagenColeccion' src='img/coleccionIcono.png' alt=''>
						<div class='product-hover'>
							
						</div>
					</div>
                    <h2 align='center'> 
                        Todas tus coleciones
                    </h2>
					<div align='center' class='product-carousel-price'>
						<ins> que mas ve </ins>
					</div> 

				</div>
                
                ";   
			
		}               
			

			//echo "No hay colecciones";
        // Cerrar conexion con la bbdd
        mysqli_close($link);
    }
	
	
	function mostrarTemas() {

        $link = conectarBBDD();
        // Añadir esta linea de codigo para poner acentos y ñ
        mysqli_query($link, "SET NAMES 'utf8'");
        
        $query="SELECT  DISTINCT TemaColeccion FROM colecciones
        WHERE Publicar = 'si' ORDER BY IdColeccion DESC
		LIMIT 0,4";


        if ($result = mysqli_query($link, $query)) {

            // fetch associative array 
            while ($row = mysqli_fetch_assoc($result)) {            
				$tema = $row["TemaColeccion"];
				
					echo "<li>$tema</li>";				
				
            }

            // free result set 
            mysqli_free_result($result);
        }

        // Cerrar conexion con la bbdd
        mysqli_close($link);
    }

	function mostrarRanking() {

        $link = conectarBBDD();
        // Añadir esta linea de codigo para poner acentos y ñ
        mysqli_query($link, "SET NAMES 'utf8'");
        
        $query="SELECT  UsuarioAlumno, NumeroFichas, FotoAlumno 
        FROM alumnos
	    ORDER BY NumeroFichas DESC, PreguntasAcertadas DESC
		LIMIT 0,5";


        if ($result = mysqli_query($link, $query)) {

            // fetch associative array 
            while ($row = mysqli_fetch_assoc($result)) {            
				$nick = $row["UsuarioAlumno"];
				$numeroFichas = $row["NumeroFichas"];
				$foto = $row["FotoAlumno"];
					
				echo "<div class='thubmnail-recent'>
					<img src='$foto' class='recent-thumb-ranking' alt=''>
					<h2><a >$nick</a></h2>
					<div class='product-sidebar-price'>
						<ins>$numeroFichas</ins>
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
                        <li class="active" ><a href="inicioAlumno.php"><i class="fa fa-home fa-fw" aria-hidden="true"></i>&nbsp;Inicio</a></li>                      
                        <li><a href="coleccionesNuevas.php">Nuevas</a></li>
						<li><a href="coleccionesEmpezadas.php">Empezadas</a></li>
                        <li><a href="coleccionesTerminadas.php">Terminadas</a></li>  
						<li><a href="misProfesores.php">Mis profesores</a></li>  
                    </ul>
                </div>  
            </div>
        </div>
    </div> <!-- End mainmenu area -->

	<?php

    $usuario = $_SESSION["usuario"];
    //echo "$usuario";
    $link = conectarBBDD();
    // Añadir esta linea de codigo para poner acentos y ñ
    mysqli_query($link, "SET NAMES 'utf8'");


    $query="SELECT NombreAlumno FROM alumnos
    WHERE UsuarioAlumno = '$usuario' ";
    if ($result = mysqli_query($link, $query)) {
        // fetch associative array 
        while ($row = mysqli_fetch_assoc($result)) {
            $nombre = $row["NombreAlumno"];
        }
        // free result set 
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
                        <h2><strong>Bienvenido <?php echo "$nombre";?></strong></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
					
                    <div class="single-sidebar">
                        <h2 class="sidebar-title">Ultimos Temas</h2>
                        <ul class="temas">
						
						<?php
							mostrarTemas();
						?>                          
						<li><a href='listarTemas.php' >Ver todos</a></li>
			
                        </ul>
						
                    </div>
					
					<h2 class="sidebar-title"><i class="fa fa-trophy" aria-hidden="true"></i>&nbsp;Ranking</h2>
					<div class="single-sidebar" style="width:100%; height:400px; overflow-y: scroll;">
                        
						<?php
							mostrarRanking();
						?>   
						                                                
                    </div>
					
                </div>
                
                <div class="col-md-9">
				
                    <div class="product-content-right">  

							
						<div class="related-products-wrapper">
                            <h2 class="related-products-title">Mis colecciones</h2>
                            <div class="related-products-carousel">
										   
								<?php
								mostrarColeccionesEmpezadas();
											
								?>
						
							</div>
						</div>
						
						<div class="related-products-wrapper">
                            <h2 class="related-products-title">Nuevas colecciones</h2>
                            <div class="related-products-carousel">
                               
                                <?php
									 mostrarColeccionesNuevas();                                
								?>
								  
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