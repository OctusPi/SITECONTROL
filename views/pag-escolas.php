<?php

//default var view page
$view_data = null;
$view_upd  = null;

//security verify
if(isset($loggedUser) && isset($ctSecurity)){
    $inpEscola    = new ImpEscolaDao($loggedUser);
    $inpCidades   = new ImpCidadeDao($loggedUser);
    $view_cidades = $inpCidades->findAll();

    $crdPage      =  new CTCredencialSystem('escolas', 1, '2');
    $ctSecurity   -> accessVerificationSecurity($loggedUser, $crdPage);

    //submit form primary create - update - delete
    if(isset($_POST['key_form']) && !empty($_POST['key_form'])):
        CTSecuritySystem::validateFormSubmit($_POST['key_form']);

        //default form inputs
        $form_nome   = isset($_POST['escola'])   ? CTSecuritySystem::validateFormInput($_POST['escola'])   : '';
        $form_inep   = isset($_POST['inep'])     ? CTSecuritySystem::validateFormInput($_POST['inep'])     : '';
        $form_end    = isset($_POST['endereco']) ? CTSecuritySystem::validateFormInput($_POST['endereco']) : '';
        $form_cidade = isset($_POST['cidade'])   ? CTSecuritySystem::validateFormInput($_POST['cidade'])   : 0;
        $form_email  = isset($_POST['email'])    ? CTSecuritySystem::validateFormInput($_POST['email'])    : false;
        $form_tel    = isset($_POST['telefone']) ? CTSecuritySystem::validateFormInput($_POST['telefone']) : false;

        //defaul form objects
        $entiteEscola =  new EntiteEscola(0,$form_cidade,$form_inep,$form_nome,$form_end,$form_tel,$form_email);

        if(isset($_GET['type']) && $_GET['type'] == 'c'){
            if($inpEscola->insere($entiteEscola)){
                $ctAlerts->sendAlertReload('SUCCESS', '001');
            }else{
                $ctAlerts->sendAlertReload('WARNING', '002');
            }
        }
        elseif(isset($_GET['type']) && $_GET['type'] == 'u'){
            $form_id = isset($_POST['form_id']) ? CTSecuritySystem::validateFormInput($_POST['form_id']) : 0;
            $entiteEscola->setId($form_id);

            if($inpEscola->update($entiteEscola)){
                $ctAlerts->sendAlertReload('SUCCESS', '001');
            }else{
                $ctAlerts->sendAlertReload('WARNING', '002');
            }
        }
        elseif(isset($_GET['type']) && $_GET['type'] == 'd'){
            $form_id   = isset($_POST['form_id']) ? CTSecuritySystem::validateFormInput($_POST['form_id']) : 0;
            $form_pass = md5(isset($_POST['form_pass']) ? CTSecuritySystem::validateFormInput($_POST['form_pass']) : '');
            $entiteEscola->setId($form_id);

            if($form_pass == $loggedUser->getIdPass()) {
                if ($inpEscola->delete($form_id)) {
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

        $form_search1 = isset($_POST['search1']) ? CTSecuritySystem::validateFormInput($_POST['search1']) : '';
        $view_data    = $inpEscola->findByParam($form_search1);
    }else{
        $view_data = $inpEscola->findAll();
    }

    //reload page update data target
    if(isset($_GET['updtarget'])):
        $updtarget = !empty($_GET['updtarget']) ? CTSecuritySystem::validateFormInput($_GET['updtarget']) : null;
        $view_upd  = $inpEscola->findById($updtarget);
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
                    <h6 class="modal-title text-primary" id="ocp-title-modalpage"><i class="fas fa-home fa-lg text-primary"></i> <?php if($view_upd == null){echo 'Adicionar';}else{echo'Editar';}?> Escola</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label for="form-nome">Nome</label>
                            <input type="text" name="escola" class="form-control text-uppercase" id="form-nome" value="<?php if($view_upd != null){echo $view_upd->getNome();} ?>" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="form-inep">INEP</label>
                            <input type="text" name="inep" class="form-control text-uppercase" id="form-inep" maxlength="8" value="<?php if($view_upd != null){echo $view_upd->getCodInep();} ?>" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label for="form-endereco">Endereco</label>
                            <input type="text" name="endereco" class="form-control text-uppercase" id="form-endereco" value="<?php if($view_upd != null){echo $view_upd->getEndereco();} ?>" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="form-cidade">Cidade</label>
                            <select id="form-cidade" name="cidade" class="form-control" required>
                                <?php if($view_cidades != null): foreach ($view_cidades as $cidade): ?>
                                    <option value="<?php echo $cidade->getId(); ?>" <?php if($view_upd != null && $view_upd->getCidade()->getId() == $cidade->getId()){echo 'selected';}?> <?php if($cidade->getStatus() == false){echo 'disabled';}?>><?php echo $cidade->getNome(); ?></option>
                                <? endforeach; endif;?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label for="form-email">E-mail</label>
                            <input type="email" name="email" class="form-control" id="form-email" value="<?php if($view_upd != null){ echo $view_upd->getEmail(); } ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="form-telefone">Telefone</label>
                            <input type="tel" name="telefone" class="form-control text-uppercase" id="form-telefone" value="<?php if($view_upd != null){ echo $view_upd->getTelefone(); } ?>">
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
        <i class="fas fa-home fa-lg text-dark"></i> <span class="font-weight-bold text-dark">Escolas</span>
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
                    <th scope="col">Inep</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Cidade</th>
                    <th scope="col">Endereco</th>
                    <th scope="col">Telefone</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if($view_data != null):
                    $count = 1;
                    foreach ($view_data as $obj):
                        ?>
                        <tr class="ocp-line-table text-uppercase" ocp-value="<?php echo $obj->getId();?>">
                            <th class="ocp-rounded-firt" scope="row"><?php echo $count++;?></th>
                            <td><?php echo $obj->getCodInep();?></td>
                            <td><?php echo $obj->getNome();?></td>
                            <td><?php echo $obj->getCidade()->getNome();?></td>
                            <td><?php echo $obj->getEndereco();?></td>
                            <td class="ocp-rounded-last"><?php echo $obj->getTelefone();?></td>
                        </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <!-- form filter page -->
        <form action="?pag=<?php echo $crdPage->getUrl(); ?>" method="post" enctype="multipart/form-data" class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2 col" name="search1" type="search" placeholder="Filtrar Resultados: Inep ou Nome" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Filtrar</button>
            <input type="hidden" name="key_form_filter" value="<?php echo $key_form;?>">
        </form>
    </div>
</div>

<!-- condition by load functions -->
<?php if($view_upd != null): ?>
    <script type="text/javascript" src="../libs/js/ocpdev/active-function-condition.js"></script>
<?php endif; ?>