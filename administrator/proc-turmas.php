<?php
include_once('autoload.php');

$sectPolicy = new SecurityPolicy();
$daoUsuario = new DaoUsuario();
$sectMsg    = new SecurityMsg();
$mngLog     = new ManagerLog();
$daoEscola  = new DaoEscola();
$daoSeries  = new DaoSeries();
$daoTurma   = new DaoTurma();
$backPag    = md5('turmas');
$fabUsuario = null;

if($sectPolicy->verifySession()){
    $fabUsuario = $daoUsuario->getUserByLogin($_SESSION[$sectPolicy->getIndexSuser()], $_SESSION[$sectPolicy->getIndexSpass()]);
    $sectPolicy-> gateGuardian($fabUsuario, 2, '3', 'proc-logoff.php?code=error0002');
}else{
    echo '<script> location.replace("proc-logoff.php"); </script>';
}

if(isset($_GET['mod']) && $_GET['mod'] == 'n'){
    $escola = isset($_POST['turma_escola']) ? SecurityPolicy::validateInput($_POST['turma_escola']) : 0;
    $serie  = isset($_POST['turma_serie']) ? SecurityPolicy::validateInput($_POST['turma_serie']) : 0;
    $turno  = isset($_POST['turma_turno']) ? SecurityPolicy::validateInput($_POST['turma_turno']) : 0;
    $status = isset($_POST['turma_status']) ? SecurityPolicy::validateInput($_POST['turma_status']) : true;
    $latter = $_POST['turmar_latter'];

    $rscEscola = $daoEscola->consultRegisterById($escola);
    $rscSerie  = $daoSeries->consultRegisterById($serie);

    foreach ($latter as $v):
        $fabTurma = new FabTurma(0, $rscEscola, $rscSerie, $v, $turno, $status);
        if($daoTurma->newRegister($fabTurma)):
            $mngLog ->gravaLog($fabUsuario, '../files/', 'Adicionou Nova Turma na '.$rscEscola->getNome().' Serie: '.$rscSerie->getNome().' Letra: '.$v);
        endif;
    endforeach;
    echo '<script> location.replace("home.php?pag='.$backPag.'"); </script>';

}elseif(isset($_GET['mod']) && $_GET['mod'] == 'u'){
    $escola = isset($_POST['turma_escola']) ? SecurityPolicy::validateInput($_POST['turma_escola']) : 0;
    $serie  = isset($_POST['turma_serie']) ? SecurityPolicy::validateInput($_POST['turma_serie']) : 0;
    $turno  = isset($_POST['turma_turno']) ? SecurityPolicy::validateInput($_POST['turma_turno']) : 0;
    $status = isset($_POST['turma_status']) ? SecurityPolicy::validateInput($_POST['turma_status']) : true;
    $latter = $_POST['turmar_latter'];
    $index  = isset($_POST['valindex']) ? SecurityPolicy::validateInput($_POST['valindex']) : 0;

    $rscEscola = $daoEscola->consultRegisterById($escola);
    $rscSerie  = $daoSeries->consultRegisterById($serie);


        $fabTurma = new FabTurma($index, $rscEscola, $rscSerie, $latter, $turno, $status);
        if($daoTurma->upRegister($fabTurma)):
            $mngLog ->gravaLog($fabUsuario, '../files/', 'Editou Dados Turma na '.$rscEscola->getNome().' Serie: '.$rscSerie->getNome().' Letra: '.$v);
        endif;
    echo '<script> location.replace("home.php?pag='.$backPag.'"); </script>';

}elseif(isset($_GET['mod']) && $_GET['mod'] == 'd'){

    $id = isset($_GET['valindex']) ? SecurityPolicy::validateInput($_GET['valindex']) : 0;

    if($daoTurma-> delRegister($id)):
        $mngLog ->gravaLog($fabUsuario, '../files/', 'Delete Info Turma');
    endif;
    echo '<script> location.replace("home.php?pag='.$backPag.'"); </script>';

}else{
    echo '<script> location.replace("proc-logoff.php"); </script>';
}