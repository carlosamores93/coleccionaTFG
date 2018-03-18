<?php
    if (!isset($_SESSION)){
        session_start();
        $page = $_SESSION["page"];
        $_SESSION["page"] = "estadisticasProfesor.php";
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
					text: 'Porcentaje de mis colecciones Publicadas y No publicadas'
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
	
		
		<script type="text/javascript">
			$(function () {
				$('#containerBarMisColecciones').highcharts({
					chart: {
						type: 'bar'
					},
					title: {
						text: 'Número de fichas y preguntas de mis colecciones'
					},
					subtitle: {
						text: 'Colecciona'
					},
					xAxis: {
						categories: [
						
						<?php
						
							// Obtener el nombre del profesor
								$profe = $_SESSION["usuario"];
								
								$link = conectarBBDD();
								// Añadir esta linea de codigo para poner acentos y ñ
								mysqli_query($link, "SET NAMES 'utf8'");

							// Buscamos todas mis colecciones
							$query = "SELECT NombreColeccionCorrecto FROM colecciones WHERE UsuarioProfesor='$profe' ORDER BY NumeroFichas, IdColeccion";
							if ($result = mysqli_query($link, $query)) {
								/* fetch associative array */
								while ($row = mysqli_fetch_assoc($result)) {
									$nombreCorrectoColeccion = $row["NombreColeccionCorrecto"];
									
									
						?>
							['<?php echo "$nombreCorrectoColeccion "?>'],
						
						<?php
								}
								 /* free result set */
								mysqli_free_result($result);
							}
						?>
						
						
						],
						title: {
							text:'Colecciones'
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
						name: 'Fichas',
						
						
						data: [
						
						<?php
							
							// Obtener el nombre del profesor
								$profe = $_SESSION["usuario"];
							
							 $link = conectarBBDD();
							// Añadir esta linea de codigo para poner acentos y ñ
							mysqli_query($link, "SET NAMES 'utf8'");
							
							
							// Buscamos a todos los profesores
							$query = "SELECT NumeroFichas FROM colecciones WHERE UsuarioProfesor='$profe' ORDER BY NumeroFichas, IdColeccion";
							if ($result = mysqli_query($link, $query)) {
								/* fetch associative array */
								while ($row = mysqli_fetch_assoc($result)) {
									$numeroFichas = $row["NumeroFichas"];
									
											
						?>	
								
										[<?php echo $numeroFichas?>],
								
						<?php
											
									
								}
								 /* free result set */
								mysqli_free_result($result);
							}
						?>
						
						]
					}, {
						name: 'Preguntas',
						data: [
						
						<?php
							
							// Obtener el nombre del profesor
								$profe = $_SESSION["usuario"];
							
							 $link = conectarBBDD();
							// Añadir esta linea de codigo para poner acentos y ñ
							mysqli_query($link, "SET NAMES 'utf8'");
							
							
							// Buscamos a todos los profesores
							$query = "SELECT NumeroPreguntas FROM colecciones WHERE UsuarioProfesor='$profe' ORDER BY NumeroFichas, IdColeccion";
							if ($result = mysqli_query($link, $query)) {
								/* fetch associative array */
								while ($row = mysqli_fetch_assoc($result)) {
									$numeroPreguntas = $row["NumeroPreguntas"];
									
											
						?>	
								
										[<?php echo $numeroPreguntas?>],
								
						<?php
											
									
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
		
		<script type="text/javascript">
			$(function () {
				$('#containerBarAlumnosColeccion').highcharts({
					chart: {
						type: 'bar'
					},
					title: {
						text: 'Número de alumnos de una colección jugando, bloqueados y terminada'
					},
					subtitle: {
						text: 'Colecciona'
					},
					xAxis: {
						categories: [
						
						<?php
						
							// Obtener el nombre del profesor
								$profe = $_SESSION["usuario"];
								
								$link = conectarBBDD();
								// Añadir esta linea de codigo para poner acentos y ñ
								mysqli_query($link, "SET NAMES 'utf8'");

							// Buscamos todas mis colecciones
							$query = "SELECT NombreColeccionCorrecto FROM colecciones WHERE UsuarioProfesor='$profe' ORDER BY NumeroFichas, IdColeccion";
							if ($result = mysqli_query($link, $query)) {
								/* fetch associative array */
								while ($row = mysqli_fetch_assoc($result)) {
									$nombreCorrectoColeccion = $row["NombreColeccionCorrecto"];
									
									
						?>
							['<?php echo "$nombreCorrectoColeccion "?>'],
						
						<?php
								}
								 /* free result set */
								mysqli_free_result($result);
							}
						?>
						
						
						],
						title: {
							text:'Colecciones'
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
						y: 50,
						floating: true,
						borderWidth: 1,
						backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
						shadow: true
					},
					credits: {
						enabled: false
					},
					series: [{
						name: 'Jugando',
						
						
						data: [
						
						<?php
							
							// Obtener el nombre del profesor
								$profe = $_SESSION["usuario"];
							
							 $link = conectarBBDD();
							// Añadir esta linea de codigo para poner acentos y ñ
							mysqli_query($link, "SET NAMES 'utf8'");
							
							
							// Buscamos a todos los profesores
							$query = "SELECT AlumnosJugando FROM colecciones WHERE UsuarioProfesor='$profe' ORDER BY NumeroFichas, IdColeccion";
							if ($result = mysqli_query($link, $query)) {
								/* fetch associative array */
								while ($row = mysqli_fetch_assoc($result)) {
									$jugando = $row["AlumnosJugando"];
									
											
						?>	
								
										[<?php echo $jugando?>],
								
						<?php
											
									
								}
								 /* free result set */
								mysqli_free_result($result);
							}
						?>
						
						]
					}, {
						name: 'Bloqueados',
						
						
						data: [
						
						<?php
							
							// Obtener el nombre del profesor
								$profe = $_SESSION["usuario"];
							
							 $link = conectarBBDD();
							// Añadir esta linea de codigo para poner acentos y ñ
							mysqli_query($link, "SET NAMES 'utf8'");
							
							
							// Buscamos a todos los profesores
							$query = "SELECT AlumnosBloqueados FROM colecciones WHERE UsuarioProfesor='$profe' ORDER BY NumeroFichas, IdColeccion";
							if ($result = mysqli_query($link, $query)) {
								/* fetch associative array */
								while ($row = mysqli_fetch_assoc($result)) {
									$bloqueados = $row["AlumnosBloqueados"];
									
											
						?>	
								
										[<?php echo $bloqueados?>],
								
						<?php
											
									
								}
								 /* free result set */
								mysqli_free_result($result);
							}
						?>
						
						]
					},{
						name: 'Finalizada',
						data: [
						
						<?php
							
							// Obtener el nombre del profesor
								$profe = $_SESSION["usuario"];
							
							 $link = conectarBBDD();
							// Añadir esta linea de codigo para poner acentos y ñ
							mysqli_query($link, "SET NAMES 'utf8'");
							
							
							// Buscamos a todos los profesores
							$query = "SELECT AlumnosFin FROM colecciones WHERE UsuarioProfesor='$profe' ORDER BY NumeroFichas, IdColeccion";
							if ($result = mysqli_query($link, $query)) {
								/* fetch associative array */
								while ($row = mysqli_fetch_assoc($result)) {
									$fin = $row["AlumnosFin"];
									
											
						?>	
								
										[<?php echo $fin?>],
								
						<?php
											
									
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
		
		<script type="text/javascript">
			$(function () {
				$('#containerBarPreguntasColeccion').highcharts({
					chart: {
						type: 'bar'
					},
					title: {
						text: 'Número de PREGUNTAS fáciles, difíciles y medio de mis colecciones'
					},
					subtitle: {
						text: 'Colecciona'
					},
					xAxis: {
						categories: [
						
						<?php
						
							// Obtener el nombre del profesor
								$profe = $_SESSION["usuario"];
								
								$link = conectarBBDD();
								// Añadir esta linea de codigo para poner acentos y ñ
								mysqli_query($link, "SET NAMES 'utf8'");

							// Buscamos todas mis colecciones
							$query = "SELECT NombreColeccionCorrecto FROM colecciones WHERE UsuarioProfesor='$profe' ORDER BY IdColeccion";
							if ($result = mysqli_query($link, $query)) {
								/* fetch associative array */
								while ($row = mysqli_fetch_assoc($result)) {
									$nombreCorrectoColeccion = $row["NombreColeccionCorrecto"];
									
									
						?>
							['<?php echo "$nombreCorrectoColeccion "?>'],
						
						<?php
								}
								 /* free result set */
								mysqli_free_result($result);
							}
						?>
						
						],
						title: {
							text:'Colecciones'
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
						name: 'Fáciles',
						
						
						data: [
						
						<?php
						
							// Obtener el nombre del profesor
								$profe = $_SESSION["usuario"];
								
								$link = conectarBBDD();
							// Añadir esta linea de codigo para poner acentos y ñ
								mysqli_query($link, "SET NAMES 'utf8'");
							
							
							// Buscamos a todos los profesores
							$query = "SELECT NombreColeccion FROM colecciones WHERE UsuarioProfesor='$profe' ORDER BY IdColeccion";
							if ($result = mysqli_query($link, $query)) {
								/* fetch associative array */
								while ($row = mysqli_fetch_assoc($result)) {
									$nombreColeccion = $row["NombreColeccion"];
									
								
								//Calculamos el número de colecciones de ese profesor
									$query = "SELECT COUNT(*) AS numPreguntasFaciles FROM preguntas 
									WHERE NombreColeccion='$nombreColeccion' AND DificultadPregunta='Fácil'";
									if ($res = mysqli_query($link, $query)) {
										/* fetch associative array */
										while ($row = mysqli_fetch_assoc($res)) {
											$numPreguntasFaciles = $row["numPreguntasFaciles"];
											
						?>	
								
										[<?php echo $numPreguntasFaciles?>],
								
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
						name: 'Medio',
						data: [
						
						<?php
						
							// Obtener el nombre del profesor
								$profe = $_SESSION["usuario"];
								
								$link = conectarBBDD();
							// Añadir esta linea de codigo para poner acentos y ñ
								mysqli_query($link, "SET NAMES 'utf8'");
							
							
							// Buscamos a todos los profesores
							$query = "SELECT NombreColeccion FROM colecciones WHERE UsuarioProfesor='$profe' ORDER BY IdColeccion";
							if ($result = mysqli_query($link, $query)) {
								/* fetch associative array */
								while ($row = mysqli_fetch_assoc($result)) {
									$nombreColeccion = $row["NombreColeccion"];
									
								
								//Calculamos el número de colecciones de ese profesor
									$query = "SELECT COUNT(*) AS numPreguntasMedio FROM preguntas 
									WHERE NombreColeccion='$nombreColeccion' AND DificultadPregunta='Medio'";
									if ($res = mysqli_query($link, $query)) {
										/* fetch associative array */
										while ($row = mysqli_fetch_assoc($res)) {
											$numPreguntasMedio = $row["numPreguntasMedio"];
											
						?>	
								
										[<?php echo $numPreguntasMedio?>],
								
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
					},{
						name: 'Difícil',
						data: [
						
						<?php
						
							// Obtener el nombre del profesor
								$profe = $_SESSION["usuario"];
								
								$link = conectarBBDD();
							// Añadir esta linea de codigo para poner acentos y ñ
								mysqli_query($link, "SET NAMES 'utf8'");
							
							
							// Buscamos a todos los profesores
							$query = "SELECT NombreColeccion FROM colecciones WHERE UsuarioProfesor='$profe' ORDER BY IdColeccion";
							if ($result = mysqli_query($link, $query)) {
								/* fetch associative array */
								while ($row = mysqli_fetch_assoc($result)) {
									$nombreColeccion = $row["NombreColeccion"];
									
								
								//Calculamos el número de colecciones de ese profesor
									$query = "SELECT COUNT(*) AS numPreguntasDificil FROM preguntas 
									WHERE NombreColeccion='$nombreColeccion' AND DificultadPregunta='Medio'";
									if ($res = mysqli_query($link, $query)) {
										/* fetch associative array */
										while ($row = mysqli_fetch_assoc($res)) {
											$numPreguntasDificil = $row["numPreguntasDificil"];
											
						?>	
								
										[<?php echo $numPreguntasDificil?>],
								
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
						}
					]
				});
			});
		</script>
		
		<script type="text/javascript">
			$(function () {
				$('#containerBarFichasColeccion').highcharts({
					chart: {
						type: 'bar'
					},
					title: {
						text: 'Número de FICHAS fáciles, difíciles y medio de mis colecciones'
					},
					subtitle: {
						text: 'Colecciona'
					},
					xAxis: {
						categories: [
						
						<?php
						
							// Obtener el nombre del profesor
								$profe = $_SESSION["usuario"];
								
								$link = conectarBBDD();
								// Añadir esta linea de codigo para poner acentos y ñ
								mysqli_query($link, "SET NAMES 'utf8'");

							// Buscamos todas mis colecciones
							$query = "SELECT NombreColeccionCorrecto FROM colecciones WHERE UsuarioProfesor='$profe' ORDER BY IdColeccion";
							if ($result = mysqli_query($link, $query)) {
								/* fetch associative array */
								while ($row = mysqli_fetch_assoc($result)) {
									$nombreCorrectoColeccion = $row["NombreColeccionCorrecto"];
									
									
						?>
							['<?php echo "$nombreCorrectoColeccion "?>'],
						
						<?php
								}
								 /* free result set */
								mysqli_free_result($result);
							}
						?>
						
						],
						title: {
							text:'Colecciones'
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
						name: 'Fáciles',
						
						
						data: [
						
						<?php
						
							// Obtener el nombre del profesor
								$profe = $_SESSION["usuario"];
								
								$link = conectarBBDD();
							// Añadir esta linea de codigo para poner acentos y ñ
								mysqli_query($link, "SET NAMES 'utf8'");
							
							
							// Buscamos a todos los profesores
							$query = "SELECT NombreColeccion FROM colecciones WHERE UsuarioProfesor='$profe' ORDER BY IdColeccion";
							if ($result = mysqli_query($link, $query)) {
								/* fetch associative array */
								while ($row = mysqli_fetch_assoc($result)) {
									$nombreColeccion = $row["NombreColeccion"];
									
								
								//Calculamos el número de colecciones de ese profesor
									$query = "SELECT COUNT(*) AS numFichasFaciles FROM fichas 
									WHERE NombreColeccion='$nombreColeccion' AND DificultadFicha='Fácil'";
									if ($res = mysqli_query($link, $query)) {
										/* fetch associative array */
										while ($row = mysqli_fetch_assoc($res)) {
											$numFichasFaciles = $row["numFichasFaciles"];
											
						?>	
								
										[<?php echo $numFichasFaciles?>],
								
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
						name: 'Medio',
						data: [
						
						<?php
						
							// Obtener el nombre del profesor
								$profe = $_SESSION["usuario"];
								
								$link = conectarBBDD();
							// Añadir esta linea de codigo para poner acentos y ñ
								mysqli_query($link, "SET NAMES 'utf8'");
							
							
							// Buscamos a todos los profesores
							$query = "SELECT NombreColeccion FROM colecciones WHERE UsuarioProfesor='$profe' ORDER BY IdColeccion";
							if ($result = mysqli_query($link, $query)) {
								/* fetch associative array */
								while ($row = mysqli_fetch_assoc($result)) {
									$nombreColeccion = $row["NombreColeccion"];
									
								
								//Calculamos el número de colecciones de ese profesor
									$query = "SELECT COUNT(*) AS numFichasMedio FROM fichas
									WHERE NombreColeccion='$nombreColeccion' AND DificultadFicha='Medio'";
									if ($res = mysqli_query($link, $query)) {
										/* fetch associative array */
										while ($row = mysqli_fetch_assoc($res)) {
											$numFichasMedio = $row["numFichasMedio"];
											
						?>	
								
										[<?php echo $numFichasMedio?>],
								
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
					},{
						name: 'Difícil',
						data: [
						
						<?php
						
							// Obtener el nombre del profesor
								$profe = $_SESSION["usuario"];
								
								$link = conectarBBDD();
							// Añadir esta linea de codigo para poner acentos y ñ
								mysqli_query($link, "SET NAMES 'utf8'");
							
							
							// Buscamos a todos los profesores
							$query = "SELECT NombreColeccion FROM colecciones WHERE UsuarioProfesor='$profe' ORDER BY IdColeccion";
							if ($result = mysqli_query($link, $query)) {
								/* fetch associative array */
								while ($row = mysqli_fetch_assoc($result)) {
									$nombreColeccion = $row["NombreColeccion"];
									
								
								//Calculamos el número de colecciones de ese profesor
									$query = "SELECT COUNT(*) AS numFichasDificil FROM fichas 
									WHERE NombreColeccion='$nombreColeccion' AND DificultadFicha='Difícil'";
									if ($res = mysqli_query($link, $query)) {
										/* fetch associative array */
										while ($row = mysqli_fetch_assoc($res)) {
											$numFichasDificil = $row["numFichasDificil"];
											
						?>	
								
										[<?php echo $numFichasDificil?>],
								
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
						}
										
					]
				});
			});
		</script>
		
		<script type="text/javascript">
			$(function () {
				$('#containerBarPreguntasMasFalladasColeccion').highcharts({
					chart: {
						type: 'bar'
					},
					title: {
						text: 'Las tres preguntas más falladas de mis colecciones'
					},
					subtitle: {
						text: 'Colecciona'
					},
					xAxis: {
						categories: [
						
						<?php
						
							// Obtener el nombre del profesor
								$profe = $_SESSION["usuario"];
								
								$link = conectarBBDD();
								// Añadir esta linea de codigo para poner acentos y ñ
								mysqli_query($link, "SET NAMES 'utf8'");

							// Buscamos todas mis colecciones
							$query = "SELECT NombreColeccionCorrecto FROM colecciones WHERE UsuarioProfesor='$profe' ORDER BY IdColeccion";
							if ($result = mysqli_query($link, $query)) {
								/* fetch associative array */
								while ($row = mysqli_fetch_assoc($result)) {
									$nombreCorrectoColeccion = $row["NombreColeccionCorrecto"];
									
									
						?>
							['<?php echo "$nombreCorrectoColeccion "?>'],
						
						<?php
								}
								 /* free result set */
								mysqli_free_result($result);
							}
						?>
						
						],
						title: {
							text:'Colecciones'
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
						valueSuffix: ' Veces'
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
						name: '3ª más fallada',
						
						
						data: [
						
						<?php
						
							// Obtener el nombre del profesor
								$profe = $_SESSION["usuario"];
								
								$link = conectarBBDD();
							// Añadir esta linea de codigo para poner acentos y ñ
								mysqli_query($link, "SET NAMES 'utf8'");
							
							
							// Buscamos a todos los profesores
							$query = "SELECT NombreColeccion FROM colecciones WHERE UsuarioProfesor='$profe' ORDER BY IdColeccion";
							if ($result = mysqli_query($link, $query)) {
								/* fetch associative array */
								while ($row = mysqli_fetch_assoc($result)) {
									$nombreColeccion = $row["NombreColeccion"];
									
								
								//Calculamos el número de colecciones de ese profesor
									$query = "SELECT Fallos, Enunciado FROM preguntas 
									WHERE NombreColeccion='$nombreColeccion' ORDER BY Fallos DESC LIMIT 2,1";
									if ($res = mysqli_query($link, $query)) {
										/* fetch associative array */
										while ($row = mysqli_fetch_assoc($res)) {
											$fallos = $row["Fallos"];
											$enunciado = $row["Enunciado"];
											
										
											
						?>	
								
										[<?php echo $fallos?>],
								
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
						name: '2ª más fallada',
						data: [
						
						<?php
						
							
							// Obtener el nombre del profesor
								$profe = $_SESSION["usuario"];
								
								$link = conectarBBDD();
							// Añadir esta linea de codigo para poner acentos y ñ
								mysqli_query($link, "SET NAMES 'utf8'");
							
							
							// Buscamos a todos los profesores
							$query = "SELECT NombreColeccion FROM colecciones WHERE UsuarioProfesor='$profe' ORDER BY IdColeccion";
							if ($result = mysqli_query($link, $query)) {
								/* fetch associative array */
								while ($row = mysqli_fetch_assoc($result)) {
									$nombreColeccion = $row["NombreColeccion"];
									
								
								//Calculamos el número de colecciones de ese profesor
									$query = "SELECT Fallos, Enunciado FROM preguntas 
									WHERE NombreColeccion='$nombreColeccion' ORDER BY Fallos DESC LIMIT 1,1";
									if ($res = mysqli_query($link, $query)) {
										/* fetch associative array */
										while ($row = mysqli_fetch_assoc($res)) {
											$fallos = $row["Fallos"];
											$enunciado = $row["Enunciado"];
											
										
								
						?>	
								
										[<?php echo $fallos?>],
								
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
					},{
						name: '1ª más fallada',
						data: [
						
						<?php
						
							// Obtener el nombre del profesor
								$profe = $_SESSION["usuario"];
								
								$link = conectarBBDD();
							// Añadir esta linea de codigo para poner acentos y ñ
								mysqli_query($link, "SET NAMES 'utf8'");
							
							
							// Buscamos a todos los profesores
							$query = "SELECT NombreColeccion FROM colecciones WHERE UsuarioProfesor='$profe' ORDER BY IdColeccion";
							if ($result = mysqli_query($link, $query)) {
								/* fetch associative array */
								while ($row = mysqli_fetch_assoc($result)) {
									$nombreColeccion = $row["NombreColeccion"];
									
								
								//Calculamos el número de colecciones de ese profesor
									$query = "SELECT Fallos, Enunciado FROM preguntas 
									WHERE NombreColeccion='$nombreColeccion' ORDER BY Fallos DESC LIMIT 0,1";
									if ($res = mysqli_query($link, $query)) {
										/* fetch associative array */
										while ($row = mysqli_fetch_assoc($res)) {
											$fallos = $row["Fallos"];
											$enunciado = $row["Enunciado"];
											
										
							
						?>	
								
										[<?php echo $fallos?>],
								
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
						}
										
					]
				});
			});
		</script>
		
		<style type="text/css">
			#containerBar, #sliders {
				min-width: 80%; 
				max-width: 100%;
				margin: 0 auto;
			}
			#containerBar {
				height: 400px; 
			}
		</style>
		<script type="text/javascript">
			$(function () {
				// Set up the chart
				var chart = new Highcharts.Chart({
					chart: {
						renderTo: 'containerBar',
						type: 'column',
						margin: 75,
						options3d: {
							enabled: true,
							alpha: 15,
							beta: 15,
							depth: 50,
							viewDistance: 25
						}
					},
					title: {
						text: 'Top 10 de mis alumnos'
					},
					subtitle: {
						text: 'Mis 10 alumnos con más fichas'
					},
					plotOptions: {
						column: {
							depth: 25
						}
					},
					series: [{
						data: [29.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1]
					}]
				});

				function showValues() {
					$('#R0-value').html(chart.options.chart.options3d.alpha);
					$('#R1-value').html(chart.options.chart.options3d.beta);
				}

				// Activate the sliders
				$('#R0').on('change', function () {
					chart.options.chart.options3d.alpha = this.value;
					showValues();
					chart.redraw(false);
				});
				$('#R1').on('change', function () {
					chart.options.chart.options3d.beta = this.value;
					showValues();
					chart.redraw(false);
				});

				showValues();
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
                        <li><a href="inicioProfesor.php"><i class="fa fa-home fa-fw" aria-hidden="true"></i>&nbsp;Inicio</a></li>
                        <li><a href="listarAlumnos.php">Alumnos</a></li>
                        <li><a href="listarColecciones.php">Colecciones</a></li>
                        <li  class="active" ><a href="estadisticasProfesor.php">Estadísticas</a></li>
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
                        <h2><strong>Estadísticas</strong></h2>
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
				
					<div class="col-sm-12">
						<div class="product-inner">						
														 
							<div role="tabpanel">
								<ul class="product-tab" role="tablist">
									<li role="presentation" class="active">
										<a href="#alumnos" aria-controls="home" role="tab" data-toggle="tab">% Alumnos</a>
									</li>
									<li role="presentation">
										<a href="#colecciones" aria-controls="profile" role="tab" data-toggle="tab">% Colecciones</a>
									</li>
									<li role="presentation">
										<a href="#fichaspreguntas" aria-controls="profile" role="tab" data-toggle="tab">Fichas/Preguntas</a>
									</li>
							<!--		<li role="presentation">
										<a href="#importar" aria-controls="profile" role="tab" data-toggle="tab">Estadísticas</a>
									</li>
									<li role="presentation"><a href="#eliminar" aria-controls="profile" role="tab" data-toggle="tab">Estadísticas2</a></li>-->
									
								</ul>
								<div class="tab-content">
									<div role="tabpanel" class="tab-pane fade in active" id="alumnos">
									  
										
											<div class="col-md-6">    
							
												<div id="containerPieAlumnos" style="height: 400px">
												<!-- Este es el gráfico de porcentaje de los alumnos dados de alta y baja -->
												</div> 

											</div>
											<div class="col-md-6">
												<div class="product-content-right">
												
												
													<div id="containerBarAlumnosColeccion" style="min-width: 550px; max-width: 800px; height: 400px; margin: 0 auto">
														<!-- Este es el gráfico de las fichas y preguntas en mis colecciones-->														
													</div>

												</div>                    
											</div>																					
										   
										
															
									</div>



									<div role="tabpanel" class="tab-pane fade" id="colecciones">
								
											<div class="col-md-6">
												<div id="containerPieColecciones" style="height: 400px">
												<!-- Este es el gráfico de porcentaje de las colecciones publicadas y no publicadas -->
												</div> 
											</div>
											<div class="col-md-6">
												<div class="product-content-right">									

													<div id="containerBarMisColecciones" style="min-width: 550px; max-width: 800px; height: 400px; margin: 0 auto">
														<!-- Este es el gráfico del estado de los alumnos en mis colecciones-->
													</div>
												</div>                    
											</div>
			
										
									</div>

									<div role="tabpanel" class="tab-pane fade" id="fichaspreguntas">
										
									<div class="col-md-6">
										<div class="product-content-right">									

											<div id="containerBarPreguntasColeccion" style="min-width: 550px; max-width: 800px; height: 400px; margin: 0 auto">
												<!-- Este es el gráfico del estado de los alumnos en mis colecciones-->
											</div>
										</div>                    
									</div>  

									<div class="col-md-6">
										<div class="product-content-right">									

											<div id="containerBarFichasColeccion" style="min-width: 550px; max-width: 800px; height: 400px; margin: 0 auto">
												<!-- Este es el gráfico del estado de los alumnos en mis colecciones-->
											</div>
										</div>                    
									</div>  

										
									</div>

									<!--<div role="tabpanel" class="tab-pane fade" id="importar">
									
									
										<div class="col-md-6">
											<div class="product-content-right">									

												<div id="containerBarPreguntasMasFalladasColeccion" style="min-width: 550px; max-width: 800px; height: 400px; margin: 0 auto">
													<!-- Este es el gráfico del estado de los alumnos en mis colecciones
												</div>
											</div>                    
										</div>
									
									</div> -->
									
								  
									<!--<div role="tabpanel" class="tab-pane fade" id="eliminar">
										
									   <div class="col-md-12">
											<div id="containerBar"></div>
											<div id="sliders">
												<table>
													<tr><td>Ángulo Alpha</td><td><input id="R0" type="range" min="0" max="45" value="15"/> <span id="R0-value" class="value"></span></td></tr>
													<tr><td>Ángulo Beta</td><td><input id="R1" type="range" min="0" max="45" value="15"/> <span id="R1-value" class="value"></span></td></tr>
												</table>
											</div>
										</div>
										
									</div>-->
								</div>
							</div>
							
						</div>
                     </div>
					
					<!--<div class="col-md-12">
						<div id="containerBar"></div>
						<div id="sliders">
							<table>
								<tr><td>Ángulo Alpha</td><td><input id="R0" type="range" min="0" max="45" value="15"/> <span id="R0-value" class="value"></span></td></tr>
								<tr><td>Ángulo Beta</td><td><input id="R1" type="range" min="0" max="45" value="15"/> <span id="R1-value" class="value"></span></td></tr>
							</table>
						</div>
					</div>-->
					
					
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