<?php
    include_once("js/confirmarBorrar.js");
    

    if (!isset($_SESSION)){
        session_start();
        $page = $_SESSION["page"];
        $_SESSION["page"] = "listarFichas.php";
        //echo $_SESSION["super"];
    }

    if (!isset($_SESSION['coleccion'])) {
        header("Location: $page");
    } 
    
    if (!$_SESSION["loginProfesor"]) {
        header("Location: $page");
    }



    if(isset($_POST['billing_tipo'])){
        $filtro = $_POST['billing_tipo'];
        $_SESSION["filtro"] = $filtro;
    }else{
        $_SESSION["filtro"] = "";
    }

    


    function mostrarFichas() {

        //$usuario = $_SESSION["usuario"];

        $filtro =  $_SESSION["filtro"];

        // Obtengo el nombre de la coleccion
        $nombreColeccion = $_SESSION['coleccion'];

        $link = conectarBBDD();
        // Añadir esta linea de codigo para poner acentos y ñ
        mysqli_query($link, "SET NAMES 'utf8'");


        if($filtro == ""){
            $query="SELECT  IdFicha, FotoFicha, NumeroFicha FROM fichas
            WHERE NombreColeccion = '$nombreColeccion' ORDER BY NumeroFicha ASC, IdFicha ASC";            
        }else{
            $query="SELECT  IdFicha, FotoFicha, NumeroFicha FROM fichas
            WHERE NombreColeccion = '$nombreColeccion' AND DificultadFicha='$filtro' ORDER BY NumeroFicha ASC, IdFicha ASC";
        }

        if ($result = mysqli_query($link, $query)) {

            // fetch associative array 
            while ($row = mysqli_fetch_assoc($result)) {
                $idFicha = $row["IdFicha"];
                $foto = $row["FotoFicha"];
				$orden = $row["NumeroFicha"];
				
				

                echo '
                <div class="col-md-3 col-sm-6">
                    <div class="single-shop-product">';
					echo     "<label> $orden </label>";
                 echo ' <div class="product-upper">';							
                            echo "<a href='pasarColeccionFicha.php?nombreColeccion=$nombreColeccion&idFicha=$idFicha'>";
                                echo "<img class='imagenUsuario' src='$foto' alt=''>";
                            echo '</a>
                        </div>';
                        
                        echo '
                        <div class="product-option-shop">';
                            echo "<a class='add_to_cart_button' 
                            href='pasarColeccionFicha.php?nombreColeccion=$nombreColeccion&idFicha=$idFicha'> DETALLES </a> ";
                            echo " <a class='add_to_cart_button' 
                            href='eliminarFicha.php?nombreColeccion=$nombreColeccion&idFicha=$idFicha'
                            onclick='return confirmarBorrarFicha();'> ELIMINAR </a>";
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
                        <li><a href="inicioProfesor.php"><i class="fa fa-home fa-fw" aria-hidden="true"></i>&nbsp;Inicio</a></li>
                        <li><a href="listarAlumnos.php">Alumnos</a></li>
                        <li><a href="listarColecciones.php">Colecciones</a></li>
                        <li><a href="#">Estadísticas</a></li>
                        <li><a href="crearColeccion.php">Nueva Coleccion</a></li>
                    </ul>
                </div>  
            </div>
        </div>
    </div> <!-- End mainmenu area -->


<?php
    // Obtengo el nombre de la coleccion
    $nombreColeccion = $_SESSION['coleccion'];
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
                        <h2>
                            <strong>Fichas de 
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


            <div class="single-sidebar2">
                <form action="" method="post" enctype="multipart/form-data" >
                    <select id="billing_tipo" name="billing_tipo">
                        <option value=""> Filtrar por nivel de dificultad... </option>
                        <option value="Fácil"> Fácil </option>
                        <option value="Medio"> Medio </option>
                        <option value="Difícil"> Difícil </option>
                    </select>
                    <input type="submit" value="Buscar">
                    <a href="crearFicha.php"> Nueva Ficha</a>
                </form>
            </div>


            <br>
            <div class="row">

                <?php
                    mostrarFichas();
                ?>


<!--
                <div class="col-md-3 col-sm-6">
                    <div class="single-shop-product">
                        <div class="product-upper">
                            <a href="detallesFicha.php">
                                <img class="imagenUsuario" src="img/colecciones/coleccionIcono.png" alt="">
                            </a>
                        </div>
                        <h2>Ficha # </h2> 
                        
                        <div class="product-option-shop">
                            <a class="add_to_cart_button" href="#">DETALLES</a>
                            <a class="add_to_cart_button" href="#" >ELIMINAR</a>
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