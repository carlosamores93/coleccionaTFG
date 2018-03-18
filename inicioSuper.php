<?php
	
    if (!isset($_SESSION)){
        session_start();
        $page = $_SESSION["page"];
        //echo "$page";
        $_SESSION["page"] = "inicioSuper.php";
        //echo $_SESSION["super"];
    }

    
    if (!$_SESSION["loginSuper"]) {
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
	
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	
	<style type="text/css">${demo.css}</style>

		<script type="text/javascript">
	
		$(function () {
			$('#containerPie').highcharts({
				chart: {
					type: 'pie',
					options3d: {
						enabled: true,
						alpha: 45,
						beta: 0
					}
				},
				title: {
					text: 'Número de Alumnos, Profesores y Colecciones'
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
						// Obtenemos el número de alumnos totales
						$query = "SELECT COUNT(*) AS numTotalAlumnos FROM alumnos";
						if ($result = mysqli_query($link, $query)) {
							/* fetch associative array */
							while ($row = mysqli_fetch_assoc($result)) {
								$numTotalAlumnos = $row["numTotalAlumnos"];
							}
							 /* free result set */
							mysqli_free_result($result);
						}
						
						// Obtenemos el número de profesores totales
						$query = "SELECT COUNT(*) AS numTotalProfesores FROM profesores";
						if ($result = mysqli_query($link, $query)) {
							/* fetch associative array */
							while ($row = mysqli_fetch_assoc($result)) {
								$numTotalProfesores = $row["numTotalProfesores"];
							}
							 /* free result set */
							mysqli_free_result($result);
						}
						
						// Obtenemos el número de colecciones totales
						$query = "SELECT COUNT(*) AS numTotalColecciones FROM colecciones";
						if ($result = mysqli_query($link, $query)) {
							/* fetch associative array */
							while ($row = mysqli_fetch_assoc($result)) {
								$numTotalColecciones = $row["numTotalColecciones"];
							}
							 /* free result set */
							mysqli_free_result($result);
						}
					?>
						['Alumnos <?php echo "$numTotalAlumnos"?>',  <?php echo "$numTotalAlumnos"?>],
						
						{
							name: 'Profesores <?php echo "$numTotalProfesores"?>',
							y: <?php echo "$numTotalProfesores"?>,
							sliced: true,
							selected: true
						},
						
						['Colecciones <?php echo "$numTotalColecciones"?>',  <?php echo "$numTotalColecciones"?>]
					]
				}]
			});
		});
	</script>
	
	<script type="text/javascript">
$(function () {
    $('#containerBar').highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: 'Número de alumnos y colecciones por Profesor'
        },
        subtitle: {
            text: 'Colecciona'
        },
        xAxis: {
            categories: [
			
			<?php
				// Buscamos a todos los profesores
				$query = "SELECT NombreProfesor, ApellidosProfesor FROM profesores ORDER BY IdProfesor";
				if ($result = mysqli_query($link, $query)) {
					/* fetch associative array */
					while ($row = mysqli_fetch_assoc($result)) {
						$nombre = $row["NombreProfesor"];
						$apellidos = $row["ApellidosProfesor"];
						
			?>
				['<?php echo "$nombre $apellidos "?>'],
			
			<?php
					}
					 /* free result set */
					mysqli_free_result($result);
				}
			?>
			
			
			],
            title: {
                text:'Profesores'
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Número',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' Diferentes'
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
            y: 200,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Colecciones',
			
			
            data: [
			
			<?php
				
				 $link = conectarBBDD();
				// Añadir esta linea de codigo para poner acentos y ñ
				mysqli_query($link, "SET NAMES 'utf8'");
				
				
				// Buscamos a todos los profesores
				$query = "SELECT UsuarioProfesor FROM profesores ORDER BY IdProfesor";
				if ($result = mysqli_query($link, $query)) {
					/* fetch associative array */
					while ($row = mysqli_fetch_assoc($result)) {
						$user = $row["UsuarioProfesor"];
						
					
					//Calculamos el número de colecciones de ese profesor
						$query = "SELECT COUNT(*) AS numColecciones FROM colecciones 
						WHERE UsuarioProfesor='$user'";
						if ($res = mysqli_query($link, $query)) {
							/* fetch associative array */
							while ($row = mysqli_fetch_assoc($res)) {
								$numColecciones = $row["numColecciones"];
								
			?>	
					
							[<?php echo $numColecciones?>],
					
			<?php
								
							}
							 /* free result set */
							mysqli_free_result($res);
						}
					}
					 /* free result set */
					mysqli_free_result($result);
				}
			?>
			
			]
        }, {
            name: 'Alumnos',
            data: [
			
			<?php
			
			 $link = conectarBBDD();
				// Añadir esta linea de codigo para poner acentos y ñ
				mysqli_query($link, "SET NAMES 'utf8'");
			
				// Buscamos a todos los profesores
				$query = "SELECT UsuarioProfesor FROM profesores ORDER BY IdProfesor";
				if ($result = mysqli_query($link, $query)) {
					/* fetch associative array */
					while ($row = mysqli_fetch_assoc($result)) {
						$user = $row["UsuarioProfesor"];
						
					
					// Calculamos el número de alumnos de ese profesor
					$query = "SELECT COUNT(*) AS numAlumnos FROM mis_alumnos 
						WHERE UsuarioProfesor='$user'";
						if ($res = mysqli_query($link, $query)) {
							/* fetch associative array */
							while ($row = mysqli_fetch_assoc($res)) {
								$numAlumnos = $row["numAlumnos"];
								
			?>	
					
							[<?php echo $numAlumnos?>],
					
			<?php
								
							}
							 /* free result set */
							mysqli_free_result($res);
						}
					}
					 /* free result set */
					mysqli_free_result($result);
				}
				
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
                        <h1><a href="inicioSuper.php"><img src="img/colecciona.png"></a></h1>
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
                        <li class="active" ><a href="inicioSuper.php"><i class="fa fa-home fa-fw" aria-hidden="true"></i>&nbsp;Inicio</a></li>
                        <li><a href="superListarProfesores.php">Profesores</a></li>
                        <li><a href="superListarAlumnos.php">Alumnos</a></li>
                        <li><a href="superListarColecciones.php">Colecciones</a></li>
                        <li><a href="superRegistrarUsuario.php">Nuevo usuario</a></li>
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


    $query="SELECT NombreSuper FROM superadmin
    WHERE UsuarioSuper = '$usuario' ";
    if ($result = mysqli_query($link, $query)) {
        // fetch associative array 
        while ($row = mysqli_fetch_assoc($result)) {
            $nombre = $row["NombreSuper"];
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
					<div class="col-md-5">
						<div class="product-content-right">
						
						
							<div id="containerPie" style="height: 400px">
							
							</div> 

						</div>                    
					</div>
					
					<div class="col-md-7">
						<div class="product-content-right">
						
						
							<div id="containerBar" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto">
								
							</div>

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