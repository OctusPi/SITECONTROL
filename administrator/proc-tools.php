<?php
include_once('autoload.php');

$sectPolicy = new SecurityPolicy();
$daoUsuario = new DaoUsuario();
$sectMsg    = new SecurityMsg();
$pstMail    = new ManagerPostMail();
$mngLog     = new ManagerLog();
$daoEscola  = new DaoEscola();
$backPag    = md5('tools');
$fabUsuario = null;

if($sectPolicy->verifySession()){
    $fabUsuario = $daoUsuario->getUserByLogin($_SESSION[$sectPolicy->getIndexSuser()], $_SESSION[$sectPolicy->getIndexSpass()]);
    $sectPolicy-> gateGuardian($fabUsuario, 0, '10', 'proc-logoff.php?code=error0002');
}else{
    echo '<script> location.replace("proc-logoff.php"); </script>';
}

if(isset($_GET['mod']) && $_GET['mod'] == 'n'){

    $rscEscola = $daoEscola->consultRegister();

    $nome = isset($_POST['user_nome']) ? SecurityPolicy::validateInput($_POST['user_nome']) : '';
    $mail = isset($_POST['user_mail']) ? SecurityPolicy::validateInput($_POST['user_mail']) : '';
    $cpf  = isset($_POST['user_cpf']) ? SecurityPolicy::validateInput($_POST['user_cpf']) : '';
    $pass = isset($_POST['user_pass']) ? SecurityPolicy::validateInput($_POST['user_pass']) : '';
    $perf = isset($_POST['user_perfil']) ? SecurityPolicy::validateInput($_POST['user_perfil']) : '';
    $upps = isset($_POST['user_uppass']) ? SecurityPolicy::validateInput($_POST['user_uppass']) : false;
    $stat = isset($_POST['user_status']) ? SecurityPolicy::validateInput($_POST['user_status']) : '';
    $nivl = '0,';
    $vinc = '0,';

    foreach (FabUsuario::getNiveis($perf) as $k=>$v):
        if(isset($_POST['user_niveis'.$k])):
            $nivl .= $k.',';
        endif;
    endforeach;

    foreach ($rscEscola as $v):
        if(isset($_POST['user_vinculo'.$v->getId()])):
            $vinc .= $v->getId().',';
        endif;
    endforeach;

    $newUsuario = new FabUsuario(0, $nome, $mail, $cpf, md5($cpf), md5($pass), $stat, $perf, $nivl, $vinc, $upps);
    if($daoUsuario->newRegister($newUsuario)):
        $subMail = 'Usuário Cadastrado Livro Ideal - Aprova+';
        $cntMail = '<div><h1>Usuário Cadastrado Sistema de Avaliação de Aprendizado Livro Ideal - Aprova+</h1><p>Para acessar o sistema user os dados abaixo</p></div>';
        $adtMail = '<div><p>Usuário: '.$cpf.'</p><p>Senha: '.$pass.'</p></div>';
        $fnlmail = '<div><p>Atenciosamente, Equipe OctusPi Dev</p></div>';
        $pstMail->sendMail($mail, $subMail, $cntMail, $adtMail, $fnlmail);
        $mngLog ->gravaLog($fabUsuario, '../files/', 'Cadastrou Novo Usuário');
    endif;
    echo '<script> location.replace("home.php?pag='.$backPag.'"); </script>';
}elseif(isset($_GET['mod']) && $_GET['mod'] == 'u'){
    $rscEscola = $daoEscola->consultRegister();

    $vlid = isset($_POST['valindex']) ? SecurityPolicy::validateInput($_POST['valindex']) : 0;
    $nome = isset($_POST['user_nome']) ? SecurityPolicy::validateInput($_POST['user_nome']) : '';
    $mail = isset($_POST['user_mail']) ? SecurityPolicy::validateInput($_POST['user_mail']) : '';
    $cpf  = isset($_POST['user_cpf']) ? SecurityPolicy::validateInput($_POST['user_cpf']) : '';
    $pass = isset($_POST['user_pass']) ? SecurityPolicy::validateInput($_POST['user_pass']) : '';
    $perf = isset($_POST['user_perfil']) ? SecurityPolicy::validateInput($_POST['user_perfil']) : '';
    $upps = isset($_POST['user_uppass']) ? SecurityPolicy::validateInput($_POST['user_uppass']) : false;
    $stat = isset($_POST['user_status']) ? SecurityPolicy::validateInput($_POST['user_status']) : '';
    $nivl = '0,';
    $vinc = '0,';

    foreach (FabUsuario::getNiveis($perf) as $k=>$v):
        if(isset($_POST['user_niveis'.$k])):
            $nivl .= $k.',';
        endif;
    endforeach;

    foreach ($rscEscola as $v):
        if(isset($_POST['user_vinculo'.$v->getId()])):
            $vinc .= $v->getId().',';
        endif;
    endforeach;

    $newUsuario = new FabUsuario($vlid, $nome, $mail, $cpf, md5($cpf), md5($pass), $stat, $perf, $nivl, $vinc, $upps);
    if($daoUsuario->upRegister($newUsuario)):
        $subMail = 'Dados de Perfil Livro Ideal - Aprova+ alterados!';
        $cntMail = '<div><h1>Seu Perfil foi atualizado pelo administrador do Sistema de Avaliação de Aprendizado Livro Ideal - Aprova+</h1><p>Para acessar o sistema user os dados abaixo</p></div>';
        $adtMail = '<div><p>Se você não tem conhecimento sobre essa mudança entre em contato com a equipe Técnica.</p></div>';
        $fnlmail = '<div><p>Atenciosamente, Equipe OctusPi Dev</p></div>';
        $pstMail->sendMail($mail, $subMail, $cntMail, $adtMail, $fnlmail);
        $mngLog ->gravaLog($fabUsuario, '../files/', 'Alterou dados de Usuário');
    endif;
    echo '<script> location.replace("home.php?pag='.$backPag.'"); </script>';
}elseif(isset($_GET['mod']) && $_GET['mod'] == 'd'){
    $id        = isset($_GET['valindex']) ? SecurityPolicy::validateInput($_GET['valindex']) : 0;
    if($daoUsuario-> delRegister($id)):
        $mngLog ->gravaLog($fabUsuario, '../files/', 'Deletou Usuário');
    endif;
    echo '<script> location.replace("home.php?pag='.$backPag.'"); </script>';
}else{
    echo '<script> location.replace("proc-logoff.php"); </script>';
}