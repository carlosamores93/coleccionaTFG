<?php
    if (!isset($_SESSION)){
        session_start();
        $page = $_SESSION["page"];
        $_SESSION["page"] = "verColeccion.php";
        //echo $_SESSION["super"];
    }

    if (!isset($_SESSION["coleccionTerminada"])) {
        header("Location: $page");
    }
    
    if (!$_SESSION["loginAlumno"]) {
        header("Location: $page");
    }


    function mostrarFichas(){

        $nombreColeccion = $_SESSION["coleccionTerminada"];
        $alumno = $_SESSION['usuario'];

        $link = conectarBBDD();
        // Añadir esta linea de codigo para poner acentos y ñ
        mysqli_query($link, "SET NAMES 'utf8'");


        $query="SELECT NumeroFichas
        FROM colecciones WHERE NombreColeccion = '$nombreColeccion' ";
        if ($result = mysqli_query($link, $query)) {
            // fetch associative array 
            while ($row = mysqli_fetch_assoc($result)) {
                $totalesFichas = $row["NumeroFichas"];
            }
            // free result set 
            mysqli_free_result($result);
        }else{
            echo "NADAAAAAAA";
        }



        $query="SELECT IdFicha, FotoFicha 
        FROM fichas 
        WHERE  NombreColeccion = '$nombreColeccion'
		ORDER BY NumeroFicha ASC, IdFicha ASC";
        $contador = 0;
        if ($result = mysqli_query($link, $query)) {
            // fetch associative array 
            while ($row = mysqli_fetch_assoc($result)) {
                $contador = $contador + 1;
                $idFicha = $row["IdFicha"];
                $fotoFicha = $row["FotoFicha"];

                $sql="SELECT NumeroFichas, IdFicha
                FROM mis_fichas 
                WHERE  IdFicha = '$idFicha' AND UsuarioAlumno = '$alumno'";

                if ($resultado = mysqli_query($link, $sql)){

                    //echo "yes ficha";
                    // Obtener cuantas fichas tenemos 
                    while ($row = mysqli_fetch_assoc($resultado)) {
                        $numeroFichas = $row["NumeroFichas"];
                        $idFicha = $row["IdFicha"];
                    }
                    // free result set 
                    mysqli_free_result($resultado);


                    echo '
                    <div class="single-product">';

                        echo '<div class="product-carousel-price" align="center">';
                            echo "<ins> $contador / $totalesFichas </ins>
                        </div> 
                        ";


                        echo '
                        <div class="product-f-image" id="product-f-image">
                        ';   
                            echo "<img class='imagenColeccion' src='$fotoFicha' alt=''>";
                            echo '
                            <div class="product-hover">';
                              echo "<a href='pasarFichaConseguida.php?idFicha=$idFicha' class='add-to-cart-link'>";
                                 echo '<i class="fa fa-eye" aria-hidden="true"></i>
                                    Ver ficha
                                </a>
                            </div>
                        </div>
                        ';
                        echo '<div class="product-carousel-price" align="center"><br>';
                            echo "<ins> Fichas: $numeroFichas </ins>
                        </div> 
                        ";

                    echo "                         
                    </div>
                    ";

                }                

            }
            // free result set 
            mysqli_free_result($result);
        }else{
            echo "NADAAAAAAA";
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
                   <br>		   
                </div>
            </div>
        </div>
    </div> <!-- End Page title area -->




<?php

    $nombreColeccion = $_SESSION["coleccionTerminada"];

    $alumno = $_SESSION['usuario'];

    $link = conectarBBDD();
    // Añadir esta linea de codigo para poner acentos y ñ
    mysqli_query($link, "SET NAMES 'utf8'");




    $query="SELECT Monedas, Vidas
    FROM juega_colecciones WHERE NombreColeccion = '$nombreColeccion' AND UsuarioAlumno = '$alumno' ";
    if ($result = mysqli_query($link, $query)) {
        // fetch associative array 
        while ($row = mysqli_fetch_assoc($result)) {
            $monedas = $row["Monedas"];
            $vidas = $row["Vidas"];
        }
        // free result set 
        mysqli_free_result($result);
    }else{
        echo "NADAAAAAAA";
    }


    $query="SELECT NombreColeccionCorrecto
    FROM colecciones WHERE NombreColeccion = '$nombreColeccion'";
    if ($result = mysqli_query($link, $query)) {
        // fetch associative array 
        while ($row = mysqli_fetch_assoc($result)) {
            $nombreColeccionCorrecto = $row["NombreColeccionCorrecto"];
        }
        // free result set 
        mysqli_free_result($result);
    }else{
        echo "NADAAAAAAA";
    }





    // Cerrar conexion con la bbdd
    mysqli_close($link);

?>




	<div class="single-product-area-juego">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <br>
                    <div class="single-sidebar">
							<a href="coleccionesTerminadas.php"><input type="submit" value="Volver"></a>							
                    </div>	
                </div>


                <div class="col-md-5">
                    <br>
                    <p align='center'>
                        <a href='pasarColeccionDescargar.php?nombreColeccion=<?php echo $nombreColeccion?>' target='_blank'>
                            <input type="submit" value="Exportar colección">
                        </a>
                    </p>
                </div>
                			
           		<div class="col-md-4">
					<div class="footer-card-icon">
						<div class="shopping-item-mio">
							<table cellspacing="0" >
								<tr class="cart_item">
									<td class="product-thumbnailmensaje">
										<img width="105" height="105" alt="poster_1_up" 
											class="shop_thumbnail" title="Mensaje" type="image" src="img/vidas.png">
									</td>
									<td class="product-thumbnailmensaje">
										<label>
                                            <?php echo "$vidas";?>&nbsp;&nbsp;&nbsp;
                                        </label>
									</td>

									<td class="product-thumbnailmensaje">
										<img width="105" height="105" alt="poster_1_up" 
											class="shop_thumbnail" title="Mensaje" type="image" src="img/moneditas.png">
									</td>
									<td class="product-thumbnailmensaje">
										<label>
                                            <?php echo "$monedas";?>&nbsp;&nbsp;&nbsp;
                                        </label>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				
				<div class="col-md-12">
                    <div class="latest-product">    
						<h1 class="related-products-title">
                            <strong>
                                <?php echo "$nombreColeccionCorrecto";?>
                            </strong>
                            
                        </h1>
                        <div class="product-carousel">
                            <?php
                                
                                mostrarFichas();
                                
                            ?> 

<!--
                            <div class="single-product">
                               <div class="product-f-image" id="product-f-image">
                                    <img class="imagenColeccion" src="img/images.jpg" alt="">
                                     <div class="product-hover">
										<a href="verFicha.php" class="add-to-cart-link">
											<i class="fa fa-eye" aria-hidden="true"></i> Ver ficha
										</a>
                                    </div>
                                </div>
                            </div>
-->


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