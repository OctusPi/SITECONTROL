<?
try {
    if (isset($sectPolicy)) {
        //ACCESS ONLY FULL ADMINISTRATION
        $sectPolicy->gateGuardian($fabUsuario, 0, '1', 'proc-logoff.php?code=error0002');
    } else {
        echo '<script> location.replace("proc-logoff.php"); </script>';
    }
} catch (Exception $e) {
    echo '<script> location.replace("proc-logoff.php"); </script>';
}

$backPag   = md5('municipios');
$daoObject = new DaoMunicipio();
$updItem   = null;
$rscObj    = null;

if (isset($_POST['object_search']) && !empty($_POST['object_search'])) {
    $search = SecurityPolicy::validateInput($_POST['object_search']);
    $rscObj = $daoObject->consultRegister($search);
} else {
    $page    = isset($_GET['pageview']) ? SecurityPolicy::validateInput($_GET['pageview']) : 1;
    $mnPages = new ManegerPagination($daoObject->consultRegister(), 10, 20);
    $rscObj  = $mnPages->getListPagination($page);
}

if (isset($_GET['valindex'])):
    $valindex = SecurityPolicy::validateInput($_GET['valindex']);
    $updItem = $daoObject->consultRegisterById($valindex);
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
        <form action="proc-municipio.php?mod=d" method="post" enctype="multipart/form-data">
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
    <h1 class="h2">Municipíos</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <button class="btn btn-sm ocp-btn-show btn-outline-secondary"><span data-feather="plus-square"></span> Adicionar</button>
            <button class="btn btn-sm ocp-btn-edit btn-outline-secondary" valurl="?pag=<?= $backPag ?>&valindex=">
                <span data-feather="edit-2"></span> Editar
            </button>
            <button class="btn btn-sm ocp-btn-delete btn-outline-danger"><span data-feather="trash-2"></span> Apagar</button>
        </div>
    </div>
</div>

<div class="card <? if ($updItem == null): echo 'ocp-hide '; endif; ?>">
    <h5 class="card-header"><? if ($updItem == null) {
            echo 'Cadastrar Cidade';
        } else {
            echo 'Editar Cidade';
        } ?></h5>
    <div class="card-body">
        <form action="proc-municipio.php?mod=<? if ($updItem == null) {
            echo 'n';
        } else {
            echo 'u';
        } ?>" method="post" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="inputPais">País</label>
                    <select name="cidade_pais" class="form-control custom-select" id="inputPais" required>
                        <?foreach (FabMunicipio::getPaises() as $k=>$v):?>
                            <option value="<?=$k?>"><?=$v;?></option>
                        <?endforeach;?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputEstado">Estado</label>
                    <select name="cidade_estado" class="form-control custom-select" id="inputEstado" required>
                        <?foreach (FabMunicipio::getEstados() as $k=>$v):?>
                            <option value="<?=$k?>" <?if($updItem != null && $updItem->getEstado() == $k){echo 'selected';}?>><?=$v;?></option>
                        <?endforeach;?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputNome">Cidade</label>
                    <input type="text" name="cidade_nome" class="form-control text-uppercase" id="inputNome"
                           value="<? if ($updItem != null): echo $updItem->getCidade(); endif; ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="inputCnpj">CNPJ</label>
                    <input type="text" name="cidade_cnpj" class="form-control" id="inputCnpj"
                           placeholder="99.999.999/9999-99"
                           value="<? if ($updItem != null): echo $updItem->getCnpj(); endif; ?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="inputStatus">Status</label>
                    <select name="cidade_status" class="form-control custom-select" id="inputStatus" required>
                        <option value=""></option>
                        <?foreach (FabMunicipio::getStatsb() as $k=>$v):?>
                            <option value="<?=$k?>" <?if($updItem != null && $updItem->getStatus() == $k){echo 'selected';}?>><?=$v;?></option>
                        <?endforeach;?>
                    </select>
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
                    <select name="object_search" class="form-control mr-sm-2 custom-select" aria-label="Search">
                        <?foreach (FabMunicipio::getEstados() as $k=>$v):?>
                            <option value="<?=$k?>" <?if(isset($_POST['object_search']) && $_POST['object_search'] == $k){echo 'selected';}?>><?=$v;?></option>
                        <?endforeach;?>
                    </select>
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
                <th scope="col" class="rounded-left">País</th>
                <th scope="col">Estado</th>
                <th scope="col">Cidade</th>
                <th scope="col">CNPJ</th>
                <th scope="col" class="rounded-right">Status</th>
            </tr>
            </thead>
            <tbody>
            <? if ($rscObj != null): foreach ($rscObj as $v): ?>
                <tr valindex="<?= $v->getId(); ?>">
                    <th scope="row" class="rounded-left"><?= FabMunicipio::getPaises()[$v->getPais()]; ?></th>
                    <td><?= FabMunicipio::getEstados()[$v->getEstado()]; ?></td>
                    <td class="text-uppercase"><?= $v->getCidade(); ?></td>
                    <td><?= $v->getCnpj(); ?></td>
                    <td class="rounded-right"><?= FabMunicipio::getStatsb()[$v->getStatus()]; ?></td>
                </tr>
            <? endforeach; endif; ?>
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
