<?php
//default var view page
$view_data = null;
$view_upd  = null;

//security verify
if(isset($loggedUser) && isset($ctSecurity)){
    $impRegiao  =  new ImpCidadeDao($loggedUser);

    $crdPage    =  new CTCredencialSystem('regioes', 0, '1');
    $ctSecurity -> accessVerificationSecurity($loggedUser, $crdPage);

    //submit form primary create - update - delete
    if(isset($_POST['key_form']) && !empty($_POST['key_form'])):
        CTSecuritySystem::validateFormInput($_POST['key_form']);

        //default form inputs
        $form_cnpj   = isset($_POST['cnpj'])   ? CTSecuritySystem::validateFormInput($_POST['cnpj'])   : '';
        $form_regiao = isset($_POST['regiao']) ? CTSecuritySystem::validateFormInput($_POST['regiao']) : '';
        $form_uf     = isset($_POST['estado']) ? CTSecuritySystem::validateFormInput($_POST['estado']) : '';
        $form_status = isset($_POST['status']) ? CTSecuritySystem::validateFormInput($_POST['status']) : false;

        //defaul form objects
        $entiteRegiao =  new EntiteCidade(0, $form_cnpj, $form_regiao, $form_uf, $form_status);

        if(isset($_GET['type']) && $_GET['type'] == 'c'){
            if($impRegiao->insere($entiteRegiao)){
                $ctAlerts->sendAlertReload('SUCCESS', '001');
            }else{
                $ctAlerts->sendAlertReload('WARNING', '002');
            }
        }
        elseif(isset($_GET['type']) && $_GET['type'] == 'u'){
            $form_id = isset($_POST['form_id']) ? CTSecuritySystem::validateFormInput($_POST['form_id']) : 0;
            $entiteRegiao->setId($form_id);

            if($impRegiao->update($entiteRegiao)){
                $ctAlerts->sendAlertReload('SUCCESS', '001');
            }else{
                $ctAlerts->sendAlertReload('WARNING', '002');
            }
        }
        elseif(isset($_GET['type']) && $_GET['type'] == 'd'){
            $form_id   = isset($_POST['form_id']) ? CTSecuritySystem::validateFormInput($_POST['form_id']) : 0;
            $form_pass = md5(isset($_POST['form_pass']) ? CTSecuritySystem::validateFormInput($_POST['form_pass']) : '');
            $entiteRegiao->setId($form_id);

            if($form_pass == $loggedUser->getIdPass()) {
                if ($impRegiao->delete($form_id)) {
                    $ctAlerts->sendAlertReload('SUCCESS', '001');
                } else {
                    $ctAlerts->sendAlertReload('WARNING', '002');
                }
            }else{
                $ctAlerts->sendAlertReload('WARNING', '011');
            }
        }
        CTSecuritySystem::redirectionPage('?pag='.$crdPage->getUrl());
    endif;

    //submit-form filter views
    if(isset($_POST['key_form_filter']) && !empty($_POST['key_form_filter'])){
        CTSecuritySystem::validateFormSubmit($_POST['key_form_filter']);

        $form_searc1 = isset($_POST['search1']) ? CTSecuritySystem::validateFormInput($_POST['search1']) : '';
        $view_data   = $impRegiao->findByParam($form_searc1);
    }else{
        $view_data = $impRegiao->findAll();
    }

    //reload page update data target
    if(isset($_GET['updtarget'])):
        $updtarget = !empty($_GET['updtarget']) ? CTSecuritySystem::validateFormInput($_GET['updtarget']) : null;
        $view_upd  = $impRegiao->findById($updtarget);
    endif;

}else{
    CTSecuritySystem::forceOutInvalidaSecurity();
}
?>

<!-- form security dell item -->
<?php include_once ('abs-secdell-form.php');?>

<!-- navigation top -->
<?php include_once('navigation-min.php'); ?><hr>


