<?php

    include_once("conectar.php");

    $link = conectarBBDD();

    // Añadir esta linea de codigo para poner acentos y ñ
    mysqli_query($link, "SET NAMES 'utf8'");

    if (!isset($_SESSION)){
        session_start();

    }


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Tras 20 min de inactividad se cierra la sesion automaticamente.
    if(isset($_SESSION["ultimoAcceso_mc"])){
        $antes =  $_SESSION["ultimoAcceso_mc"];
    }else{
        $antes = date("Y-n-j H:i:s"); 
    }
    $ahora = date("Y-n-j H:i:s");
    $tiempo_transcurrido = (strtotime($ahora)-strtotime($antes));
    //echo "Hora inicial = $antes \n ahora=$ahora";
    //comparamos el tiempo transcurrido 
    if($tiempo_transcurrido >= 1200) { //900seg=15min 20min=1200
        echo '
        <script language="javascript">
            alert("SU SESIÓN HA EXPIRADO\nUsted ha estado inactivo por más de 20 minutos.\nInicie sesión nuevamente.");
            window.location ="cerrarSesion.php";
        </script> 
            ';
    } else {
        $_SESSION["ultimoAcceso_mc"] = $ahora;
    }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    if (isset($_SESSION["loginAlumno"])) {
        $perfil = "miPerfilAlumno.php";
        $usuario = $_SESSION["usuario"];
        $buscar = "SELECT FotoAlumno FROM alumnos WHERE UsuarioAlumno='$usuario'";
        $resultado = mysqli_query( $link, $buscar);
        $array = mysqli_fetch_array($resultado);
        $foto = $array[0];
        /* liberar la serie de resultados */
        mysqli_free_result($resultado);
    }

    // Cerrar conexion con la bbdd
    mysqli_close($link);


?>


<div class="col-sm-6">
        <div class="shopping-item-mio">
            <table cellspacing="0" >
                <tr class="cart_item">
                <!--
                    <td class="product-thumbnailmensaje">
                        <a ><img width="105" height="105" alt="poster_1_up" 
                            class="shop_thumbnail" title="Mensaje" type="image" src="img/mensaje.png"></a>
                    </td>
                -->
                    <td class="product-thumbnail">
                        <a ><img width="145" height="145" alt="poster_1_up" 
                            class="usuario" title="Usuario" type="image" src="<?php echo "$foto"?>"></a>
                    </td>
                     <td class="product-name">
                        <label>&nbsp;<?php echo "$usuario"?>&nbsp;&nbsp;</label>

                    </td>
                     <td class="product-thumbnailmini">
                        <a>
                            <img width="145" height="145" alt="poster_1_up" class="shop_thumbnail" title="Salir" type="image" src="img/salir.png">
                        </a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>