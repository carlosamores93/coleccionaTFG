<?php
    if (!isset($_SESSION)){
        session_start();
        $page = $_SESSION["page"];
        $_SESSION["page"] = "inicioProfesor.php";
        //echo $_SESSION["super"];
    }

    
    if (!$_SESSION["loginProfesor"]) {
        header("Location: $page");
    }
	
	include_once("conectar.php");
    $link = conectarBBDD();
    // Añadir esta linea de codigo para poner acentos y ñ
    mysqli_query($link, "SET NAMES 'utf8'");
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
			$('#containerPieAlumnos').highcharts({
				chart: {
					type: 'pie',
					options3d: {
						enabled: true,
						alpha: 45,
						beta: 0
					}
				},
				title: {
					text: 'Porcentaje de mis alumnos dados de Alta y Baja'
				},
				tooltip: {
					pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
				},
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						depth: 35,
						dataLabels: {
							enabled: true,
							format: '{point.name}'
						}
					}
				},
				 credits: {
					enabled: false
				},
				series: [{
					type: 'pie',
					name: 'Porcentajes',
					data: [
					
					<?php
					
						// Obtener el nombre del profesor
						$profe = $_SESSION["usuario"];
						
						$link = conectarBBDD();
						// Añadir esta linea de codigo para poner acentos y ñ
						mysqli_query($link, "SET NAMES 'utf8'");

						
						// Obtenemos el número de alumnos totales
						$query = "SELECT COUNT(*) AS numAlumnosAlta FROM mis_alumnos WHERE UsuarioProfesor='$profe' AND PuedeJugar='si'";
						if ($result = mysqli_query($link, $query)) {
							/* fetch associative array */
							while ($row = mysqli_fetch_assoc($result)) {
								$numAlumnosAlta = $row["numAlumnosAlta"];
							}
							 /* free result set */
							mysqli_free_result($result);
						}
						
						// Obtenemos el número de colecciones totales
						$query = "SELECT COUNT(*) AS numAlumnosBaja FROM mis_alumnos WHERE UsuarioProfesor='$profe' AND PuedeJugar='no'";
						if ($result = mysqli_query($link, $query)) {
							/* fetch associative array */
							while ($row = mysqli_fetch_assoc($result)) {
								$numAlumnosBaja = $row["numAlumnosBaja"];
							}
							 /* free result set */
							mysqli_free_result($result);
						}
					?>
						['ALTA <?php echo "$numAlumnosAlta"?>',  <?php echo "$numAlumnosAlta"?>],
						
						{
							name: 'BAJA <?php echo "$numAlumnosBaja"?>',
							y: <?php echo "$numAlumnosBaja"?>,
							sliced: true,
							selected: true
						}
						
						
					]
				}]
			});
		});
	</script>
	
	<script type="text/javascript">
	
		$(function () {
			$('#containerPieColecciones').highcharts({
				chart: {
					type: 'pie',
					options3d: {
						enabled: true,
						alpha: 45,
						beta: 0
					}
				},
				title: {
					text: 'Porcentaje de mis colecciones publicadas y no publicadas'
				},
				tooltip: {
					pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
				},
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						depth: 35,
						dataLabels: {
							enabled: true,
							format: '{point.name}'
						}
					}
				},
				 credits: {
					enabled: false
				},
				series: [{
					type: 'pie',
					name: 'Porcentajes',
					data: [
					
					<?php
					
						// Obtener el nombre del profesor
						$profe = $_SESSION["usuario"];
						
						$link = conectarBBDD();
						// Añadir esta linea de codigo para poner acentos y ñ
						mysqli_query($link, "SET NAMES 'utf8'");

						
						// Obtenemos el número de alumnos totales
						$query = "SELECT COUNT(*) AS numColeccineosPublicadas FROM colecciones WHERE UsuarioProfesor='$profe' AND Publicar='SI'";
						if ($result = mysqli_query($link, $query)) {
							/* fetch associative array */
							while ($row = mysqli_fetch_assoc($result)) {
								$numColeccineosPublicadas = $row["numColeccineosPublicadas"];
							}
							 /* free result set */
							mysqli_free_result($result);
						}
						
						// Obtenemos el número de colecciones totales
						$query = "SELECT COUNT(*) AS numColeccineosNoPublicadas FROM colecciones WHERE UsuarioProfesor='$profe' AND Publicar='NO'";
						if ($result = mysqli_query($link, $query)) {
							/* fetch associative array */
							while ($row = mysqli_fetch_assoc($result)) {
								$numColeccineosNoPublicadas = $row["numColeccineosNoPublicadas"];
							}
							 /* free result set */
							mysqli_free_result($result);
						}
					?>
						['PÚBLICAS <?php echo "$numColeccineosPublicadas"?>',  <?php echo "$numColeccineosPublicadas"?>],
						
						{
							name: 'NO PÚBLICAS <?php echo "$numColeccineosNoPublicadas"?>',
							y: <?php echo "$numColeccineosNoPublicadas"?>,
							sliced: true,
							selected: true
						}
						
						
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
                        <li class="active" ><a href="inicioProfesor.php"><i class="fa fa-home fa-fw" aria-hidden="true"></i>&nbsp;Inicio</a></li>
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

    $usuario = $_SESSION["usuario"];
    //echo "$usuario";
    $link = conectarBBDD();
    // Añadir esta linea de codigo para poner acentos y ñ
    mysqli_query($link, "SET NAMES 'utf8'");


    $query="SELECT NombreProfesor FROM profesores
    WHERE UsuarioProfesor = '$usuario' ";
    if ($result = mysqli_query($link, $query)) {
        // fetch associative array 
        while ($row = mysqli_fetch_assoc($result)) {
            $nombre = $row["NombreProfesor"];
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


   
    <div class="maincontent-area">
        <div class="zigzag-bottom">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
									
					<div class="col-md-6">    
									
						<div id="containerPieAlumnos" style="height: 400px">
						<!-- Este es el gráfico de porcentaje de los alumnos dados de alta y baja -->
						</div> 

					</div>
									
					<div class="col-md-6">
						<div id="containerPieColecciones" style="height: 400px">
						<!-- Este es el gráfico de porcentaje de las colecciones publicadas y no publicadas -->
						</div> 
					</div>
					
                </div>
            </div>
        </div>
    </div> <!-- End main content area -->
       
	
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