<!-- form principal page -->
<form action="?pag=<?php echo $crdPage->getUrl(); ?>&type=<?php if($view_upd == null){echo 'c';}else{echo'u';}?>"
      method="post" enctype="multipart/form-data" id="ocp-form-page">
    <div class="modal fade" id="ocp-modalpageform" tabindex="-1" role="dialog" aria-labelledby="ModalPageForm" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title text-primary" id="ocp-title-modalpage"><i class="fas fa-map-marker-alt fa-lg text-primary"></i> <?php if($view_upd == null){echo 'Adicionar';}else{echo'Editar';}?> Região</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="form-cpj">Cnpj</label>
                            <input type="text" name="cnpj" class="form-control text-uppercase" id="form-cpj" value="<?php if($view_upd != null){echo $view_upd->getCnpj();} ?>" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="form-nome">Região</label>
                            <input type="text" name="regiao" class="form-control" id="form-nome" value="<?php if($view_upd != null){echo $view_upd->getNome();} ?>" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="form-estado">UF</label>
                            <input type="text" name="estado" class="form-control" id="form-estado" value="<?php if($view_upd != null){echo $view_upd->getEstado();} ?>" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="form-status">Status</label>
                            <select id="form-status" name="status" class="form-control" required>
                                <option selected>Escolha...</option>
                                <option value="0" <?php if($view_upd!= null && $view_upd->getStatus() == false){echo 'selected';} ?>>INATIVO</option>
                                <option value="1" <?php if($view_upd!= null && $view_upd->getStatus() == true){echo 'selected';} ?>>ATIVO</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <?php if($view_upd != null){ ?>
                        <a href="?pag=<?php echo $crdPage->getUrl(); ?>" class="btn btn-secondary">Fechar</a>
                    <?php } else{ ?>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <?php } ?>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="key_form" value="<?php echo $key_form;?>">
    <?php if($view_upd != null): ?>
        <input type="hidden" name="form_id" value="<?php echo $view_upd->getId();?>">
    <?php endif; ?>
</form>

<!-- view itens page -->
<div class="card shadow-sm rounded" id="ocp-cardpage">
    <div class="card-header">
        <i class="fas fa-map-marker-alt fa-lg text-dark"></i> <span class="font-weight-bold text-dark">Regiões</span>
        <div class="btn-group btn-group-sm float-md-right" role="group" aria-label="Nav-Pag">
            <button type="button" class="btn btn-sm btn-secondary ocp-crt-button" data-toggle="modal" data-target="#ocp-modalpageform"><i class="fas fa-plus-circle text-light"></i> Adicionar</button>
            <button type="button" class="btn btn-sm btn-secondary ocp-upd-button" ocp-url-target="?pag=<?php echo $crdPage->getUrl();?>"><i class="fas fa-edit text-light"></i> Editar</button>
            <button type="button" class="btn btn-sm btn-secondary ocp-del-button"><i class="fas fa-trash text-light"></i> Excluir</button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table">
                <thead class="font-weight-bold">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">CNPJ</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Status</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if($view_data != null):
                    $count = 1;
                    foreach ($view_data as $obj):
                ?>
                <tr class="ocp-line-table" ocp-value="<?php echo $obj->getId();?>">
                    <th class="ocp-rounded-firt" scope="row"><?php echo $count++;?></th>
                    <td><?php echo $obj->getCnpj();?></td>
                    <td><?php echo $obj->getNome();?></td>
                    <td><?php echo $obj->getEstado();?></td>
                    <td class="ocp-rounded-last"><?php echo $obj->getStringStatus($obj->getStatus());?></td>
                </tr>
                <?php endforeach; endif; ?>
                </tbody>
            </table>
    </div>
    </div>
    <div class="card-footer">
        <!-- form filter page -->
        <form action="?pag=<?php echo $crdPage->getUrl(); ?>" method="post" enctype="multipart/form-data" class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2 col" name="search1" type="search" placeholder="Filtrar Resultados: Nome Região" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Filtrar</button>
            <input type="hidden" name="key_form_filter" value="<?php echo $key_form;?>">
        </form>
    </div>
</div>

<!-- condition by load functions -->
<?php if($view_upd != null): ?>
    <script type="text/javascript" src="../libs/js/ocpdev/active-function-condition.js"></script>
<?php endif; ?>
