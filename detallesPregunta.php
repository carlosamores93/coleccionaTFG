<?php
    
    include_once("js/validarPregunta.js");

    if (!isset($_SESSION)){
        session_start();
        $page = $_SESSION["page"];
        $_SESSION["page"] = "detallesPregunta.php";
        //echo $_SESSION["super"];
    }

    if ((!isset($_SESSION['coleccion'])) || (!isset($_SESSION['pregunta'])) ) {
        header("Location: $page");
    }

    
    if (!$_SESSION["loginProfesor"]) {
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


<?php

    $nombreColeccion = $_SESSION["coleccion"];
    $idPregunta = $_SESSION["pregunta"];


    $link = conectarBBDD();
    // Añadir esta linea de codigo para poner acentos y ñ
    mysqli_query($link, "SET NAMES 'utf8'");



    $query="SELECT DificultadPregunta,
    Tiempo, Monedas, Enunciado, RespuestaCorrecta, RespuestaIncorrecta1,
    RespuestaIncorrecta2, RespuestaIncorrecta3, 
    Frecuencia, Fallos, Aciertos
    FROM preguntas WHERE IdPregunta = '$idPregunta' ";
    if ($result = mysqli_query($link, $query)) {
        // fetch associative array 
        while ($row = mysqli_fetch_assoc($result)) {
            $enunciado = $row["Enunciado"];
            $correcta = $row["RespuestaCorrecta"];
            $incorrecta1 = $row["RespuestaIncorrecta1"];
            $incorrecta2 = $row["RespuestaIncorrecta2"];
            $incorrecta3 = $row["RespuestaIncorrecta3"];
            $dificultad = $row["DificultadPregunta"];
            $tiempo = $row["Tiempo"];
            $monedas = $row["Monedas"];
            $frecuencia = $row["Frecuencia"];
            $fallos = $row["Fallos"];
            $aciertos = $row["Aciertos"];
        }

        // free result set 
        mysqli_free_result($result);
    }


    $query = "SELECT NombreColeccionCorrecto FROM colecciones WHERE NombreColeccion = '$nombreColeccion' ";
    if ($result = mysqli_query($link, $query)) {
        // fetch associative array 
        while ($row = mysqli_fetch_assoc($result)) {
            $nombreCorrecto = $row["NombreColeccionCorrecto"];
        }
        // free result set 
        mysqli_free_result($result);
    }else{
        echo "$nombre";
    }


    // Cerrar conexion con la bbdd
    mysqli_close($link);

?>


	<div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2>
                            <strong>Pregunta de 
                                <a class="coleccion" 
                                href="detallesColeccion.php"> 
                                <?php echo "$nombreCorrecto";?> 
                                </a> 
                            </strong>
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End Page title area -->
	
   
    <div class="single-product-area">
        <div class="zigzag-bottom">
		
		</div>
		
        <div class="container">
            <div class="row">
			
                <div class="col-md-11">
                    <div class="product-content-right">
                                               
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="product-images">
                                    <div align ="justify" class="product-main-test">
									 
											
												<div>
													<h3><?php echo "$enunciado";?></h3>
                                                    <br>


													<span style="color:blue;font-weight:bold">A) </span>
													<span><?php echo "$correcta";?></span>
													<br><br>
													
													
													<span style="color:blue;font-weight:bold">B) </span>
													<span><?php echo "$incorrecta1";?></span>
													<br><br>
													
													
													<span style="color:blue;font-weight:bold">C) </span>
													<span><?php echo "$incorrecta2";?></span>
													<br><br>
													
													
													<span style="color:blue;font-weight:bold">D) </span>
													<span><?php echo "$incorrecta3";?></span>
													<br><br>
													
												</div>
										</div>
						
                                </div>
                            </div>
                            
							<div class="col-sm-6">
                                <div class="product-inner">
								
																 
                                    <div role="tabpanel">
                                        <ul class="product-tab" role="tablist">
                                            <li role="presentation" class="active"><a href="#detalles" aria-controls="home" role="tab" data-toggle="tab">Detalles</a></li>
                                            <li role="presentation"><a href="#modificar" aria-controls="profile" role="tab" data-toggle="tab">Modificar</a></li>
											<li role="presentation"><a href="#eliminar" aria-controls="hola" role="tab" data-toggle="tab">Eliminar</a></li>
											
										</ul>
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane fade in active" id="detalles">
										
													<h3>Dificultad</h3>
													<font color="#5a88ca"><label><h4><strong><?php echo "$dificultad";?></strong></h4></label></font>
													<h3>Tiempo</h3>
													<font color="#5a88ca"><label><h4><strong><?php echo "$tiempo segundos";?></strong></h4></label></font>
													<h3>Número de monedas</h3>
													<font color="#5a88ca"><label><h4><strong><?php echo "$monedas";?></strong></h4></label></font>
													<h3>Respuesta correcta</h3>
													<font color="#5a88ca"><label><h4><strong><?php echo "$correcta";?></strong></h4></label></font>
													<h3>Frecuencia</h3>
													<font color="#5a88ca"><label><h4><strong><?php echo "$frecuencia";?></strong></h4></label></font>
													<h3>Fallos</h3>
													<font color="#5a88ca"><label><h4><strong><?php echo "$fallos";?></strong></h4></label></font>
													<h3>Aciertos</h3>
													<font color="#5a88ca"><label><h4><strong><?php echo "$aciertos";?></strong></h4></label></font>
											
											</div>
											<div role="tabpanel" class="tab-pane fade" id="modificar">
                                                
												<form action="modificarPregunta.php?idPregunta=<?php echo "$idPregunta";?>&nombreColeccion=<?php echo "$nombreColeccion";?>" 
                                                    method="post" enctype="multipart/form-data" 
                                                    onsubmit="return validarPreguntaRespuestas()"
                                                    class="checkout" name="checkout">
													<div id="customer_details" class="col2-set">
														<div class="col-1">

															<label class="" >Dificultad</label>
															<?php 

                                                                if($dificultad == "Fácil"){
                                                                echo '
                                                                <select id="billing_dificultad" name="billing_dificultad">
                                                                    <option value="Fácil" selected> Fácil </option>
                                                                    <option value="Medio"> Medio </option>
                                                                    <option value="Difícil"> Difícil </option>
                                                                </select>
                                                                ';
                                                                }else if($dificultad == "Medio"){
                                                                echo '
                                                                <select id="billing_dificultad" name="billing_dificultad">
                                                                    <option value="Fácil"> Fácil </option>
                                                                    <option value="Medio" selected> Medio </option>
                                                                    <option value="Difícil"> Difícil </option>
                                                                </select>
                                                                ';
                                                                }else{
                                                                echo '
                                                                <select id="billing_dificultad" name="billing_dificultad">
                                                                    <option value="Fácil"> Fácil </option>
                                                                    <option value="Medio"> Medio </option>
                                                                    <option value="Difícil" selected> Difícil </option>
                                                                </select>
                                                                ';

                                                                }

                                                             ?>

															<br>
															<br>

															<label class="" >Tiempo</label>
															<input type="number" min="5" max="300"
                                                            value="<?php echo "$tiempo";?>"
                                                            placeholder="Elige el tiempo"  
                                                            title="Tiempo para responder la pregunta, como máximo 5 min."
                                                            id="billing_tiempo" name="billing_tiempo" required>
                                                            <br>
															<br>

															<label class="" >Número de monedas</label>
															<input type="number" value="<?php echo "$monedas";?>" 
                                                            min="1" max="500" placeholder="  Monedas" 
															id="billing_monedas" name="billing_monedas" required>
															<br>
															<br>

															<label class="" >Enunciado </label>
															<textarea id="billing_enunciado" 
                                                            name="billing_enunciado" rows="5" maxlength="300" 
															placeholder="Escribe el enunciado de la pregunta" required><?php echo "$enunciado";?></textarea>
															<br>
															<br>

															<label class="" >Respuesta correcta </label>
															<input type="text" value='<?php echo $correcta;?>'
                                                            placeholder="Respuesta correcta" 
															id="billing_correcta" name="billing_correcta" class="input-text " required>
															<br>
															<br>

															<label class="" >Respuesta incorrecta </label>
															<input type="text" value='<?php echo $incorrecta1;?>'
                                                            placeholder="Respuesta incorrecta" 
															id="billing_incorrecta1" name="billing_incorrecta1" class="input-text " required>
															<br>
															<br>

															<label class="" >Respuesta incorrecta </label>
															<input type="text" value='<?php echo $incorrecta2;?>'
                                                            placeholder="Respuesta incorrecta" 
															id="billing_incorrecta2" name="billing_incorrecta2" class="input-text " required>
															<br>
															<br>

															<label class="" >Respuesta incorrecta </label>
															<input type="text" value='<?php echo $incorrecta2;?>'
                                                            placeholder="Respuesta incorrecta" 
															id="billing_correcta3" name="billing_incorrecta3" class="input-text " required>

														</div>
													</div>
													<br>
													<br>
													<div class="form-row place-order">
														<input type="submit" value="Modificar" class="button">
														<input type="reset" value="Restaurar todo" class="button"> 	
													</div>
												</form>   	
												
                                            </div>

											<div role="tabpanel" class="tab-pane fade" id="eliminar">
                                    

												<h2 align="center">¿Estás seguro de eliminar esta pregunta?</h2>
                                                <form action="eliminarPregunta.php?<?php echo "nombreColeccion=$nombreColeccion&idPregunta=$idPregunta"?>" 
                                                method="post" enctype="multipart/form-data" class="checkout" name="checkout">
                                                    <p class="parrafo" ><input type="submit" value="Sí, estoy seguro"></p>
                                                </form>
                                                
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