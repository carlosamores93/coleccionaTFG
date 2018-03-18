<?php
    

    

    if (!isset($_SESSION)){
        session_start();
        $page = $_SESSION["page"];
        $_SESSION["page"] = "coleccionJugar.php";

        if($page == "jugarBanca.php"){
            header("Location: salirBanca.php");
        }
        
        if($page == "jugarJugar.php"){
            header("Location: restarVida.php");
        }
        //echo $_SESSION["super"];
    }

    if (!isset($_SESSION["coleccionEmpezada"])) {
        header("Location: $page");
        exit();
    }


    if (!$_SESSION["loginAlumno"]) {
        header("Location: $page");
    }

    include_once("actualizarAlumno.php");


    function mostrarFichas(){

        $nombreColeccion = $_SESSION["coleccionEmpezada"];
        $alumno = $_SESSION['usuario'];

        $link = conectarBBDD();
        // Añadir esta linea de codigo para poner acentos y ñ
        mysqli_query($link, "SET NAMES 'utf8'");

        $query="SELECT Monedas
        FROM juega_colecciones WHERE NombreColeccion = '$nombreColeccion' AND UsuarioAlumno = '$alumno' ";
        if ($result = mysqli_query($link, $query)) {
            // fetch associative array 
            while ($row = mysqli_fetch_assoc($result)) {
                $mis_monedas = $row["Monedas"];
            }
            // free result set 
            mysqli_free_result($result);
        }else{
            echo "NADAAAAAAA";
        }


        $query="SELECT NumeroFichas, FichasFaciles, FichasMedio, FichasDificiles
        FROM colecciones WHERE NombreColeccion = '$nombreColeccion' ";
        if ($result = mysqli_query($link, $query)) {
            // fetch associative array 
            while ($row = mysqli_fetch_assoc($result)) {
                $totalesFichas = $row["NumeroFichas"];
                $precioFichaFacil = $row["FichasFaciles"];
                $precioFichaMedio = $row["FichasMedio"];
                $precioFichaDificil = $row["FichasDificiles"];
            }
            // free result set 
            mysqli_free_result($result);
        }else{
            echo "NADAAAAAAA";
        }

        $query="SELECT IdFicha, DificultadFicha, FotoFicha 
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
                $dificultadFicha = $row["DificultadFicha"];


                $sql="SELECT NumeroFichas, IdFicha
                FROM mis_fichas 
                WHERE  IdFicha = '$idFicha' AND UsuarioAlumno = '$alumno'";

                if ($resultado = mysqli_query($link, $sql)){

                    if(mysqli_num_rows($resultado) == 0){ // Si no tienes la ficha puedes comprar a la banca

                        if($dificultadFicha == 'Fácil'){ 
                            $monedasGastar = $precioFichaFacil;
                        }else if($dificultadFicha == 'Medio'){ 
                            $monedasGastar = $precioFichaMedio;
                        }else{ 
                            $monedasGastar = $precioFichaDificil;
                        }

                        if($mis_monedas >= $monedasGastar){

                            echo '
                            <div class="single-product">';

                                echo '<div class="product-carousel-price" align="center">';
                                    echo "<ins> $contador / $totalesFichas </ins>
                                </div> 
                                ";
                                echo'
                                <div class="product-f-image" id="product-f-image">
                                    <img class="imagenColeccion" src="img/candado.png" alt="">
                                    <div class="product-hover">';
                                    
                                     
                                       echo " <a href='pasarFichaParaBanca.php?idFicha=$idFicha&monedasGastar=$monedasGastar' 
                                       class='add-to-cart-link'>";
                                        echo '    <i class="fa fa-money" aria-hidden="true">
                                            </i> 
                                            Banca 
                                        </a>
                                    </div>
                                </div>
                                                         
                            </div> 
                            ';

                        }else{
                            echo '
                            <div class="single-product">';

                                echo '<div class="product-carousel-price" align="center">';
                                    echo "<ins> $contador / $totalesFichas </ins>
                                </div> 
                                ";
                                echo'
                                <div class="product-f-image" id="product-f-image">
                                    <img class="imagenColeccion" src="img/candado.png" alt="">
                                    <div class="product-hover">';

                                       echo " <a class='add-to-cart-link'
                                                title='No tienes suficientes monedas para conseguir esta ficha'";
                                        echo '    <i class="fa fa-refresh" aria-hidden="true">
                                            </i> 
                                           Te faltan monedas
                                        </a>
                                    </div>
                                </div>
                                                         
                            </div> 
                            ';
                        }


                    }else{

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
							
							if($numeroFichas > 1){
                            echo '<div class="product-carousel-price" align="center"><br>';
                                echo "<ins> $numeroFichas Veces </ins>
                            </div>";
							echo '
                               <div class="product-carousel-price" align="center">
                                ';
                                    echo "
                                    <a href='venderRepetidas.php?idFicha=$idFicha' class='boton rojo' title='vender ficha repetida'>
                                    ";

                                    echo '
                                        <i class="fa fa-shopping-cart" aria-hidden="true"></i><strong>&nbsp;Vender repes</strong>
                                    </a>
                                </div>
                                ';
							}else{
								
								echo '<div class="product-carousel-price" align="center"><br>';
									echo "<ins> $numeroFichas Vez </ins>
								</div>";
								
							}

                        echo "                         
                        </div>
                        ";
                    }

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
	
	function mostrarRanking() {

        $link = conectarBBDD();
        // Añadir esta linea de codigo para poner acentos y ñ
        mysqli_query($link, "SET NAMES 'utf8'");
        
        $nombreColeccion = $_SESSION["coleccionEmpezada"];

        $query="SELECT  UsuarioAlumno, FichasConseguidas, Vidas 
        FROM juega_colecciones
        WHERE nombreColeccion ='$nombreColeccion'
        ORDER BY FichasConseguidas DESC, Vidas DESC
        LIMIT 0,5";


        if ($result = mysqli_query($link, $query)) {

            // fetch associative array 
            while ($row = mysqli_fetch_assoc($result)) {            
                $nick = $row["UsuarioAlumno"];
                $fichasConseguidas = $row["FichasConseguidas"];

                $query="SELECT NombreAlumno, ApellidosAlumno, FotoAlumno
                FROM alumnos WHERE UsuarioAlumno='$nick'";
                if ($result1 = mysqli_query($link, $query)) {
                    while ($row = mysqli_fetch_assoc($result1)) {            
                        $nombreAlumno = $row["NombreAlumno"];
                        $apellidosAlumno = $row["ApellidosAlumno"];
                        $foto = $row["FotoAlumno"];
                    }
                    mysqli_free_result($result1);
                }

                    
                echo "<div class='thubmnail-recent'>
                    <img src='$foto' class='recent-thumb-ranking' alt=''>
                    <h2><a>$nick</a></h2>
                    <div class='product-sidebar-price'>
                        <ins>$fichasConseguidas</ins>
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
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	
	<style type="text/css">${demo.css}</style>

	
	<script type="text/javascript">
		$(function () {
			$('#containerBarPreguntas').highcharts({
				chart: {
					type: 'bar'
				},
				title: {
					text: ''
				},
				subtitle: {
				
					text: ''
				},
				xAxis: {
					categories: [									
					],
					title: {
						text:''
					}
				},
				yAxis: {
					min: 0,
					title: {
						text: '',
						align: 'high'
					},
					labels: {
						overflow: 'justify'
					}
				},
				tooltip: {
					valueSuffix: ' Preguntas'
				},
				plotOptions: {
					bar: {
						dataLabels: {
							enabled: true
						}
					}
				},
				legend: {
					layout: 'vertical',
					align: 'right',
					verticalAlign: 'top',
					x: -30,
					y: -10,
					floating: true,
					borderWidth: 1,
					backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
					shadow: true
				},
				credits: {
					enabled: false
				},
				series: [{
					name: 'Acertadas',
					
					
					data: [
					
					<?php
						
						$nombreColeccion = $_SESSION["coleccionEmpezada"];

						$alumno = $_SESSION['usuario'];

						$link = conectarBBDD();
						// Añadir esta linea de codigo para poner acentos y ñ
						mysqli_query($link, "SET NAMES 'utf8'");
						
						
						//Obtenemos el número de pregutas correctas
						$sql="SELECT SUM(Correcta) AS CorrectaColeccion
						FROM actividad_alumnos 
						WHERE NombreColeccion ='$nombreColeccion' AND UsuarioAlumno = '$alumno'";
						if ($res = mysqli_query($link, $sql)) {

							// fetch associative array  Esto solo da una vuelta.
							while ($row = mysqli_fetch_assoc($res)) {
								$acertadasColeccion =$row["CorrectaColeccion"];
								
										
					?>	
							
									[<?php echo $acertadasColeccion?>],
							
					<?php
										
								
							}
							 /* free result set */
							mysqli_free_result($result);
						}
					?>
					
					]
				}, {
					name: 'Falladas',
					
					
					data: [
					
					<?php
						
						$nombreColeccion = $_SESSION["coleccionEmpezada"];

						$alumno = $_SESSION['usuario'];

						$link = conectarBBDD();
						// Añadir esta linea de codigo para poner acentos y ñ
						mysqli_query($link, "SET NAMES 'utf8'");
						
						
						//Obtenemos el número de preguntas incorrectas
						$sql="SELECT SUM(Incorrecta1)+SUM(Incorrecta2)+SUM(Incorrecta3) AS IncorrectaColeccion
						FROM actividad_alumnos 
						WHERE NombreColeccion ='$nombreColeccion' AND UsuarioAlumno = '$alumno'";
						if ($res = mysqli_query($link, $sql)) {

							// fetch associative array  Esto solo da una vuelta.
							while ($row = mysqli_fetch_assoc($res)) {
								$falladasColeccion =$row["IncorrectaColeccion"];
								
										
					?>	
							
									[<?php echo $falladasColeccion?>],
							
					<?php
										
								
							}
							 /* free result set */
							mysqli_free_result($result);
						}
					?>
					
					]
				},{
					name: 'Time Out',
					data: [
					
					<?php
						
						$nombreColeccion = $_SESSION["coleccionEmpezada"];

						$alumno = $_SESSION['usuario'];

						$link = conectarBBDD();
						// Añadir esta linea de codigo para poner acentos y ñ
						mysqli_query($link, "SET NAMES 'utf8'");
						
						
						//Obtenemos el número de respuestas en las que se acabó el tiempo
						$sql="SELECT SUM(TimeOut) AS TimeOutColeccion
						FROM actividad_alumnos 
						WHERE NombreColeccion ='$nombreColeccion' AND UsuarioAlumno = '$alumno'";
						if ($res = mysqli_query($link, $sql)) {

							// fetch associative array  Esto solo da una vuelta.
							while ($row = mysqli_fetch_assoc($res)) {
								$timeOutColeccion =$row["TimeOutColeccion"];
								
										
					?>	
							
									[<?php echo $timeOutColeccion?>],
							
					<?php
										
								
							}
							 /* free result set */
							mysqli_free_result($result);
						}
						
						 // Cerrar conexion con la bbdd
						mysqli_close($link);
					?>
					
					]
				}]
			});
		});
	</script>
	
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
                    require_once("usuario.php");
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

    $nombreColeccion = $_SESSION["coleccionEmpezada"];

    $alumno = $_SESSION['usuario'];

    $link = conectarBBDD();
    // Añadir esta linea de codigo para poner acentos y ñ
    mysqli_query($link, "SET NAMES 'utf8'");



    $query="SELECT PrecioVida
    FROM colecciones WHERE NombreColeccion = '$nombreColeccion' ";
    if ($result = mysqli_query($link, $query)) {
        // fetch associative array 
        while ($row = mysqli_fetch_assoc($result)) {
            $precioDeUnaVida = $row["PrecioVida"];
        }
        // free result set 
        mysqli_free_result($result);
    }else{
        echo "NADAAAAAAA";
    }


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



    $sql="SELECT SUM(Correcta) AS CorrectaColeccion
    FROM actividad_alumnos 
    WHERE NombreColeccion ='$nombreColeccion' AND UsuarioAlumno = '$alumno'";
    if ($res = mysqli_query($link, $sql)) {

        // fetch associative array  Esto solo da una vuelta.
        while ($row = mysqli_fetch_assoc($res)) {
            $acertadasColeccion =$row["CorrectaColeccion"];
            }
        mysqli_free_result($res);
    }

    $sql="SELECT SUM(Incorrecta1)+SUM(Incorrecta2)+SUM(Incorrecta3) AS IncorrectaColeccion
    FROM actividad_alumnos 
    WHERE NombreColeccion ='$nombreColeccion' AND UsuarioAlumno = '$alumno'";
    if ($res = mysqli_query($link, $sql)) {

        // fetch associative array  Esto solo da una vuelta.
        while ($row = mysqli_fetch_assoc($res)) {
            $falladasColeccion =$row["IncorrectaColeccion"];
            }
        mysqli_free_result($res);
    }



    $sql="SELECT SUM(TimeOut) AS TimeOutColeccion
    FROM actividad_alumnos 
    WHERE NombreColeccion ='$nombreColeccion' AND UsuarioAlumno = '$alumno'";
    if ($res = mysqli_query($link, $sql)) {

        // fetch associative array  Esto solo da una vuelta.
        while ($row = mysqli_fetch_assoc($res)) {
            $timeOutColeccion =$row["TimeOutColeccion"];
            }
        mysqli_free_result($res);
    }






    // Cerrar conexion con la bbdd
    mysqli_close($link);

?>


	<div class="single-product-area-juego">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-3">


                    <div class="single-sidebar">
                        <a href="coleccionesEmpezadas.php"><input type="submit" value="Volver"></a>                            
                    </div> 					
								
					<div class="single-sidebar" style="width:100%; height:300px; overflow-y:scroll;">
                        
                        <h2 class="sidebar-title"><i class="fa fa-trophy" aria-hidden="true"></i>&nbsp;Ranking</h2>
                      
						<?php
							mostrarRanking();						
                        ?>
						                                            
                    </div>


					<div class="col-md-9">
						
						<div class="footer-card-icon">
					
							<div class="shopping-item-mio">
								<table cellspacing="0" >
									<tr class="cart_item">
									
										<td class="product-thumbnailmensaje">
											<label>1&nbsp;&nbsp;</label>
										</td>
										<td class="product-thumbnailmensaje">
											<img width="105" height="105" alt="poster_1_up" 
												class="shop_thumbnail" title="vidas" type="image" src="img/vidas.png">
										</td>
										
										<td class="product-thumbnailmensaje">
											<label>&nbsp;&nbsp;=&nbsp;&nbsp;</label>
										</td>
										<td class="product-thumbnailmensaje">
											<label><?php echo "$precioDeUnaVida";?>&nbsp;&nbsp;</label>
										</td>
										<td class="product-thumbnailmensaje">
											<img width="105" height="105" alt="poster_1_up" 
												class="shop_thumbnail" title="precio monedas" type="image" src="img/coins.png">
										</td>
										
									</tr>
								</table>
							</div>
						</div>
					</div>	

					<div class="col-md-12">
						<div class="product-content-right">
						
						
							<div id="containerBarPreguntas" style="min-width: 50%; max-width: 100%; height: 200px; margin: 0 auto">
								
							</div>

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
											class="shop_thumbnail" title="vidas" type="image" src="img/vidas.png">
									</td>
									<td class="product-thumbnailmensaje">
										<label>
                                            <?php echo "$vidas";?>
                                            &nbsp;&nbsp;&nbsp;
                                        </label>
									</td>

									<td class="product-thumbnailmensaje">
										<img width="105" height="105" alt="poster_1_up" 
											class="shop_thumbnail" title="monedas" type="image" src="img/moneditas.png">
									</td>
									<td class="product-thumbnailmensaje">
										<label>
                                            <?php echo "$monedas";?>
                                            &nbsp;&nbsp;&nbsp;
                                        </label>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
					
                <div class="col-md-9">
				
                    <div class="product-content-right">

                        <div class="related-products-wrapper">
															
                            <h2 class="related-products-title">
                                <strong>
                                    <?php echo "$nombreColeccionCorrecto";?>
                                </strong>
                                
                            </h2>
                            <div class="related-products-carousel">  


                                <?php
                                
                                    mostrarFichas();
                                    
                                ?> 


<!--
                                <div class="single-product">
                                    <div class="product-f-image" id="product-f-image">
                                         <img src="img/images.jpg" alt="">
                                        <div class="product-hover">
                                           <a href="verFicha.php" class="add-to-cart-link">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                Ver ficha
                                            </a>
                                        </div>
                                    </div>

                                    <div class="product-carousel-price" align="center"><br>
                                        <ins>1</ins>
                                    </div>                           
                                </div> 

                          
                                <div class="single-product">
                                    <div class="product-f-image">
                                        <img src="img/candado.png" alt="">
                                        <div class="product-hover">
                                            <a href="" class="add-to-cart-link">
                                                <i class="fa fa-refresh" aria-hidden="true">
                                                </i> 
                                                Intercambiar
                                            </a>
                                            <a href="jugarBanca.php" class="view-details-link">
                                                <i class="fa fa-money" aria-hidden="true">
                                                </i> 
                                                Banca 
                                            </a>
                                        </div>
                                    </div>
									


                                    <div class="product-carousel-price" align="center"><br>
                                        <ins>3</ins>
                                    </div>                             
                                </div> 
-->


                            </div>
                        </div>
						
                    </div> 
					
					<br>
					<div class="single-sidebar">


                        <?php

                            if($vidas > 0 && $monedas >= $precioDeUnaVida){

                                echo '
                                <div class="col-md-6">';
                                    echo "
                                    <a href='jugarJugar.php' class='boton morado' title='jugar'>
                                    ";
                                    echo '
                                        <i class="fa fa-play-circle" aria-hidden="true"></i><strong>&nbsp;JUGAR COLECCIÓN</strong>
                                    </a>
                                </div>
                                ';

                                echo '
                                <div class="col-md-6">
                                ';
                                    echo "
                                    <a href='comprarVidas.php' class='boton rojo' title='comprar vidas'>
                                    ";

                                    echo '
                                        <i class="fa fa-shopping-cart" aria-hidden="true"></i><strong>&nbsp;COMPRAR VIDAS</strong>
                                    </a>
                                </div>
                                ';


                            }else if($vidas > 0 && $monedas < $precioDeUnaVida){

                                echo '
                                <div class="col-md-12">';
                                    echo "
                                    <a href='jugarJugar.php' class='boton morado' title='jugar'>
                                    ";
                                    echo '
                                        <i class="fa fa-play-circle" aria-hidden="true"></i><strong>&nbsp;JUGAR COLECCIÓN</strong>
                                    </a>
                                </div>
                                ';

                            }else if($vidas <= 0 && $monedas >= $precioDeUnaVida){

                                echo '

                                <div class="col-md-6">
                                ';
                                    echo "
                                    <a href='jugarMonedas.php' class='boton amarillo' title='ganar monedas'>
                                    ";
                                    echo '
                                        <i class="fa fa-database" aria-hidden="true"></i><strong>&nbsp;OBTENER MONEDAS</strong>
                                    </a>
                                </div>
                                ';

                                echo '
                                <div class="col-md-6">
                                ';
                                    echo "
                                    <a href='comprarVidas.php' class='boton rojo' title='comprar vidas'>
                                    ";

                                    echo '
                                        <i class="fa fa-shopping-cart" aria-hidden="true"></i><strong>&nbsp;COMPRAR VIDAS</strong>
                                    </a>
                                </div>
                                ';

                            }else{

                                echo '

                                <div class="col-md-12">
                                ';
                                    echo "
                                    <a href='jugarMonedas.php' class='boton amarillo' title='ganar monedas'>
                                    ";
                                    echo '
                                        <i class="fa fa-database" aria-hidden="true"></i><strong>&nbsp;OBTENER MONEDAS</strong>
                                    </a>
                                </div>
                                ';
                            }




                        ?>

<!--
						<div class="col-md-4">
							<a href="jugarJugar.php?nombreColeccion=<?php echo "$nombreColeccion";?>" class="boton morado" title="jugar">
								<i class="fa fa-play-circle" aria-hidden="true"></i><strong>&nbsp;JUGAR COLECCIÓN</strong>
							</a>
						</div>
						<div class="col-md-4">
							<a href="jugarMonedas.php" class="boton amarillo" title="ganar monedas">
								<i class="fa fa-database" aria-hidden="true"></i><strong>&nbsp;OBTENER MONEDAS</strong>
							</a>
						</div>
						<div class="col-md-4">
							<a href="" class="boton rojo" title="comprar vidas">
								<i class="fa fa-shopping-cart" aria-hidden="true"></i><strong>&nbsp;COMPRAR VIDAS</strong>
							</a>
						</div>	
-->



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
	
	  <!-- Gráficos -->
	<script src="Highcharts-4.1.5/js/highcharts.js"></script>
	<script src="Highcharts-4.1.5/js/highcharts-3d.js"></script>
	<script src="Highcharts-4.1.5/js/modules/exporting.js"></script>
	
	
  </body>
</html>