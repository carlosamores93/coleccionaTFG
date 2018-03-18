<?php

    if (!isset($_SESSION)){
        session_start();
        $page = $_SESSION["page"];
        $_SESSION["page"] = "detallesAlumnoColeccion.php";
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
    $query="SELECT NombreAlumno, ApellidosAlumno, FotoAlumno, CorreoAlumno
    FROM alumnos WHERE UsuarioAlumno = '$usuario' ";
    if ($result = mysqli_query($link, $query)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $nombre = $row["NombreAlumno"];
            $apellidos = $row["ApellidosAlumno"];
            $foto = $row["FotoAlumno"];
            $correo = $row["CorreoAlumno"];
        }
        // free result set 
        mysqli_free_result($result);
    }
    

    // Obtener el nombre de la coleccion
    $coleccion = $_SESSION["coleccion"];


    // Obtenemos el estado del alumnos
    $sql="SELECT EstadoColeccion, FichasConseguidas, Monedas, Vidas 
    FROM juega_colecciones 
    WHERE NombreColeccion ='$coleccion' AND UsuarioAlumno = '$usuario'";
    if ($res = mysqli_query($link, $sql)) {

        // fetch associative array  Esto solo da una vuelta.
        while ($row = mysqli_fetch_assoc($res)) {
            $estadoColeccion =$row["EstadoColeccion"];
            $fichasConseguidas =$row["FichasConseguidas"];
            $monedasColeccion =$row["Monedas"];
            $vidasColeccion =$row["Vidas"];
        }
        // free result set 
        mysqli_free_result($res);
    }

    $sql="SELECT SUM(Correcta) AS CorrectaColeccion
    FROM actividad_alumnos 
    WHERE NombreColeccion ='$coleccion' AND UsuarioAlumno = '$usuario'";
    if ($res = mysqli_query($link, $sql)) {

        // fetch associative array  Esto solo da una vuelta.
        while ($row = mysqli_fetch_assoc($res)) {
            $acertadasColeccion =$row["CorrectaColeccion"];
            }
        mysqli_free_result($res);
    }

    $sql="SELECT SUM(Incorrecta1)+SUM(Incorrecta2)+SUM(Incorrecta3) AS IncorrectaColeccion
    FROM actividad_alumnos 
    WHERE NombreColeccion ='$coleccion' AND UsuarioAlumno = '$usuario'";
    if ($res = mysqli_query($link, $sql)) {

        // fetch associative array  Esto solo da una vuelta.
        while ($row = mysqli_fetch_assoc($res)) {
            $falladasColeccion =$row["IncorrectaColeccion"];
            }
        mysqli_free_result($res);
    }



    $sql="SELECT SUM(TimeOut) AS TimeOutColeccion
    FROM actividad_alumnos 
    WHERE NombreColeccion ='$coleccion' AND UsuarioAlumno = '$usuario'";
    if ($res = mysqli_query($link, $sql)) {

        // fetch associative array  Esto solo da una vuelta.
        while ($row = mysqli_fetch_assoc($res)) {
            $timeOutColeccion =$row["TimeOutColeccion"];
            }
        mysqli_free_result($res);
    }





    $query = "SELECT NombreColeccionCorrecto FROM colecciones WHERE NombreColeccion = '$coleccion' ";
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
                        <h2><strong>Colección: 
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
    </div>
	
   
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
                                                if($estadoColeccion == "juego"){
                                                    echo "
                                                     <a class='add_to_cart_button' href='bloquearAlumno.php?usuario=$usuario&coleccion=$coleccion&perfil=si' >BLOQUEAR</a>
                                                     ";
                                                }else if ($estadoColeccion == "bloqueada"){
                                                    echo "
                                                         <a class='add_to_cart_button' href='desbloquearAlumno.php?usuario=$usuario&coleccion=$coleccion&perfil=si' >DESBLOQUEAR</a>
                                                         ";
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
                                                        <font color="#5a88ca">
                                                            <label>
                                                                <h4>
                                                                    <strong>
                                                                        <?php echo "$estadoColeccion";?>
                                                                    </strong>
                                                                </h4>
                                                            </label>
                                                        </font>
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
                                                        <h3>Fichas conseguidas</h3>
                                                        <font color="#5a88ca">
                                                            <label>
                                                                <h4>
                                                                    <strong>
                                                                        <?php echo "$fichasConseguidas";?>
                                                                    </strong>
                                                                </h4>
                                                            </label>
                                                        </font>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <h3>Vidas</h3>
                                                        <font color="#5a88ca">
                                                            <label>
                                                                <h4>
                                                                    <strong>
                                                                        <?php echo "$vidasColeccion";?>
                                                                    </strong>
                                                                </h4>
                                                            </label>
                                                        </font>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <h3>Monedas</h3>
                                                        <font color="#5a88ca">
                                                            <label>
                                                                <h4>
                                                                    <strong>
                                                                        <?php echo "$monedasColeccion";?>
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
                                                                        <?php echo "$acertadasColeccion";?>
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
                                                                        <?php echo "$falladasColeccion";?>
                                                                    </strong>
                                                                </h4>
                                                            </label>
                                                        </font>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <h3>Time out </h3>
                                                        <font color="#5a88ca">
                                                            <label>
                                                                <h4>
                                                                    <strong>
                                                                        <?php echo "$timeOutColeccion";?>
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