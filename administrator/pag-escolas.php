<?
try {
    if (isset($sectPolicy)) {
        //ACCESS ONLY ANY STAGE TWU
        $sectPolicy->gateGuardian($fabUsuario, 1, '2', 'proc-logoff.php?code=error0002');
    } else {
        echo '<script> location.replace("proc-logoff.php"); </script>';
    }
} catch (Exception $e) {
    echo '<script> location.replace("proc-logoff.php"); </script>';
}

$backPag   = md5('escolas');
$daoMunicp = new DaoMunicipio();
$daoObject = new DaoEscola();

$rscMun    = $daoMunicp->consultRegisterByAccess($fabUsuario);
$rscObj    = null;
$updItem   = null;

if (isset($_POST['object_search']) && !empty($_POST['object_search'])) {
    $search = SecurityPolicy::validateInput($_POST['object_search']);
    $rscObj = $daoObject->consultRegister($fabUsuario, $search);
} else {
    $page    = isset($_GET['pageview']) ? SecurityPolicy::validateInput($_GET['pageview']) : 1;
    $mnPages = new ManegerPagination($daoObject->consultRegister($fabUsuario, null), 10, 20);
    $rscObj  = $mnPages->getListPagination($page);
}

if (isset($_GET['valindex'])):
    $valindex = SecurityPolicy::validateInput($_GET['valindex']);
    $updItem = $daoObject->consultRegisterById($fabUsuario, $valindex);
endif;
?>
<!--alert ui interation-->
<div class="alert alert-warning alert-dismissible fade show ocp-alert" role="alert">
    <strong>Atenção!</strong> Você deve primeiro selecionar o item!.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<!--alert confirm action-->
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="proc-escolas.php?mod=d" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDeletelLongTitle">Exclusão Permanente de Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Ao confirmar o item será apagado definitivamente do sistema e isso  poderá ocasionar falhas relacionais!</p>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="inputDelete">Por segurança digite sua senha!</label>
                            <input type="password" name="pass_delete" class="form-control" id="inputDelete"
                                   value="" required>

                        </div>
                        <input type="hidden" name="valindex" id="id_delete" value="">
                        <input type="hidden" name="tokenform" value="<?=$tokenfm;?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn ocp-confirm-delete btn-danger">Confirmar</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!--pag header nav action-->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Escolas</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <button class="btn btn-sm ocp-btn-show btn-outline-secondary"><span data-feather="plus-square"></span> Adicionar</button>
            <button class="btn btn-sm ocp-btn-edit btn-outline-secondary" valurl="?pag=<?= $backPag ?>&valindex="><span data-feather="edit-2"></span> Editar</button>
            <button class="btn btn-sm ocp-btn-delete btn-outline-danger"><span data-feather="trash-2"></span> Apagar</button>
        </div>
    </div>
</div>

