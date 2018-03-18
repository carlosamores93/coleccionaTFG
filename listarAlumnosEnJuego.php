<?php
    if (!isset($_SESSION)){
        session_start();
        $page = $_SESSION["page"];
        $_SESSION["page"] = "listarAlumnosEnJuego.php";
        //echo $_SESSION["super"];
    }

    if (!$_SESSION["loginProfesor"]) {
        header("Location: $page");
    }


    if(isset($_POST['billing_tipo_search']) || isset($_POST['billing_tipo'])){
            // Vamos a obtener los valores del formulario para ordenar 
        $search = $_POST['billing_tipo_search'];
        $filtro = $_POST['billing_tipo'];

        //echo "$search ---------------";
        //echo "--------------$filtro";

        $_SESSION["search"] = $search;
        $_SESSION["filtro"] = $filtro;
    }else{
        $_SESSION["search"] = "";
        $_SESSION["filtro"] = "";
    }
	
		$nombreColeccion = $_SESSION["coleccion"];

    function mostrarAlumnos() {
		
		$nombreColeccion = $_SESSION["coleccion"];

        $search = $_SESSION["search"];
        $filtro =  $_SESSION["filtro"];
        //echo "$search ******************";
        //echo "**************************$filtro";

        $link = conectarBBDD();
        // Añadir esta linea de codigo para poner acentos y ñ
        mysqli_query($link, "SET NAMES 'utf8'");



        // Obtener el nombre del profesor
        $profe = $_SESSION["usuario"];

        // Aqui  mostrar los alumnos con susu detalles.
        if($search != ""){

            $query=" SELECT UsuarioAlumno, NombreAlumno, 
            ApellidosAlumno, FotoAlumno
            FROM alumnos
            WHERE UsuarioAlumno IN
            (SELECT UsuarioAlumno FROM juega_colecciones 
                        WHERE NombreColeccion ='$nombreColeccion' AND EstadoColeccion ='juego')
            AND (UsuarioAlumno LIKE '%$search%' OR NombreAlumno LIKE '%$search%' OR ApellidosAlumno LIKE '%$search%' )
            ORDER BY IdAlumno ASC";

            
        }else{
            if($filtro == "Nombre"){
                $query="SELECT UsuarioAlumno, NombreAlumno, 
                ApellidosAlumno, FotoAlumno
                FROM alumnos  WHERE  UsuarioAlumno IN 
                   (SELECT UsuarioAlumno FROM juega_colecciones 
                        WHERE NombreColeccion ='$nombreColeccion' AND EstadoColeccion ='juego')
                ORDER BY NombreAlumno ASC";
            }else if($filtro == "Apellido"){
                $query="SELECT UsuarioAlumno, NombreAlumno, 
                ApellidosAlumno, FotoAlumno
                FROM alumnos  WHERE  UsuarioAlumno IN 
                    (SELECT UsuarioAlumno FROM juega_colecciones 
                        WHERE NombreColeccion ='$nombreColeccion' AND EstadoColeccion ='juego')
                ORDER BY ApellidosAlumno ASC";
            }else if($filtro == "Usuario"){
                $query="SELECT UsuarioAlumno, NombreAlumno, 
                ApellidosAlumno, FotoAlumno
                FROM alumnos  WHERE  UsuarioAlumno IN 
                    (SELECT UsuarioAlumno FROM juega_colecciones 
                        WHERE NombreColeccion ='$nombreColeccion' AND EstadoColeccion ='juego')
                ORDER BY UsuarioAlumno ASC";
            }else if($filtro == "FechaAlta"){

                $query="SELECT UsuarioAlumno, NombreAlumno, 
                ApellidosAlumno, FotoAlumno
                FROM alumnos  WHERE  UsuarioAlumno IN 
                    (SELECT UsuarioAlumno FROM juega_colecciones 
                        WHERE NombreColeccion ='$nombreColeccion' AND EstadoColeccion ='juego')
                ORDER BY IdAlumno ASC";
                /*
                $query="SELECT alumnos.UsuarioAlumno, alumnos.NombreAlumno, 
                alumnos.ApellidosAlumno, alumnos.FotoAlumno
                FROM alumnos, mis_alumnos
                WHERE mis_alumnos.UsuarioProfesor ='$profe' AND mis_alumnos.UsuarioAlumno = alumnos.UsuarioAlumno
                ORDER BY IdAlumno ASC";
                */
            }else{

                $query="SELECT UsuarioAlumno, NombreAlumno, 
                ApellidosAlumno, FotoAlumno
                FROM alumnos  WHERE  UsuarioAlumno IN 
                    (SELECT UsuarioAlumno FROM juega_colecciones 
                        WHERE NombreColeccion ='$nombreColeccion' AND EstadoColeccion ='juego')
                ORDER BY IdAlumno ASC";

                
            }
        }


        if ($result = mysqli_query($link, $query)) {

            // fetch associative array 
            while ($row = mysqli_fetch_assoc($result)) {
                          
                $usuario = $row["UsuarioAlumno"];
                $nombre = $row["NombreAlumno"];
                $apellidos = $row["ApellidosAlumno"];
                $foto = $row["FotoAlumno"];
           
                //echo "$usuario";


                echo '
                <div class="col-md-3 col-sm-6">
                    <div class="single-shop-product">
                        <div class="product-upper">';
                            echo "<a href='pasarAlumnoColeccion.php?usuario=$usuario'> ";
                                echo "<img class='imagenUsuario' src='$foto' alt=''>
                            </a>
                        </div>";
                        echo "<h2>$nombre </h2> <h2>$apellidos</h2> ";
						echo '        
                              <div class="product-option-shop">';


                        echo "
                             <a class='add_to_cart_button' href='bloquearAlumno.php?usuario=$usuario&coleccion=$nombreColeccion' >BLOQUEAR</a>
                             ";

                        echo '</div>                    
                    </div>
                </div>';

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
    // Obtengo el nombre de la coleccion
    $nombreColeccion = $_SESSION["coleccion"];
    $link = conectarBBDD();
    // Añadir esta linea de codigo para poner acentos y ñ
    mysqli_query($link, "SET NAMES 'utf8'");
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
                        <h2><strong>
								Alumnos jugando 
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
                <div class="col-sm-8">
                    <div class="single-sidebar2">
                        <form action="" method="post" enctype="multipart/form-data" >
                            <label class="" >Buscar alumnos </label>
                            <input type="search"  placeholder="" name="billing_tipo_search" >
                            <select id="billing_tipo" name="billing_tipo">
                                <option value=""> Filtrar por... </option>
                                <option value="Nombre"> Nombre </option>
                                <option value="Apellido"> Apellido </option>
                                <option value="Usuario"> Usuario </option>
                                <option value="FechaAlta"> Fecha de alta </option>
                            </select>
                            <input type="submit" value="Buscar">
                        </form>
                    </div>
                </div>

                <div class="col-sm-4">
                    <a href="exportarInformeAlumnosJuego.php" target="_blank">
                        <p class="parrafo" ><input type="submit" value="Informe Alumnos"></p>
                    </a>
                </div>

            </div>
            


            <br>
            <div class="row">


                <?php
                    mostrarAlumnos();
                ?>


<!--
                <div class="col-md-3 col-sm-6">
                    <div class="single-shop-product">
                        <div class="product-upper">
                            <a href="detallesAlumno.php">
                                <img class="imagenUsuario" src="img/usuarios/alumnos/avatarnegro.jpg" alt="">
                            </a>
                        </div>
                         <h2>Nombre </h2> <h2>Apellidos</h2> 
                        
                        <div class="product-option-shop">
                            <a class="add_to_cart_button" href="#">ALTA</a>
                            <a class="add_to_cart_button" href="#" >BAJA</a>
                        </div>                      
                    </div>
                </div>
-->

                
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