<?php
    if (!isset($_SESSION)){
        session_start();
        $page = $_SESSION["page"];
        $_SESSION["page"] = "verFicha.php";
        //echo $_SESSION["super"];
    }

    if (!isset($_SESSION["fichaConseguida"])) {
        header("Location: $page");
    }
    
    if (!$_SESSION["loginAlumno"]) {
        header("Location: $page");
    }

     function mostrarDetallesFicha(){

        $idFicha = $_SESSION["fichaConseguida"];
		$nombreColeccion = $_SESSION["coleccionTerminada"];
        

        $link = conectarBBDD();
        // Añadir esta linea de codigo para poner acentos y ñ
        mysqli_query($link, "SET NAMES 'utf8'");
		
		$query="SELECT NumeroFicha
        FROM fichas 
		WHERE IdFicha = $idFicha"; 
		 if ($result = mysqli_query($link, $query)) {
            // fetch associative array 
            while ($row = mysqli_fetch_assoc($result)) {
                $numeroFicha = $row["NumeroFicha"];
                
            }
            // free result set 
            mysqli_free_result($result);
        }
		
		
		
		$query="SELECT IdFicha
        FROM fichas 
		WHERE (NombreColeccion = '$nombreColeccion') AND NumeroFicha = (SELECT MIN(NumeroFicha) 
		FROM fichas 
		WHERE NumeroFicha > $numeroFicha)
		ORDER BY IdFicha";
		
		$siguiente = "";
        if ($result = mysqli_query($link, $query)) {
            // fetch associative array 
            while ($row = mysqli_fetch_assoc($result)) {
                $siguiente = $row["IdFicha"];
                
            }
            // free result set 
            mysqli_free_result($result);
        }
		
		
		$query="SELECT IdFicha
        FROM fichas 
		WHERE (NombreColeccion = '$nombreColeccion') AND NumeroFicha = (SELECT MAX(NumeroFicha) 
		FROM fichas 
		WHERE NumeroFicha < $numeroFicha)
		ORDER BY IdFicha DESC";
		
		$anterior= "";
		
        if ($result = mysqli_query($link, $query)) {
            // fetch associative array 
            while ($row = mysqli_fetch_assoc($result)) {
                $anterior = $row["IdFicha"];
                
            }
            // free result set 
            mysqli_free_result($result);
        }
		
		
        $query="SELECT DificultadFicha, FotoFicha, Descripcion
        FROM fichas WHERE IdFicha = '$idFicha' ";
        if ($result = mysqli_query($link, $query)) {
            // fetch associative array 
            while ($row = mysqli_fetch_assoc($result)) {
                $dificultad = $row["DificultadFicha"];
                $foto = $row["FotoFicha"];
                $descripcion = $row["Descripcion"];
            }
            // free result set 
            mysqli_free_result($result);
        }

        echo '
         <div class="col-sm-6">
			
           <div class="product-images">
			
               <div class="product-main-img">';
                   echo " <img src='$foto' alt=''> <br><br>";	
				   
				echo '	<div class="form-row place-order">';
				
				   
				if ($anterior!= ""){
					echo "		<a href='pasarFichaConseguida.php?idFicha=$anterior'>";
					echo '			<input type="submit" value="Anterior" class="button">
								</a>';
				}
				
				if ($siguiente!= ""){
					echo "		<a href='pasarFichaConseguida.php?idFicha=$siguiente'>";
					echo'			<input type="submit" value="Siguiente" class="button">
								</a>
								<br>';
				}
				
				 echo '	</div>
					
               </div>
    
            </div>
        </div>

                            
        <div class="col-sm-6">
            <div class="product-inner">
            
                                             
                <div role="tabpanel">
                    <ul class="product-tab" role="tablist">
                        <li role="presentation" class="active"><a href="#detalles" aria-controls="home" role="tab" data-toggle="tab">Ficha</a></li>                                                                                     
                    </ul>
                    
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active" id="detalles">
                        
                        <h2>Información de la ficha</h2>'; 
						
							echo " <p align = 'justify'>
                            <strong>
                            Orden: $numeroFicha
                            </strong>
                            </p>";
							
                            echo " <p align = 'justify'>
                            <strong>
                            Dificultad: $dificultad
                            </strong>
                            </p> <br>";
                           echo " <p align = 'justify'>$descripcion</p>";
                        
                      echo ' </div>                                                                                  
                   
                    </div>
                </div>
                
            </div>
        </div>';

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
                        <li><a href="coleccionesEmpezadas.php">Empezadas</a></li>
                        <li><a href="coleccionesNuevas.php">Nuevas</a></li>
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
                   <br>		   
                </div>
            </div>
        </div>
    </div> <!-- End Page title area -->

	<div class="single-product-area-juego">
        <div class="zigzag-bottom">
		
		</div>
		
        <div class="container">
            <div class="row">
				
				<div class="col-md-12">
                    <div class="single-sidebar">
                       
							<a href="javascript:history.back(-1);"><input type="submit" value="Volver"></a>							
                    
                    </div>	
                </div>
				
				
                <div class="col-md-11">
                    <div class="product-content-right">
                                               
                        <div class="row">

                              <?php
                                
                                    mostrarDetallesFicha();
                                    
                                ?> 
                          
							
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