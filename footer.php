<?php

    function mostrarVisitas(){
        $archivo = "contadorDeVisitas.txt"; 
        $fp = fopen($archivo,"r"); 
        $contador = fgets($fp, 26); 
        fclose($fp);
        echo "Esta página ha sido visitada <strong> $contador </strong> veces";

    }
     
?>
<div class="footer-bottom-area">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="copyright">
                    <p>&copy; 2017 Colecciona. All Rights Reserved.</p>
                </div>
            </div>
            
            
            <div class="col-md-4">
                <div class="copyright">
                    <p>
                        <?php
                            mostrarVisitas();
                        ?>
                    </p>
                </div>
                <!--
                <div class="footer-card-icon">
                    <i class="fa fa-cc-discover"></i>
                    <i class="fa fa-cc-mastercard"></i>
                    <i class="fa fa-cc-paypal"></i>
                    <i class="fa fa-cc-visa"></i>
                </div>
                -->
            </div>
        
        </div>
    </div>
</div> <!-- End footer bottom area -->