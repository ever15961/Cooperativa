<?php $path = isset($url) ? $url : ""; ?>
<div class="modal fade" role="dialog" id="modalEmail">
    <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

            <div class="modal-header headerForm text-light">
                
                <h4> 
                    Ingrese su correo
                </h4>
                <button class="close" data-dismiss="modal" id="btnCerrarEmail">&times;</button>
            </div>

            <div class="modal-body">
                <?php 
                    include "formularioEmail.php";
                 ?>
            </div>

            <!--<div class="modal-footer">
                <button class="btn btn-primary">Cerrar</button>
            </div>-->
        </div>
    </div>
</div>