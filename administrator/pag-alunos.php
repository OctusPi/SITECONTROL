<?
try {
    if (isset($sectPolicy)) {
        $sectPolicy->gateGuardian($fabUsuario, 2, '4', 'proc-logoff.php?code=error0002');
    } else {
        echo '<script> location.replace("proc-logoff.php"); </script>';
    }
} catch (Exception $e) {
    echo '<script> location.replace("proc-logoff.php"); </script>';
}

$backPag   = md5('alunos');
$updItem   = null;
$daoEscola = new DaoEscola();
$daoSeries = new DaoSeries();
$daoTurma  = new DaoTurma();

$rcsEscola = $daoEscola->consultRegisterByAccess($fabUsuario);
$rcsSerie  = $daoSeries->consultRegister();
$rcsTurma  = null;


if (isset($_POST['escola_search']) && isset($_POST['serie_search'])) {
    $escola_search = SecurityPolicy::validateInput($_POST['escola_search']);
    $serie_search  = SecurityPolicy::validateInput($_POST['serie_search']);
    $rcsTurma = $daoTurma->consultRegister($escola_search, $serie_search);
} else {
    $rcsTurma = $daoTurma->consultRegister();
}

if (isset($_GET['valindex'])):
    $valindex = SecurityPolicy::validateInput($_GET['valindex']);
    $updItem = $daoTurma->consultRegisterById($valindex);
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
                Ao confirmar o item será apagado definitivamente do sistema e poderá ocasionar falhas relacionais!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" valurl="proc-series.php?mod=d&valindex="
                        class="btn ocp-confirm-delete btn-danger">Confirmar
                </button>
            </div>
        </div>
    </div>
</div>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Alunos</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <button class="btn btn-sm ocp-btn-show btn-outline-secondary">Novo</button>
            <button class="btn btn-sm ocp-btn-transferir btn-outline-secondary">Transferir</button>
            <button class="btn btn-sm ocp-btn-importar btn-outline-secondary">Importar</button>
            <button class="btn btn-sm ocp-btn-edit btn-outline-secondary" valurl="?pag=<?= $backPag ?>&valindex=">
                Editar
            </button>
            <button class="btn btn-sm ocp-btn-delete btn-outline-secondary">Deletar</button>
        </div>
    </div>
</div>

<div class="card <? if ($updItem == null): echo 'ocp-hide '; endif; ?>">
    <h5 class="card-header"><? if ($updItem == null) {
            echo 'Cadastrar Aluno';
        } else {
            echo 'Editar Aluno';
        } ?></h5>
    <div class="card-body">

        <form action="proc-turmas.php?mod=<? if ($updItem == null) {
            echo 'n';
        } else {
            echo 'u';
        } ?>" method="post" enctype="multipart/form-data">

            <div class="form-row">
                <div class="form-group col-md-8">
                    <label for="inputEscola">Escola</label>
                    <select name="turma_escola" class="form-control custom-select" id="inputEscola" required>
                        <?foreach ($rcsEscola as $k=>$v):?>
                            <option value="<?=$v->getId();?>" <?//if($updItem != null && $updItem->getTurno() == $k){echo 'selected';}?>><?=$v->getNome();?></option>
                        <?endforeach;?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputSerie">Série</label>
                    <select name="turma_serie" class="form-control custom-select" id="inputSerie" required>
                        <?foreach ($rcsSerie as $k=>$v):?>
                            <option value="<?=$v->getId();?>" <?//if($updItem != null && $updItem->getTurno() == $k){echo 'selected';}?>><?=$v->getNome().' - '.FabSeries::getNiveisExt($v->getNivel());?></option>
                        <?endforeach;?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="inputTurno">Turno</label>
                    <select name="turma_turno" class="form-control custom-select" id="inputTurno" required>
                        <?foreach (FabTurma::getTurnos() as $k=>$v):?>
                            <option value="<?=$k;?>" <?//if($updItem != null && $updItem->getNivel() == $k){echo 'selected';}?>><?=$v;?></option>
                        <?endforeach;?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputStatus">Status</label>
                    <select name="turma_status" class="form-control custom-select" id="inputStatus" required>
                        <option value="0" <?//if($updItem != null && $updItem->getNivel() == $k){echo 'selected';}?>>INATIVO</option>
                        <option value="1" <?//if($updItem != null && $updItem->getNivel() == $k){echo 'selected';}?>>ATIVO</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputLatter">Letras</label>
                    <select multiple name="turmar_latter[]" class="form-control custom-select" id="inputLatter" required>
                        <?foreach (FabTurma::getLatters() as $v):?>
                            <option value="<?=$v;?>" <?//if($updItem != null && $updItem->getNivel() == $k){echo 'selected';}?>><?=$v;?></option>
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
                <span class="col-md-4">Buscar Turmas Cadastradas</span>
                <div class="col-md-8 text-lg-right">
                    <select class="form-control custom-select mr-sm-2" name="escola_search" aria-label="Escola Search">
                        <option value=""></option>
                        <?foreach ($rcsEscola as $v):?>
                            <option value="<?=$v->getId();?>"><?=$v->getNome();?></option>
                        <?endforeach;?>
                    </select>
                    <select class="form-control custom-select mr-sm-2" name="serie_search" aria-label="Serie Search">
                        <option value=""></option>
                        <?foreach ($rcsSerie as $v):?>
                            <option value="<?=$v->getId();?>"><?=$v->getNome().' - '.FabSeries::getNiveisExt($v->getNivel());?></option>
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
            <thead class="thead-dark">
            <tr>
                <th scope="col">Nome</th>
                <th scope="col">Nasc</th>
                <th scope="col">Escola</th>
                <th scope="col">Serie</th>
                <th scope="col">Turma</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>