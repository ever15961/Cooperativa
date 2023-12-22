<?php $path = isset($url) ? $url : ""; ?>
<div class="modal fade" role="dialog" id="modalRegistroUsuario">
    <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

            <div class="modal-header headerForm text-light">
                
                <h4> <img src="<?php echo $path;?>images/addSocio.png" class="itemsLine" />
                    Registro de usuarios
                </h4>
                <button class="close" data-dismiss="modal" id="btnCerrarUsuario">&times;</button>
            </div>

            <div class="modal-body">
                <?php include "formularioUsuario.php"; ?>
            </div>

            <!--<div class="modal-footer">
                <button class="btn btn-primary">Cerrar</button>
            </div>-->
        </div>
    </div>
</div>
