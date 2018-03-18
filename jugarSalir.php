<?php


    if (!isset($_SESSION)){
        session_start();
        $page = $_SESSION["page"];
        if($page == "coleccionJugar.php"){
            header("Location: coleccionJugar.php");
        }

        $_SESSION["page"] = "jugarSalir.php";
        //echo $_SESSION["super"];
    }

    if (!isset($_SESSION["coleccionEmpezada"])) {
        header("Location: $page");
    }
    
    if (!$_SESSION["loginAlumno"]) {
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
                        <h1><a><img src="img/colecciona.png"></a></h1>
                    </div>
                </div>

				<?php
					require("usuarioAlumno.php");
				?>
				
            </div>
        </div>
    </div> <!-- End site branding area -->  

    
    <!--
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
    </div>
    -->
	
   <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
				
					<strong>
						<font color=yellow>* Se recomienda no usar los botones para salir o recargar del navegador</font>	  
					</strong>
                   
                </div>
            </div>
        </div>
    </div> <!-- End Page title area -->


<?php

    $nombreColeccion = $_SESSION["coleccionEmpezada"];
    $alumno = $_SESSION['usuario'];
    $link = conectarBBDD();
    // Añadir esta linea de codigo para poner acentos y ñ
    mysqli_query($link, "SET NAMES 'utf8'");


    $query="SELECT Monedas, Vidas, EstadoColeccion
    FROM juega_colecciones WHERE NombreColeccion = '$nombreColeccion' AND UsuarioAlumno = '$alumno' ";
    if ($result = mysqli_query($link, $query)) {
        // fetch associative array 
        while ($row = mysqli_fetch_assoc($result)) {
            $monedas = $row["Monedas"];
            $vidas = $row["Vidas"];
            $estadoColeccion = $row["EstadoColeccion"];
        }
        // free result set 
        mysqli_free_result($result);
    }else{
        echo "NADAAAAAAA";
    }

    // PAra obtener la pregunta y la ficha
    $idFicha = $_SESSION["idFicha"];
    $idPregunta = $_SESSION["idPregunta"];
    $respuesta = $_SESSION["respuesta"];



    $query="SELECT *
    FROM preguntas 
    WHERE IdPregunta = '$idPregunta' ";
    if ($result = mysqli_query($link, $query)) {
        // fetch associative array 
        while ($row = mysqli_fetch_assoc($result)) {
            $enunciado = $row["Enunciado"];
            $respuestaCorrecta = $row["RespuestaCorrecta"];
            $respuestaIncorrecta1 = $row["RespuestaIncorrecta1"];
            $respuestaIncorrecta2 = $row["RespuestaIncorrecta2"];
            $respuestaIncorrecta3 = $row["RespuestaIncorrecta3"];
        }
        // free result set 
        mysqli_free_result($result);
    }else{
        echo "NADAAAAAAA";
    }


    $query="SELECT MostrarRespuesta
    FROM colecciones WHERE NombreColeccion = '$nombreColeccion'";
    if ($result = mysqli_query($link, $query)) {
        // fetch associative array 
        while ($row = mysqli_fetch_assoc($result)) {
            $mostrarRespuesta = $row["MostrarRespuesta"];
        }
        // free result set 
        mysqli_free_result($result);
    }else{
        echo "NADAAAAAAA";
    }
    if($mostrarRespuesta == "NO"){
        $enunciado = "";
        $respuestaCorrecta = "";
        $respuestaIncorrecta1 = "";
        $respuestaIncorrecta2 = "";
        $respuestaIncorrecta3 = "";
    }



    $query="SELECT *
    FROM fichas WHERE IdFicha='$idFicha'";
    if ($result = mysqli_query($link, $query)) {
        // fetch associative array 
        while ($row = mysqli_fetch_assoc($result)) {
            $fotoDeLaFicha = $row["FotoFicha"];
        }
        // free result set 
        mysqli_free_result($result);
    }else{
        echo "NADAAAAAAA de fichas";
    }




    $query="SELECT NumeroFichas
    FROM colecciones WHERE NombreColeccion = '$nombreColeccion' ";
    if ($result = mysqli_query($link, $query)) {
        // fetch associative array 
        while ($row = mysqli_fetch_assoc($result)) {
            $totalesFichasColeccion = $row["NumeroFichas"];
        }
        // free result set 
        mysqli_free_result($result);
    }else{
        echo "NADAAAAAAA";
    }

    $query="SELECT FichasConseguidas
    FROM juega_colecciones WHERE NombreColeccion = '$nombreColeccion' AND UsuarioAlumno = '$alumno'";
    if ($result = mysqli_query($link, $query)) {
        // fetch associative array 
        while ($row = mysqli_fetch_assoc($result)) {
            $misFichasTotales = $row["FichasConseguidas"];
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
       
				
        <div class="container">
            <div class="row">

                <div class="col-md-3">
                    <div class="footer-card-icon">
                        <div class="shopping-item-mio">
                            <table cellspacing="0" >
                                <tr class="cart_item">

                                    <?php
                                        if($respuesta == "correcto"){
                                            echo "
                                            <td class='product-thumbnailmensaje'>
                                                <img width='105' height='105' alt='poster_1_up'
                                                    class='shop_thumbnail' title='Acierto' type='image' src='img/like.png'>
                                            </td>
                                            <td class='product-thumbnailmensaje'>
                                                <label>
                                                    &nbsp;&nbsp;&nbsp;Has acertado
                                                </label>
                                            </td>
                                            "  ;
                                        }else{
                                            echo "
                                            <td class='product-thumbnailmensaje'>
                                                <img width='105' height='105' alt='poster_1_up'
                                                    class='shop_thumbnail' title='Fallo' type='image' src='img/dislike.png'>
                                            </td>
                                            <td class='product-thumbnailmensaje'>
                                                <label>
                                                    &nbsp;&nbsp;&nbsp;Has fallado
                                                </label>
                                            </td>
                                            "  ;
                                        }
                                    ?>


<!--
                                    <td class="product-thumbnailmensaje">
                                        <label>
                                            Monedas a ganar: &nbsp;&nbsp;
                                        </label>
                                    </td>
                                    <td class="product-thumbnailmensaje">
                                        <img width="105" height="105" alt="poster_1_up" 
                                            class="shop_thumbnail" title="Monedas a ganar" type="image" src="img/coins.png">
                                    </td> 
-->

                                </tr>
                            </table>
                        </div>
                    </div>

                </div>


                <div class="col-md-5">
                    <br>
                    <h3 align='center'>
                        Fichas conseguidas: <?php echo $misFichasTotales;?> de <?php echo $totalesFichasColeccion;?>
                    </h3>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped active" 
                            role="progressbar" 
                            aria-valuemin="0" 
                            aria-valuemax='<?php echo $totalesFichasColeccion;?>' 
                            style="width:<?php echo $misFichasTotales/$totalesFichasColeccion*100;?>%">
                        <?php echo round($misFichasTotales/$totalesFichasColeccion*100);?>%
                        </div>
                    </div>
                </div>
								
				<div class="col-md-4">
					<div class="footer-card-icon">
						<div class="shopping-item-mio">
							<table cellspacing="0" >
								<tr class="cart_item">
									<td class="product-thumbnailmensaje">
										<img width="105" height="105" alt="poster_1_up" 
											class="shop_thumbnail" title="Mis Vidas" type="image" src="img/vidas.png">
									</td>
									<td class="product-thumbnailmensaje">
										<label>
                                            <?php echo "$vidas";?>
                                            &nbsp;&nbsp;&nbsp;
                                        </label>
									</td>

									<td class="product-thumbnailmensaje">
										<img width="105" height="105" alt="poster_1_up" 
											class="shop_thumbnail" title="Mis Monedas" type="image" src="img/moneditas.png">
									</td>
									<td class="product-thumbnailmensaje">
										<label>
                                            <?php echo "$monedas";?>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        </label>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				
                <div class="col-md-12">
                    <div class="product-content-right">
                                               
                        <div class="row">
                            <div class="col-sm-6">

                                <div class="product-images">
                                    <div align ="justify" class="product-main-test">
								
											<h3>
                                                <?php echo $enunciado;?>
                                            </h3>
                                            <br>
                                            <span style="color:blue;font-weight:bold">
                                                <?php echo $respuestaCorrecta;?>
                                            </span>
                                            <br><br>

                                            <span style="font-weight:bold">
                                                <?php echo $respuestaIncorrecta1;?>
                                            </span>
                                            <br><br>

                                            <span style="font-weight:bold">
                                                <?php echo $respuestaIncorrecta2;?>
                                            </span>
                                            <br><br>                                           
                                            <span style="font-weight:bold">
                                                <?php echo $respuestaIncorrecta3;?>
                                            </span>
                                           
                                            <br><br>
                                                
												
	
									

											<div class="form-row place-order" align= "center"><br>


                                                <?php
                                                    if($vidas == 0){
                                                        echo "
                                                        <a href='coleccionJugar.php'>
                                                            <input  type='submit' value='&nbsp;&nbsp;Salir&nbsp;&nbsp;'' class='button'>
                                                        </a>
                                                        ";
                                                    }else if($estadoColeccion == "terminada"){
                                                        echo "
                                                        <a href='coleccionesTerminadas.php'>
                                                            <input  type='submit' value='&nbsp;&nbsp;Salir&nbsp;&nbsp;'' class='button'>
                                                        </a>
                                                        ";
                                                    }else{
                                                        echo "

                                                        <a href='coleccionJugar.php'>
                                                            <input  type='submit' value='&nbsp;&nbsp;Salir&nbsp;&nbsp;' class='button'>
                                                        </a>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <a href='jugarJugar.php'>
                                                            <input  type='submit' value='Seguir' class='button'>
                                                        </a>
                                                        
                                                        ";
                                                    }

                                                ?>

                                                
                                                
											</div><br>
											
											
									</div>
						
                                </div>
                            </div>
                            
							<div class="col-sm-6">
                                <div class="product-inner">
								
									<!--<div class="footer-card-icon">
										<i class="fa fa-heart" aria-hidden="true"></i>&nbsp;5&nbsp;&nbsp;</i>
										<i class="fa fa-database" aria-hidden="true">&nbsp;200</i>
									</div>-->
									
									
											
                                    <div role="tabpanel">
                                        <ul class="product-tab" role="tablist">
                                            <li role="presentation" class="active">
                                                <a aria-controls="home" role="tab" data-toggle="tab">
                                                    <?php
                                                        if($respuesta == "correcto"){
                                                            echo "Ficha conseguida";
                                                        }else{
                                                            echo "Ficha NO conseguida";
                                                        }
                                                    ?>
                                                </a>
											</li>
                                          					
										</ul>
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane fade in active" id="ficha">
												
											<div class="product-images">
												<div align="center" class="product-main-imgFicha">
													<img class='imagenFicha' src="<?php echo "$fotoDeLaFicha";?>" alt="">
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