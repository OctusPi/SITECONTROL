<?
try {
    if (isset($sectPolicy)) {
        $sectPolicy->gateGuardian($fabUsuario, 0, '3', 'proc-logoff.php?code=error0002');
    } else {
        echo '<script> location.replace("proc-logoff.php"); </script>';
    }
} catch (Exception $e) {
    echo '<script> location.replace("proc-logoff.php"); </script>';
}

$backPag   = md5('series');
$updItem   = null;
$daoSeries = new DaoSeries();

if (isset($_POST['serie_search'])) {
    $search = SecurityPolicy::validateInput($_POST['serie_search']);
    $rcsSerie = $daoSeries->consultRegister($search);
} else {
    $rcsSerie = $daoSeries->consultRegister();
}

if (isset($_GET['valindex'])):
    $valindex = SecurityPolicy::validateInput($_GET['valindex']);
    $updItem = $daoSeries->consultRegisterById($valindex);
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
        <form action="proc-series.php?mod=d" method="post" enctype="multipart/form-data">
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
    <h1 class="h2">Series e Anos</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <button class="btn btn-sm ocp-btn-show btn-outline-secondary">Nova</button>
            <button class="btn btn-sm ocp-btn-edit btn-outline-secondary" valurl="?pag=<?= $backPag ?>&valindex=">
                Editar
            </button>
            <button class="btn btn-sm ocp-btn-delete btn-outline-secondary">Deletar</button>
        </div>
    </div>
</div>
<div class="card <? if ($updItem == null): echo 'ocp-hide '; endif; ?>">
    <h5 class="card-header"><? if ($updItem == null) {
            echo 'Cadastrar Série';
        } else {
            echo 'Editar Série';
        } ?></h5>
    <div class="card-body">
        <form action="proc-series.php?mod=<? if ($updItem == null) {
            echo 'n';
        } else {
            echo 'u';
        } ?>" method="post" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="inputNome">Nome</label>
                    <input type="text" name="serie_nome" class="form-control text-uppercase" id="inputNome"
                           placeholder="Ex. 1º ANO" value="<? if ($updItem != null): echo $updItem->getNome(); endif; ?>"
                           required>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputNivel">Nivel</label>
                    <select name="serie_nivel" class="form-control custom-select" id="inputNivel" required>
                        <?foreach (FabSeries::getNiveis() as $k=>$v):?>
                            <option value="<?=$k?>" <?if($updItem != null && $updItem->getNivel() == $k){echo 'selected';}?>><?=$v;?></option>
                        <?endforeach;?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputStatus">Status</label>
                    <select name="serie_status" class="form-control custom-select" id="inputStatus" required>
                        <option value=""></option>
                        <?foreach (FabSeries::getRstats() as $k=>$v):?>
                            <option value="<?=$k?>" <?if($updItem != null && $updItem->getStatus() == $k){echo 'selected';}?>><?=$v;?></option>
                        <?endforeach;?>
                    </select>
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
                <span class="col-md-6">Series Cadastradas</span>
                <div class="col-md-6 text-lg-right">
                    <select class="form-control custom-select mr-sm-2" name="serie_search" aria-label="Search">
                        <option value=""></option>
                        <?foreach (FabSeries::getNiveis() as $k=>$v):?>
                            <option value="<?=$k;?>"><?=$v;?></option>
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
                <th scope="col">Nome</th>
                <th scope="col">Nivel</th>
                <th scope="col">Status</th>
            </tr>
            </thead>
            <tbody>
            <? if ($rcsSerie != null): foreach ($rcsSerie as $v): ?>
                <tr valindex="<?= $v->getId(); ?>">
                    <td class="rounded-left"><?= $v->getNome(); ?></td>
                    <td><?= FabSeries::getNiveisExt($v->getNivel()); ?></td>
                    <td class="rounded-right"><?= FabSeries::getRstats()[$v->getStatus()]; ?></td>
                </tr>
            <? endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</div>