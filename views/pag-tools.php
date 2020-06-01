<?php
//default var view page
$view_data   = null;
$lst_regioes = null;

//security verify
if(isset($loggedUser) && isset($ctSecurity)){
    $impUser    =  new ImpUsuarioDao($ctSecurity);
    $impRegiao  =  new ImpCidadeDao($loggedUser);
    $crdPage    =  new CTCredencialSystem('tools', 1, '12');
    $ctSecurity -> accessVerificationSecurity($loggedUser, $crdPage);

    //default stances of page
    $lst_regioes = $impRegiao->findAll();

    //submit form primary create - update - delete
    if(isset($_POST['key_form']) && !empty($_POST['key_form'])):
        CTSecuritySystem::validateFormSubmit($_POST['key_form']);

        //default form inputs
        $form_nome = isset($_POST['nome'])    ? CTSecuritySystem::validateFormInput($_POST['nome'])    : null;
        $form_cpf  = isset($_POST['cpf'])     ? CTSecuritySystem::validateFormInput($_POST['cpf'])     : '';
        $form_mail = isset($_POST['email'])   ? CTSecuritySystem::validateFormInput($_POST['email'])   : '';
        $form_perf = isset($_POST['perfil'])  ? CTSecuritySystem::validateFormInput($_POST['perfil'])  : 3;
        $form_regi = isset($_POST['regiao'])  ? CTSecuritySystem::validateFormInput($_POST['regiao'])  : 1;
        $form_pass = isset($_POST['senha'])   ? CTSecuritySystem::validateFormInput($_POST['senha'])   : '';
        $form_modp = isset($_POST['modpass']) ? CTSecuritySystem::validateFormInput($_POST['modpass']) : false;
        $form_stat = isset($_POST['status'])  ? CTSecuritySystem::validateFormInput($_POST['status'])  : false;
        $form_vinc = '';
        $form_levl = '0-@#$-';

        //verify form multiple chooses
        foreach($_POST['vinculo'] as $v):
            $form_vinc .= $v.'-@#$-';
        endforeach;
        $form_vinc = substr($form_vinc, 0, -5);

        foreach(EntiteUsuario::getArSystemNiveis() as $k=>$v):
            if(isset($_POST['nivel'.$k])):
                $form_levl .= $k.'-@#$-';
            endif;
        endforeach;
        $form_levl = substr($form_levl, 0, -5);

        //defaul form objects
        $entiteUsuario = new EntiteUsuario(0,$form_nome,$form_cpf,$form_mail,md5($form_cpf),md5($form_pass),$form_modp,
        $form_levl,$form_stat,$form_modp,CTTimeManagerSystem::convertDataDB(CTTimeManagerSystem::getDataNow()),CTTimeManagerSystem::convertDataDB(CTTimeManagerSystem::getDataNow()),$form_regi,$form_vinc);

        if(isset($_GET['type']) && $_GET['type'] == 'c'){
            if($impUser->insere($entiteUsuario)){
                $ctAlerts->sendAlertReload('SUCCESS', '001');
            }else{
                $ctAlerts->sendAlertReload('WARNING', '002');
            }
        }
        elseif(isset($_GET['type']) && $_GET['type'] == 'u'){
            $form_id = isset($_POST['form_id']) ? CTSecuritySystem::validateFormInput($_POST['form_id']) : 0;
            $entiteUsuario->setId($form_id);

            if($impUser->update($entiteUsuario)){
                $ctAlerts->sendAlertReload('SUCCESS', '001');
            }else{
                $ctAlerts->sendAlertReload('WARNING', '002');
            }
        }
        elseif(isset($_GET['type']) && $_GET['type'] == 'd'){
            $form_id   = isset($_POST['form_id']) ? CTSecuritySystem::validateFormInput($_POST['form_id']) : 0;
            $form_pass = md5(isset($_POST['form_pass']) ? CTSecuritySystem::validateFormInput($_POST['form_pass']) : '');
            $entiteUsuario->setId($form_id);

            if($form_pass == $loggedUser->getIdPass()) {
                if ($impUser->delete($form_id)) {
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
        CTSecuritySystem::validateFormSubmit($_POST['key_form']);
        $form_searc = isset($_POST['searc']) ? CTSecuritySystem::validateFormInput($_POST['searc']) : '';
    }

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
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h6 class="modal-title text-primary" id="ocp-title-modalpage"><i class="fas fa-address-card fa-lg text-primary"></i> Adicionar Novo Usuário</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="progress" id="ocp-progress-bar">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="form-nome-user">Nome</label>
                            <input type="text" name="nome" class="form-control text-uppercase" id="form-nome-user" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="form-cpf-user">CPF</label>
                            <input type="text" name="cpf" class="form-control" id="form-cpf-user" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="form-email-user">E-mail</label>
                            <input type="email" name="email" class="form-control" id="form-email-user" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="form-perfil-user">Perfil</label>
                            <select id="form-perfil-user" name="perfil" class="form-control text-uppercase" required>
                                <option selected>Escolha...</option>
                                <?php if($loggedUser->getArSystemPerfisSafeMode()!=null):foreach ($loggedUser->getArSystemPerfisSafeMode() as $key=> $value): ?>
                                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="form-vinculo-user">Região</label>
                            <select id="form-vinculo-user" name="regiao" class="form-control text-uppercase ocp-setload-cidades" ocpsetload="escolas" ocpuser="<?=$loggedUser->getId();?>">
                                <option selected>Escolha...</option>
                                <?php if($lst_regioes != null): foreach ($lst_regioes as $v): ?>
                                    <option value="<?=$v->getId();?>"><?=$v->getNome();?></option>
                                <?php endforeach; endif;?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="form-escolas-user">Vinculo</label>
                            <select id="form-escolas-user" name="vinculo[]" class="form-control text-uppercase ocp-getload-escolas" multiple size="2">
                                <option selected>Escolha...</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="form-pass-user">Senha de Acesso</label>
                            <input type="text" name="senha" class="form-control" id="form-pass-user" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="form-mod-user">Modificar Senha ao Acessar</label>
                            <select id="form-mod-user" name="modpass" class="form-control text-uppercase" required>
                                <option>Escolha...</option>
                                <?php foreach (EntiteUsuario::getArStatusBox() as $k=>$v): ?>
                                    <option value="<?=$k;?>"><?=$v;?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="form-status-user">Status do Usuario</label>
                            <select id="form-status-user" name="status" class="form-control text-uppercase" required>
                                <option>Escolha...</option>
                                <?php foreach (EntiteUsuario::getArStatusBox() as $k=>$v): ?>
                                    <option value="<?=$k;?>"><?=$v;?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="form-row">
                        <span class="badge badge-pill badge-primary">Nivel Acesso</span>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="form-check form-check-inline col-md-2">
                            <input class="form-check-input" type="checkbox" name="form_check_nivel" id="ocp-checkz" value="0" checked>
                            <label class="form-check-label" for="ocp-checkz">INICIAL</label>
                        </div>
                        <?php foreach (EntiteUsuario::getArSystemNiveis() as $k=>$v): ?>
                        <div class="form-check form-check-inline col-md-2">
                            <input class="form-check-input ocp-nivel-check" type="checkbox" name="nivel<?php echo $k; ?>" id="ocp-check<?php echo $k; ?>" value="<?php echo $k; ?>">
                            <label class="form-check-label" for="ocp-check<?php echo $k; ?>"><?php echo $v; ?></label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="key_form" value="<?php echo $key_form;?>">
</form>

<!-- view itens page -->
<div class="card shadow-sm rounded" id="ocp-cardpage">
    <div class="card-header">
        <i class="fas fa-cogs fa-lg text-dark"></i> <span class="font-weight-bold text-dark">Configuracoes</span>
        <div class="btn-group btn-group-sm float-md-right" role="group" aria-label="Nav-Pag">
            <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#ocp-modalpageform"><i class="fas fa-plus-circle text-light"></i> Add User</button>
            <button type="button" class="btn btn-sm btn-secondary"><i class="fas fa-edit text-light"></i> Editar</button>
            <button type="button" class="btn btn-sm btn-secondary"><i class="fas fa-trash text-light"></i> Excluir</button>
            <button type="button" class="btn btn-sm btn-secondary"><i class="fas fa-tools text-light"></i> Manutencao</button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table table-borderless">
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
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2 col" type="search" placeholder="Filtrar Resultados" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Filtrar</button>
            <input type="hidden" name="key_form_filter" value="<?php echo $key_form;?>">
        </form>
    </div>
</div>

<!-- condition by load functions -->
<?php if($view_upd != null): ?>
    <script type="text/javascript" src="../libs/js/ocpdev/active-function-condition.js"></script>
<?php endif; ?>