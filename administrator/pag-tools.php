<?
try {
    if (isset($sectPolicy)) {
        $sectPolicy->gateGuardian($fabUsuario, 0, '10', 'proc-logoff.php?code=error0002');
    } else {
        echo '<script> location.replace("proc-logoff.php"); </script>';
    }
} catch (ErrorException $e) {
    echo '<script> location.replace("proc-logoff.php"); </script>';
}

$backPag     = md5('tools');
$updItem     = null;
$daoEscola   = new DaoEscola();
$daoUsuarios = new DaoUsuario();
$rscEscola   = $daoEscola->consultRegister();

if (isset($_POST['usuario_search']) && !empty($_POST['usuario_search'])) {
    $search = SecurityPolicy::validateInput($_POST['usuario_search']);
    $rscUsuarios = $daoUsuarios->consultRegister($search);
} else {
    $rscUsuarios = $daoUsuarios->consultRegister();
}

if (isset($_GET['valindex'])):
    $valindex = SecurityPolicy::validateInput($_GET['valindex']);
    $updItem = $daoUsuarios->consultRegisterById($valindex);
endif;

?>
<div class="alert alert-warning alert-dismissible fade show ocp-alert" role="alert">
    <strong>Atenção!</strong> Você deve primeiro selecionar o item!.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDeletelLongTitle">Exclusão Permanente de Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Ao confirmar o usuário será apagado definitivamente do sistema e esta ação não poderá ser desfeita!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" valurl="proc-tools.php?mod=d&valindex="
                        class="btn ocp-confirm-delete btn-danger">Confirmar
                </button>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Administração</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <button class="btn btn-sm ocp-btn-show btn-outline-secondary">Nova</button>
            <button class="btn btn-sm ocp-btn-edit btn-outline-secondary" valurl="?pag=<?= $backPag ?>&valindex=">Editar</button>
            <button class="btn btn-sm ocp-btn-delete btn-outline-secondary">Deletar</button>
        </div>
        <button class="btn btn-sm btn-outline-secondary">
            <span data-feather="upload"></span>
            Extrair Base
        </button>
    </div>
