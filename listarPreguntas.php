<?php
    include_once("js/confirmarBorrar.js");


    // Obtengo el nombre de la coleccion
    if (!isset($_SESSION)){
        session_start();
        $page = $_SESSION["page"];
        $_SESSION["page"] = "listarPreguntas.php";
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


      function mostrarPreguntas() {

        $filtro =  $_SESSION["filtro"];

        // Obtengo el nombre de la coleccion
        $nombreColeccion = $_SESSION["coleccion"];

        $link = conectarBBDD();
        // Añadir esta linea de codigo para poner acentos y ñ
        mysqli_query($link, "SET NAMES 'utf8'");

        if($filtro == "Monedas"){
            $query="SELECT IdPregunta, Enunciado, Monedas, Fallos, Aciertos FROM preguntas
            WHERE NombreColeccion = '$nombreColeccion' ORDER BY Monedas ASC";           
        }else if ($filtro == "Acertadas"){
            $query="SELECT IdPregunta, Enunciado, Monedas, Fallos, Aciertos FROM preguntas
            WHERE NombreColeccion = '$nombreColeccion' ORDER BY Aciertos DESC";
        }else if ($filtro == "Falladas"){
            $query="SELECT IdPregunta, Enunciado, Monedas, Fallos, Aciertos FROM preguntas
            WHERE NombreColeccion = '$nombreColeccion' ORDER BY Fallos DESC";
        }else if ($filtro == ""){
            $query="SELECT IdPregunta, Enunciado, Monedas, Fallos, Aciertos FROM preguntas
            WHERE NombreColeccion = '$nombreColeccion' ORDER BY IdPregunta ASC";
        }else{
            $query="SELECT IdPregunta, Enunciado, Monedas, Fallos, Aciertos FROM preguntas
            WHERE NombreColeccion = '$nombreColeccion' AND DificultadPregunta='$filtro' ORDER BY IdPregunta ASC";
        }

        if ($result = mysqli_query($link, $query)) {

            // fetch associative array 
            while ($row = mysqli_fetch_assoc($result)) {
                $idPregunta = $row["IdPregunta"];
                $enunciado = $row["Enunciado"];
                $monedas = $row["Monedas"]; 
				$fallos = $row["Fallos"];
				$aciertos = $row["Aciertos"];

                echo '
                <div class="col-md-3 col-sm-6">
                    <div class="single-shop-product">

                        <div class="product-upper">';
                            echo "<a href='pasarColeccionPregunta.php?nombreColeccion=$nombreColeccion&idPregunta=$idPregunta'>";
                                echo"<textarea id='billing_enunciado' name='billing_enunciado' rows='5' maxlength='300'> $enunciado</textarea>";
                            echo '</a>
                        </div>';
                        echo "<h2> $monedas monedas <br> $aciertos Aciertos / $fallos Fallos</h2>";						
                       echo '
                        <div class="product-option-shop">';
                            echo "<a class='add_to_cart_button' 
                            href='pasarColeccionPregunta.php?nombreColeccion=$nombreColeccion&idPregunta=$idPregunta'> DETALLES </a> ";
                            echo " <a class='add_to_cart_button' 
                            href='eliminarPregunta.php?nombreColeccion=$nombreColeccion&idPregunta=$idPregunta'
                            onclick='return confirmarBorrarPregunta();'> ELIMINAR </a>";
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
                        <li><a href="estadisticasProfesor.php">Estadísticas</a></li>
                        <li><a href="crearColeccion.php">Nueva Coleccion</a></li>
                    </ul>
                </div>  
            </div>
        </div>
    </div> <!-- End mainmenu area -->


<?php

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
                        <h2>
                            <strong>Preguntas de 
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
                        <option value=""> Filtrar por... </option>
                        <option value="Fácil"> Fácil </option>
                        <option value="Medio"> Medio </option>
                        <option value="Difícil"> Difícil </option>
                        <option value="Monedas"> Monedas </option>
                        <option value="Acertadas"> Acertadas </option>
                        <option value="Falladas"> Falladas </option>
                    </select>
                    <input type="submit" value="Buscar">
                    <a href="crearPregunta.php"> Nueva Pregunta</a>

                </form>
            </div>


            <br>
            <div class="row">

                <?php
                    mostrarPreguntas();
                ?>


<!--

                <div class="col-md-3 col-sm-6">
                    <div class="single-shop-product">

                        <div class="product-upper">
                            <a href="detallesPregunta.php">
                                <textarea id="billing_enunciado" name="billing_enunciado" rows="5" maxlength="300" 
                                placeholder="Aqui ira el enunciado de la preguntaa" required></textarea>
                            </a>
                        </div>
                        <h2># monedas</h2> 
                        
                        <div class="product-option-shop">
                            <a class="add_to_cart_button" href="#">MODIFICAR</a>
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