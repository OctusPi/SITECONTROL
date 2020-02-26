<?php
include_once('autoload.php');

//instances required
$sectPolicy = new SecurityPolicy();
$daoUsuario = new DaoUsuario();
$sectMsg    = new SecurityMsg();
$mngLog     = new ManagerLog();
$daoObject  = new DaoEscola();
$backPag    = md5('escolas');
$fabUsuario = null;

//verification origin form
$tkform     = isset($_POST['tokenform']) ? SecurityPolicy::validateInput($_POST['tokenform']) : null;
SecurityPolicy::controlHackerForm($tkform, 'proc-logoff.php');

//verification security access
if($sectPolicy->verifySession()){
    $fabUsuario = $daoUsuario->getUserByLogin($_SESSION[$sectPolicy->getIndexSuser()], $_SESSION[$sectPolicy->getIndexSpass()]);
    $sectPolicy-> gateGuardian($fabUsuario, 1, '2', 'proc-logoff.php?code=error0002');
}else{
    echo '<script> location.replace("proc-logoff.php"); </script>';
}

//process control
if(isset($_GET['mod']) && $_GET['mod'] == 'n'){
    $cidade    = isset($_POST['escola_cidade']) ? SecurityPolicy::validateInput($_POST['escola_cidade']) : 0;
    $inep      = isset($_POST['escola_inep']) ? SecurityPolicy::validateInput($_POST['escola_inep']) : '';
    $escola    = isset($_POST['escola_nome']) ? SecurityPolicy::validateInput($_POST['escola_nome']) : '';
    $endereco  = isset($_POST['escola_endereco']) ? SecurityPolicy::validateInput($_POST['escola_endereco']) : '';
    $encarred  = isset($_POST['escola_encarregado']) ? SecurityPolicy::validateInput($_POST['escola_encarregado']) : '';
    $email     = isset($_POST['escola_email']) ? SecurityPolicy::validateInput($_POST['escola_email']) : '';
    $telefone  = isset($_POST['escola_telefone']) ? SecurityPolicy::validateInput($_POST['escola_telefone']) : '';

    $fabObject  = new FabEscola(0, $cidade, $inep, $escola, $endereco, $encarred, $telefone, $email);
    if($daoObject-> newRegister($fabObject)):
        $mngLog ->gravaLog($fabUsuario, '../files/', 'Adicionou Nova Escola');
    endif;
    echo '<script> location.replace("home.php?pag='.$backPag.'"); </script>';

}elseif(isset($_GET['mod']) && $_GET['mod'] == 'u'){
    $cidade    = isset($_POST['escola_cidade']) ? SecurityPolicy::validateInput($_POST['escola_cidade']) : 0;
    $inep      = isset($_POST['escola_inep']) ? SecurityPolicy::validateInput($_POST['escola_inep']) : '';
    $escola    = isset($_POST['escola_nome']) ? SecurityPolicy::validateInput($_POST['escola_nome']) : '';
    $endereco  = isset($_POST['escola_endereco']) ? SecurityPolicy::validateInput($_POST['escola_endereco']) : '';
    $encarred  = isset($_POST['escola_encarregado']) ? SecurityPolicy::validateInput($_POST['escola_encarregado']) : '';
    $email     = isset($_POST['escola_email']) ? SecurityPolicy::validateInput($_POST['escola_email']) : '';
    $telefone  = isset($_POST['escola_telefone']) ? SecurityPolicy::validateInput($_POST['escola_telefone']) : '';
    $id        = isset($_POST['valindex']) ? SecurityPolicy::validateInput($_POST['valindex']) : 0;

    $fabObject  = new FabEscola($id, $cidade, $inep, $escola, $endereco,$encarred,  $telefone, $email);
    if($daoObject-> upRegister($fabObject)):
        $mngLog ->gravaLog($fabUsuario, '../files/', 'Editou Infos Escola');
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