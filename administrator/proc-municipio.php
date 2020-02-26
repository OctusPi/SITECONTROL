<?php
include_once('autoload.php');

//instances required
$sectPolicy = new SecurityPolicy();
$daoUsuario = new DaoUsuario();
$sectMsg    = new SecurityMsg();
$mngLog     = new ManagerLog();
$daoObject  = new DaoMunicipio();
$backPag    = md5('municipios');
$fabUsuario = null;

//verification origin form
$tkform     = isset($_POST['tokenform']) ? SecurityPolicy::validateInput($_POST['tokenform']) : null;
SecurityPolicy::controlHackerForm($tkform, 'proc-logoff.php');

//verification security access
if($sectPolicy->verifySession()){
    $fabUsuario = $daoUsuario->getUserByLogin($_SESSION[$sectPolicy->getIndexSuser()], $_SESSION[$sectPolicy->getIndexSpass()]);
    $sectPolicy-> gateGuardian($fabUsuario, 0, '1', 'proc-logoff.php?code=error0002');
}else{
    echo '<script> location.replace("proc-logoff.php"); </script>';
}

//process control
if(isset($_GET['mod']) && $_GET['mod'] == 'n'){
    $pais   = isset($_POST['cidade_pais']) ? SecurityPolicy::validateInput($_POST['cidade_pais']) : 0;
    $estado = isset($_POST['cidade_estado']) ? SecurityPolicy::validateInput($_POST['cidade_estado']) : 0;
    $cidade = isset($_POST['cidade_nome']) ? SecurityPolicy::validateInput($_POST['cidade_nome']) : '';
    $cnpj   = isset($_POST['cidade_cnpj']) ? SecurityPolicy::validateInput($_POST['cidade_cnpj']) : '';
    $status = isset($_POST['cidade_status']) ? SecurityPolicy::validateInput($_POST['cidade_status']) : 0;

    $fabObject  = new FabMunicipio(0, $cnpj, $pais, $estado, $cidade, $status);
    if($daoObject-> newRegister($fabObject)):
        $mngLog ->gravaLog($fabUsuario, '../files/', 'Adicionou Nova Cidade');
    endif;
    echo '<script> location.replace("home.php?pag='.$backPag.'"); </script>';

}elseif(isset($_GET['mod']) && $_GET['mod'] == 'u'){
    $pais   = isset($_POST['cidade_pais']) ? SecurityPolicy::validateInput($_POST['cidade_pais']) : 0;
    $estado = isset($_POST['cidade_estado']) ? SecurityPolicy::validateInput($_POST['cidade_estado']) : 0;
    $cidade = isset($_POST['cidade_nome']) ? SecurityPolicy::validateInput($_POST['cidade_nome']) : '';
    $cnpj   = isset($_POST['cidade_cnpj']) ? SecurityPolicy::validateInput($_POST['cidade_cnpj']) : '';
    $status = isset($_POST['cidade_status']) ? SecurityPolicy::validateInput($_POST['cidade_status']) : 0;
    $id     = isset($_POST['valindex']) ? SecurityPolicy::validateInput($_POST['valindex']) : 0;

    $fabObject  = new FabMunicipio($id, $cnpj, $pais, $estado, $cidade, $status);
    if($daoObject-> upRegister($fabObject)):
       $mngLog ->gravaLog($fabUsuario, '../files/', 'Editou Infos Cidade');
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