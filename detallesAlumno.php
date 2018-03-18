<?php

    if (!isset($_SESSION)){
        session_start();
        $page = $_SESSION["page"];
        $_SESSION["page"] = "detallesAlumno.php";
        //echo $_SESSION["super"];
    }

    if (!isset($_SESSION['alumno'])) {
        header("Location: $page");
    } 
    
    if (!$_SESSION["loginProfesor"]) {
        header("Location: $page");
    }


    //include_once("actualizarAlumno.php");

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
                        <li ><a href="inicioProfesor.php"><i class="fa fa-home fa-fw" aria-hidden="true"></i>&nbsp;Inicio</a></li>
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

    $usuario = $_SESSION["alumno"];
    //echo "$usuario";
    ///echo "$tipo";
    $link = conectarBBDD();
    // Añadir esta linea de codigo para poner acentos y ñ
    mysqli_query($link, "SET NAMES 'utf8'");


   
    // Buscar en la tabla alumnos
    $query="SELECT NombreAlumno, ApellidosAlumno, FotoAlumno, CorreoAlumno,
    ColeccionesJuego, ColeccionesFin, NumeroFichas, PreguntasAcertadas, PreguntasFalladas
    FROM alumnos WHERE UsuarioAlumno = '$usuario' ";
    if ($result = mysqli_query($link, $query)) {
        
        // fetch associative array 
        while ($row = mysqli_fetch_assoc($result)) {
            $nombre = $row["NombreAlumno"];
            $apellidos = $row["ApellidosAlumno"];
            $foto = $row["FotoAlumno"];
            $correo = $row["CorreoAlumno"];
            $juego = $row["ColeccionesJuego"];
            $terminadas = $row["ColeccionesFin"];
            $fichas = $row["NumeroFichas"];
            $acertadas = $row["PreguntasAcertadas"];
            $falladas = $row["PreguntasFalladas"];
        }
        // free result set 
        mysqli_free_result($result);
    }
    

    // Obtener el nombre del profesor
    $profe = $_SESSION["usuario"];

    // Obtenemos el estado del alumnos
    $sql="SELECT PuedeJugar FROM mis_alumnos WHERE UsuarioProfesor ='$profe' AND UsuarioAlumno = '$usuario'";
    if ($res = mysqli_query($link, $sql)) {

        // fetch associative array  Esto solo da una vuelta.
        while ($row = mysqli_fetch_assoc($res)) {
            $puedeJugar =$row["PuedeJugar"];
        }
        // free result set 
        mysqli_free_result($res);
    }

    
    // Cerrar conexion con la bbdd
    mysqli_close($link);






?>








	<div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2><strong><?php echo "$nombre $apellidos";?></strong></h2>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End Page title area -->
	
   
    <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                              
                <div class="col-md-11">
                    <div class="product-content-right">
                                               
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="product-images">
                                    <div class="product-main-img">
                                        <img src="<?php echo "$foto";?>" alt=""><br><br>
										<div class="form-row place-order">

                                            <?php
                                                if($puedeJugar == "no"){
                                                    echo "<a class='add_to_cart_button' href='activarAlumno.php?usuario=$usuario'>
                                                        <input type='submit' value='Dar de alta' class='button' >
                                                        </a>";
                                                }else{
                                                    echo "<a class='add_to_cart_button' href='desactivarAlumno.php?usuario=$usuario'>
                                                        <input type='submit' value='Dar de baja' class='button' >
                                                        </a>";
                                                }


                                            ?>

											<br><br>






										</div>
                                    </div>
                                    
                                </div>
                            </div>
                            
							<div class="col-sm-6">
                                <div class="product-inner">
								
																 
                                    <div role="tabpanel">
                                        <ul class="product-tab" role="tablist">
                                            <li role="presentation" class="active"><a
                                            aria-controls="home" role="tab" data-toggle="tab">Detalles</a></li>
    
                                        </ul>
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane fade in active" id="detalles">
                                                
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <h3>Usuario</h3>
                                                        <font color="#5a88ca">
                                                            <label>
                                                                <h4>
                                                                    <strong>
                                                                        <?php echo "$usuario";?>
                                                                    </strong>
                                                                </h4>
                                                            </label>
                                                        </font>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <h3>Estado</h3>
                                                        <?php
                                                            if($puedeJugar == "no"){
                                                                echo '<font color="#5a88ca"><label><h4><strong>No puede jugar</strong></h4></label></font>';
                                                            }else{
                                                                echo '<font color="#5a88ca"><label><h4><strong>Puede jugar</strong></h4></label></font>';
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                            

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <h3>Nombre</h3>
                                                        <font color="#5a88ca">
                                                            <label>
                                                                <h4>
                                                                    <strong>
                                                                        <?php echo "$nombre";?>
                                                                    </strong>
                                                                </h4>
                                                            </label>
                                                        </font>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <h3>Apellidos</h3>
                                                        <font color="#5a88ca">
                                                            <label>
                                                                <h4>
                                                                    <strong>
                                                                        <?php echo "$apellidos";?>
                                                                    </strong>
                                                                </h4>
                                                            </label>
                                                        </font>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <h3>Correo</h3>
                                                        <font color="#5a88ca">
                                                            <label>
                                                                <h4>
                                                                    <strong>
                                                                        <?php echo "$correo";?>
                                                                    </strong>
                                                                </h4>
                                                            </label>
                                                        </font>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <h3>Fichas totales</h3>
                                                        <font color="#5a88ca">
                                                            <label>
                                                                <h4>
                                                                    <strong>
                                                                        <?php echo "$fichas";?>
                                                                    </strong>
                                                                </h4>
                                                            </label>
                                                        </font>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <h3>En juego</h3>
                                                        <font color="#5a88ca">
                                                            <label>
                                                                <h4>
                                                                    <strong>
                                                                        <?php echo "$juego";?>
                                                                    </strong>
                                                                </h4>
                                                            </label>
                                                        </font>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <h3>Terminadas</h3>
                                                        <font color="#5a88ca">
                                                            <label>
                                                                <h4>
                                                                    <strong>
                                                                        <?php echo "$terminadas";?>
                                                                    </strong>
                                                                </h4>
                                                            </label>
                                                        </font>
                                                    
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <h3>Preguntas acertadas</h3>
                                                        <font color="#5a88ca">
                                                            <label>
                                                                <h4>
                                                                    <strong>
                                                                        <?php echo "$acertadas";?>
                                                                    </strong>
                                                                </h4>
                                                            </label>
                                                        </font>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <h3>Preguntas falladas</h3>
                                                        <font color="#5a88ca">
                                                            <label>
                                                                <h4>
                                                                    <strong>
                                                                        <?php echo "$falladas";?>
                                                                    </strong>
                                                                </h4>
                                                            </label>
                                                        </font>
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