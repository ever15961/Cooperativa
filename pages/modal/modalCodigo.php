<?php $path = isset($url) ? $url : ""; ?>
<div class="modal fade" role="dialog" id="modalCodigo">
    <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

            <div class="modal-header headerForm text-light">
                
                <h4> 
                   Ingrese el codigo
                </h4>
                <button class="close" data-dismiss="modal" id="btnCerrarCodigo">&times;</button>
            </div>

            <div class="modal-body">
                <?php 
                    include "formularioCodigo.php";
                 ?>
            </div>

            <!--<div class="modal-footer">
                <button class="btn btn-primary">Cerrar</button>
            </div>-->
        </div>
    </div>
</div>