</div>
<div class="card <?if($updItem == null): echo 'ocp-hide'; endif;?>">
    <h5 class="card-header"><?if($updItem == null){ echo 'Cadastrar Usuário';}else{echo 'Editar Usuário';}?></h5>
    <div class="card-body">
        <form action="proc-tools.php?mod=<?if($updItem == null){echo 'n';}else{echo 'u';}?>" method="post" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="inputNome">Nome</label>
                    <input type="text" name="user_nome" class="form-control text-uppercase" id="inputNome"
                           placeholder="Nome Completo" required value="<?if($updItem != null): echo $updItem->getNome(); endif;?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="inputEmail">E-mail</label>
                    <input type="email" name="user_mail" class="form-control" id="inputEmail"
                           placeholder="E-mail" required value="<?if($updItem != null): echo $updItem->getEmail(); endif;?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="inputCpf">CPF</label>
                    <input type="text" name="user_cpf" class="form-control" id="inputCpf"
                           placeholder="Digite sem pontos e traço" required value="<?if($updItem != null): echo $updItem->getCpf(); endif;?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="inputPass">Senha de Acesso</label>
                    <input type="text" name="user_pass" class="form-control" id="inputPass"
                           placeholder="Password" <?if($updItem == null): echo 'required'; endif;?>>
                </div>
                <div class="form-group col-md-4">
                    <label class="mr-sm-2" for="selectPerfil">Perfil de Acesso</label>
                    <select name="user_perfil" class="custom-select mr-sm-2" id="selectPerfil">
                        <? foreach (FabUsuario::getPerfis() as $k => $v): ?>
                            <option value="<?= $k; ?>" <?if($updItem != null && $updItem->getPerfil() == $k):echo 'selected';endif;?>><?= $v; ?></option>
                        <? endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label class="mr-sm-2" for="btnNiveis">Níveis de Acesso</label>
                    <div>
                        <button class="btn btn-secondary col-md-12" id="btnNiveis" type="button"
                                data-toggle="collapse"
                                data-target="#collapseExample" aria-expanded="false"
                                aria-controls="collapseExample">
                            Niveis de Acesso: Multipla Marcação
                        </button>
                        <div class="collapse" id="collapseExample">
                            <div class="card card-body bg-light">
                                <ul class="ocp-list-table">
                                <? foreach (FabUsuario::getNiveis(0) as $k => $v): ?>
                                    <li class="custom-control custom-checkbox">
                                        <input type="checkbox" name="<?= 'user_niveis' . $k; ?>"
                                               class="custom-control-input" id="<?= 'user_niveis' . $k; ?>"
                                               value="<?= $k; ?>" <?if($updItem != null && in_array($k, $updItem->getNivel())):echo'checked';endif;?>>
                                        <label class="custom-control-label"
                                               for="<?= 'user_niveis' . $k; ?>"><?= $v; ?></label>
                                    </li>
                                <? endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label class="mr-sm-2" for="btnEscolas">Escolas de Vinculo</label>
                    <div>
                        <button class="btn btn-secondary col-md-12" id="btnEscolas" type="button"
                                data-toggle="collapse"
                                data-target="#collapseEscolas" aria-expanded="false"
                                aria-controls="collapseEscolas">
                            Selecione as Unidades de Ensino que o Usuário está Vinculado
                        </button>
                        <div class="collapse" id="collapseEscolas">
                            <div class="card card-body bg-light">
                                <ul class="ocp-list-table-large">
                                <? if($rscEscola != null): foreach ($rscEscola as $v): ?>
                                    <li class="custom-control custom-checkbox">
                                        <input type="checkbox" name="<?= 'user_vinculo' . $v->getId(); ?>"
                                               class="custom-control-input" id="<?= 'user_vinculo' . $v->getId(); ?>"
                                               value="1" <?if($updItem != null && in_array($v->getId(), $updItem->getVinculo())):echo'checked';endif;?>>
                                        <label class="custom-control-label"
                                               for="<?= 'user_vinculo' . $v->getId(); ?>"><?= $v->getNome(); ?></label>
                                    </li>
                                <? endforeach; endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="inputUppass">Mudar Senha no Primeiro Acesso?</label>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="inputUppass1" name="user_uppass" value="1"
                               class="custom-control-input" <?if($updItem == null){echo'checked';}else{if($updItem->getUppass() == true){echo'checked';}}?>>
                        <label class="custom-control-label" for="inputUppass1">SIM</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="inputUppass2" name="user_uppass" value="0"
                               class="custom-control-input" <?if($updItem != null && $updItem->getUppass() == false){echo 'checked';}?>>
                        <label class="custom-control-label" for="inputUppass2">NÃO</label>
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputStatus">Status</label>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="inputStatus1" name="user_status" value="1"
                               class="custom-control-input" <?if($updItem == null){echo'checked';}else{if($updItem->getStatus() == true){echo'checked';}}?>>
                        <label class="custom-control-label" for="inputStatus1">Acesso Ativo</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="inputStatus2" name="user_status" value="0"
                               class="custom-control-input" <?if($updItem != null && $updItem->getStatus() == false){echo 'checked';}?>>
                        <label class="custom-control-label" for="inputStatus2">Acesso Bloqueado</label>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <? if ($updItem != null): ?>
                <a href="?pag=<?= $backPag; ?>" class="btn btn-secondary">Voltar</a>
                <input type="hidden" name="valindex" value="<?= $updItem->getId(); ?>">
            <? endif; ?>
        </form>
    </div>
</div>
<div class="ocp-table card">
    <h5 class="card-header">
        <div class="align-items-sm-end">
            <form action="?pag=<?= $backPag; ?>" method="post" enctype="multipart/form-data"
                  class="form-inline mt-2 mt-md-0 form-row">
                <span class="col-md-6">Usuarios Cadastradas</span>
                <div class="col-md-6 text-lg-right">
                    <input class="form-control mr-sm-2" type="text" name="usuario_search" placeholder="CPF ou Nome"
                           aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><span
                                data-feather="search"></span></button>
                </div>
            </form>
        </div>
    </h5>
    <div class="card-body">
        <table class="table table-hover">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Nome</th>
                <th scope="col">CPF</th>
                <th scope="col">Email</th>
                <th scope="col">Perfil</th>
                <th scope="col">Status</th>
            </tr>
            </thead>
            <tbody>
            <? if ($rscUsuarios != null): foreach ($rscUsuarios as $v): ?>
                <tr valindex="<?= $v->getId(); ?>">
                    <th scope="row"><?= $v->getNome(); ?></th>
                    <td><?= $v->getCpf(); ?></td>
                    <td><?= $v->getEmail(); ?></td>
                    <td><?= FabUsuario::getPerfis()[$v->getPerfil()]; ?></td>
                    <td><?= FabUsuario::getStuser()[$v->getStatus()]; ?></td>
                </tr>
            <? endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</div>