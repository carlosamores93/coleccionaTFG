<?php

    if (!isset($_SESSION)){
        session_start();
        $page = $_SESSION["page"];

        if($page == "jugarJugar.php"){
            header("Location: restarVida.php");
        }

        $_SESSION["page"] = "jugarJugar.php";
        //echo $_SESSION["super"];
    }

    if (!isset($_SESSION["coleccionEmpezada"])) {
        header("Location: $page");
    }
    
    if (!$_SESSION["loginAlumno"]) {
        header("Location: $page");
    }




    include_once("conectar.php");

    // Sacar la pregunta y la ficha al azar.
    $nombreColeccion = $_SESSION["coleccionEmpezada"];

    $alumno = $_SESSION['usuario'];
    
    $link = conectarBBDD();
    // Añadir esta linea de codigo para poner acentos y ñ
    mysqli_query($link, "SET NAMES 'utf8'");


///////////////////////////////////////////////////////////////////////////////////////////////////////////
    $query="SELECT Vidas
    FROM juega_colecciones WHERE NombreColeccion = '$nombreColeccion' AND UsuarioAlumno = '$alumno' ";
    if ($result = mysqli_query($link, $query)) {
        // fetch associative array 
        while ($row = mysqli_fetch_assoc($result)) {
            $vidas = $row["Vidas"];
        }
        // free result set 
        mysqli_free_result($result);
    }else{
        echo "NADAAAAAAA";
    }
    // Cerrar conexion con la bbdd
    mysqli_close($link);
    if($vidas == 0){
        $_SESSION["page"] = "XXX.php";
        header("Location: coleccionJugar.php");
    }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    

    $link = conectarBBDD();
    // Añadir esta linea de codigo para poner acentos y ñ
    mysqli_query($link, "SET NAMES 'utf8'");


    $query="SELECT *
    FROM preguntas WHERE NombreColeccion = '$nombreColeccion'
    ORDER BY RAND() LIMIT 1 ";
    if ($result = mysqli_query($link, $query)) {
        // fetch associative array 
        while ($row = mysqli_fetch_assoc($result)) {
            $idPregunta = $row["IdPregunta"];
            $enunciado = $row["Enunciado"];
            $respuestaCorrecta = $row["RespuestaCorrecta"];
            $respuestaIncorrecta1 = $row["RespuestaIncorrecta1"];
            $respuestaIncorrecta2 = $row["RespuestaIncorrecta2"];
            $respuestaIncorrecta3 = $row["RespuestaIncorrecta3"];
            $tiempo = $row["Tiempo"];
            $dificultad = $row["DificultadPregunta"];
            $monedasGanar = $row["Monedas"];

        }
        // free result set 
        mysqli_free_result($result);
    }else{
        echo "NADAAAAAAA";
    }



    $query="SELECT *
    FROM fichas WHERE NombreColeccion = '$nombreColeccion' AND DificultadFicha = '$dificultad'
    ORDER BY RAND() LIMIT 1 ";
    if ($result = mysqli_query($link, $query)) {
        // fetch associative array 
        while ($row = mysqli_fetch_assoc($result)) {
            $idDeLaFicha = $row["IdFicha"];
            $fotoDeLaFicha = $row["FotoFicha"];
        }
        // free result set 
        mysqli_free_result($result);
    }else{
        echo "NADAAAAAAA de fichas";
    }


    //echo "idPREguinta=$enunciado";


    // Cerrar conexion con la bbdd
    mysqli_close($link);



    
?>



<script language="javascript"> 

    var url="http://www.colecciona.hol.es/restarVida.php?idPregunta=<?php echo "$idPregunta";?>&idFicha=<?php echo "$idDeLaFicha";?>";
    //var url="http://piloto.fis.ucm.es/colecciona/restarVida.php?idPregunta=<?php echo "$idPregunta";?>&idFicha=<?php echo "$idDeLaFicha";?>";
    function timer(){  
        var t=setTimeout("timer()",1000);  
        document.getElementById('contador').innerHTML ="<strong>"+i--+"</strong>"; 
        if (i==-1){
            clearTimeout(t);
            document.getElementById('contador').innerHTML = '<strong>Time out</strong>';
            //window.location.reload();
            window.location=url;
        }  
    }  
    i=<?php echo "$tiempo";?>; 
    
    
</script>

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








  <body onLoad="timer()">
   
    
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
                                    <td class="product-thumbnailmensaje">
                                        <label>
                                            Monedas a ganar: &nbsp;&nbsp;
                                        </label>
                                    </td>
                                    <td class="product-thumbnailmensaje">
                                        <img width="105" height="105" alt="poster_1_up" 
                                            class="shop_thumbnail" title="Monedas a ganar" type="image" src="img/coins.png">
                                    </td>
                                    <td class="product-thumbnailmensaje">
                                        <label>
                                            <?php echo "$monedasGanar";?>
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                        </label>
                                    </td>   
                                </tr>
                            </table>
                        </div>
                    </div>



                    
                </div>
								
				<div class="col-md-9">
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
									<td class="product-thumbnailmensaje">
										<img width="105" height="105" alt="poster_1_up" 
											class="shop_thumbnail" title="Tiempo" type="image" src="img/relojarena.png">
									</td>

									<td class="product-thumbnailmensaje">
										<font size=6 id="contador"></p>
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
								
										<form action="comprobarRespuesta.php?idPregunta=<?php echo "$idPregunta";?>&idFicha=<?php echo "$idDeLaFicha";?>" 
                                        method="post" enctype="multipart/form-data" class="checkout" name="checkout">
											<h3>
                                                <?php echo "$enunciado";?>
                                            </h3>
                                            <br>

                                            <?php
                                                include_once("jugarMostrarRespuestas.php");
                                            ?>
												
								        <!--													
											<input type="radio" value="<?php echo "$respuestaCorrecta";?>" name="billing_respuesta">
											<span style="color:blue;font-weight:bold">
                                                A) 
                                            </span>
											<span>
                                                <?php echo "$respuestaCorrecta";?>
                                            </span>
											<br><br>

                                            <input type="radio" value="<?php echo "$respuestaIncorrecta1";?>" name="billing_respuesta">
                                            <span style="color:blue;font-weight:bold">
                                                B) 
                                            </span>
                                            <span>
                                                <?php echo "$respuestaIncorrecta1";?>
                                            </span>
                                            <br><br>

                                            <input type="radio" value="<?php echo "$respuestaIncorrecta2";?>" name="billing_respuesta">
                                            <span style="color:blue;font-weight:bold">
                                                C) 
                                            </span>
                                            <span>
                                                <?php echo "$respuestaIncorrecta2";?>
                                            </span>
                                            <br><br>

                                            <input type="radio" value="<?php echo "$respuestaIncorrecta3";?>" name="billing_respuesta">
                                            <span style="color:blue;font-weight:bold">
                                                D) 
                                            </span>
                                            <span>
                                                <?php echo "$respuestaIncorrecta3";?>
                                            </span>
                                            <br><br>
                                        -->
												


											<div class="form-row place-order" align= "center"><br>
												<input type="submit" value="Aceptar" class="button">
											</div><br>
												
											
										</form>  
											
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
											         Ficha a ganar
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