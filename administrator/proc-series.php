<?php
include_once('autoload.php');

$sectPolicy = new SecurityPolicy();
$daoUsuario = new DaoUsuario();
$sectMsg    = new SecurityMsg();
$mngLog     = new ManagerLog();
$daoObject  = new DaoSeries();
$backPag    = md5('series');
$fabUsuario = null;

if($sectPolicy->verifySession()){
    $fabUsuario = $daoUsuario->getUserByLogin($_SESSION[$sectPolicy->getIndexSuser()], $_SESSION[$sectPolicy->getIndexSpass()]);
    $sectPolicy-> gateGuardian($fabUsuario, 0, '3', 'proc-logoff.php?code=error0002');
}else{
    echo '<script> location.replace("proc-logoff.php"); </script>';
}

if(isset($_GET['mod']) && $_GET['mod'] == 'n'){

    $nome = isset($_POST['serie_nome']) ? SecurityPolicy::validateInput($_POST['serie_nome']) : '';
    $nivl = isset($_POST['serie_nivel']) ? SecurityPolicy::validateInput($_POST['serie_nivel']) : '';
    $stat = isset($_POST['serie_status']) ? SecurityPolicy::validateInput($_POST['serie_status']) : true;

    $fabSerie = new FabSeries(0, $nome, $nivl, $stat);
    if($daoObject->newRegister($fabSerie)):
        $mngLog ->gravaLog($fabUsuario, '../files/', 'Cadastrou Nova Série');
    endif;
    echo '<script> location.replace("home.php?pag='.$backPag.'"); </script>';

}elseif(isset($_GET['mod']) && $_GET['mod'] == 'u'){

    $nome = isset($_POST['serie_nome']) ? SecurityPolicy::validateInput($_POST['serie_nome']) : '';
    $nivl = isset($_POST['serie_nivel']) ? SecurityPolicy::validateInput($_POST['serie_nivel']) : '';
    $stat = isset($_POST['serie_status']) ? SecurityPolicy::validateInput($_POST['serie_status']) : true;
    $id   = isset($_POST['valindex']) ? SecurityPolicy::validateInput($_POST['valindex']) : 0;

    $fabSerie = new FabSeries($id, $nome, $nivl, $stat);
    if($daoObject->upRegister($fabSerie)):
        $mngLog ->gravaLog($fabUsuario, '../files/', 'Editou Info Série');
    endif;
    echo '<script> location.replace("home.php?pag='.$backPag.'"); </script>';

}elseif(isset($_GET['mod']) && $_GET['mod'] == 'd'){
    $id = isset($_POST['valindex']) ? SecurityPolicy::validateInput($_POST['valindex']) : 0;
    $pass = isset($_POST['pass_delete']) ? md5(SecurityPolicy::validateInput($_POST['pass_delete'])) : null;

    if($pass == $fabUsuario->getIdpass()){
        if($daoObject-> delRegister($id)):
            $mngLog ->gravaLog($fabUsuario, '../files/', 'Deletou Cidade');
        endif;
        echo '<script> location.replace("home.php?pag='.$backPag.'"); </script>';
    }else{
        $sectMsg->createMsg('error0005');
        echo '<script> location.replace("home.php?pag='.$backPag.'"); </script>';
    }
}else{
    echo '<script> location.replace("proc-logoff.php"); </script>';
}