<div class="card <? if ($updItem == null): echo 'ocp-hide '; endif; ?>">
    <h5 class="card-header"><? if ($updItem == null) {
            echo 'Cadastrar Escola';
        } else {
            echo 'Editar Escola';
        } ?></h5>
    <div class="card-body">
        <form action="proc-escolas.php?mod=<? if ($updItem == null) {
            echo 'n';
        } else {
            echo 'u';
        } ?>" method="post" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="inputCidade">Cidade</label>
                    <select name="escola_cidade" class="form-control custom-select text-uppercase" id="inputCidade" required>
                        <?if($rscMun != null): foreach ($rscMun as $v):?>
                            <option value="<?=$v->getId();?>" <?if($v->getStatus() == false):echo 'disabled'; endif;?>
                            <?if($updItem != null && $updItem->getCidade()->getId() == $v->getId()){ echo 'selected';}?>>
                            <?=$v->getCidade();?>
                            </option>
                        <?endforeach; endif;?>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="inputInep">INEP</label>
                    <input type="text" name="escola_inep" class="form-control" id="inputInep"
                           value="<? if ($updItem != null): echo $updItem->getInep(); endif; ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEscola">Escola</label>
                    <input type="text" name="escola_nome" class="form-control text-uppercase" id="inputEscola"
                           value="<? if ($updItem != null): echo $updItem->getNome(); endif; ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="inputEndereco">Endereço</label>
                    <input type="text" name="escola_endereco" class="form-control text-uppercase" id="inputEndereco"
                           value="<? if ($updItem != null): echo $updItem->getEndereco(); endif; ?>" required>
                </div>
                <div class="form-group col-md-2">
                    <label for="inputTelefone">Telefone</label>
                    <input type="text" name="escola_telefone" class="form-control text-uppercase" id="inputTelefone"
                           value="<? if ($updItem != null): echo $updItem->getTelefone(); endif; ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="inputEmail">E-mail</label>
                    <input type="text" name="escola_email" class="form-control" id="inputEmail"
                           value="<? if ($updItem != null): echo $updItem->getEmail(); endif; ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="inputEncarregado">Encarregado</label>
                    <input type="text" name="escola_encarregado" class="form-control" id="inputEncarregado"
                           value="<? if ($updItem != null): echo $updItem->getEncarregado(); endif; ?>" required>
                </div>
            </div>
            <input type="hidden" name="tokenform" value="<?=$tokenfm;?>">
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
                <span class="col-md-6">Cidades Cadastradas</span>
                <div class="col-md-6 text-lg-right">
                    <input class="form-control mr-sm-2" type="text" name="object_search" placeholder="INEP ou Escola"
                           aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><span
                                data-feather="search"></span></button>
                </div>
            </form>
        </div>
    </h5>
    <div class="card-body">
        <table class="table table-hover">
            <thead class="thead-light">
            <tr>
                <th scope="col">Cidade</th>
                <th scope="col">Inep</th>
                <th scope="col">Escola</th>
                <th scope="col">Endereço</th>
                <th scope="col">Email</th>
                <th scope="col">Telefone</th>
                <th scope="col">Responsável</th>
            </tr>
            </thead>
            <tbody>
            <? if ($rscObj != null): foreach ($rscObj as $v): ?>
                <tr valindex="<?= $v->getId(); ?>">
                    <th scope="row" class="text-uppercase rounded-left"><?=$v->getCidade()->getCidade();?></th>
                    <td><?=$v->getInep(); ?></td>
                    <td class="text-uppercase"><?= $v->getNome();?></td>
                    <td><?= $v->getEndereco(); ?></td>
                    <td><?= $v->getEmail(); ?></td>
                    <td><?=$v->getTelefone();?></td>
                    <td class="rounded-right"><?=$v->getEncarregado();?></td>
                </tr>
            <? endforeach; endif;?>
            </tbody>
        </table>
    </div>

    <?if((!isset($_POST['object_search']) or empty($_POST['object_search'])) && $rscObj != null):?>
        <nav aria-label="page navigation" class="div-pagination">
            <ul class="pagination justify-content-center">
                <li class="page-item <?if(!isset($_GET['pageview']) or ($_GET['pageview'] == 1 or $mnPages->getNumberPages() == 1)){echo 'disabled';}?>">
                    <a class="page-link" href="?pag=<?=$backPag?>&&pageview=<?=$page-1;?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
                <?for($i=1; $i<=$mnPages->getNumberPages(); $i++):?>
                    <li class="page-item <?if($page == $i){echo 'active';}?>"><a class="page-link" href="?pag=<?=$backPag?>&pageview=<?=$i;?>"><?=$i;?></a></li>
                <?endfor;?>
                <li class="page-item <?if((isset($_GET['pageview']) && $_GET['pageview'] == $mnPages->getNumberPages()) or $mnPages->getNumberPages() == 1){echo 'disabled';}?>">
                    <a class="page-link" href="?pag=<?=$backPag?>&&pageview=<?=$page+1;?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            </ul>
        </nav>
    <?endif;?>

</div>
