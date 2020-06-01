<form action="?pag=<?php echo $crdPage->getUrl(); ?>&type=d"
      method="post" enctype="multipart/form-data" id="ocp-dell-form">
    <div class="modal fade" id="ocp-modaldell" tabindex="-1" role="dialog" aria-labelledby="ModalFormDell" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title text-primary" id="ocp-title-modalpage"><i class="fas fa-trash fa-lg text-primary"></i> Excluir Item</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        ATENCAO: Por medida de seguranca é necessário digitar sua senha de usuário para prosseguir!
                        A Exclusão desse item poderá não ser realizada caso existam dependencias no sistema atreladas a ele!
                    </p>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="form-nome">Senha de Acesso:</label>
                            <input type="password" name="form_pass" class="form-control" id="form-dell" value="" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="key_form" value="<?php echo $key_form;?>">
    <input type="hidden" name="form_id" id="form-id" value="">

</form>
