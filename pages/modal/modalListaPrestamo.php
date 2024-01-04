<?php $path = isset($url) ? $url : ""; ?>
<div class="modal fade" role="dialog" id="modalListaPrestamo">
    <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

            <div class="modal-header headerForm text-light">
                
                <h4> <img src="<?php echo $path;?>images/addSocio.png" class="itemsLine" />
                    Listado de socios
                </h4>
                <button class="close" data-dismiss="modal" id="btnCerrarPrestamo">&times;</button>
            </div>

            <div class="modal-body">
                <?php 
                    include "listaSociosA.php";
                 ?>
            </div>

            <!--<div class="modal-footer">
                <button class="btn btn-primary">Cerrar</button>
            </div>-->
        </div>
    </div>
</div>