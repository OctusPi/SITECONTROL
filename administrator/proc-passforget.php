<?php
/**
 * Created by PhpStorm.
 * User: kuroi
 * Date: 16/02/18
 * Time: 01:28
 */
include_once('autoload.php');

$iduser = isset($_POST['iduser']) ? md5(SecurityPolicy::validateInput($_POST['iduser'])) : null;
$tkform = isset($_POST['tokenform']) ? SecurityPolicy::validateInput($_POST['tokenform']) : null;

$sectMsg    = new SecurityMsg();
$daoUsuario = new DaoUsuario();
$managerPst = new ManagerPostMail();
$fabUsuario = $daoUsuario->getUserExist($iduser);

SecurityPolicy::controlHackerForm($tkform, 'proc-logoff.php');

if($fabUsuario != null){
    $newpass = rand(111111, 999999);
    $msgsbjc = 'Solicitação de Recuperação de Senha Livro Ideal - Aprova+';
    $msgmail = 'Você esta recebendo essa mensagem devido a solicitação de recuperação de senha da Plataforma de Avaliação 
    de Aprendizado. Solicitação realizada em '.date('d').'-'.date('m').'-'.date('Y').' às '
        .date('H').':'.date('i').':'.date('s').'. Se você não tem conhecimento sobre esta solicitação entre 
    em contato com seu administrador de sistemas! Use os dados abaixo para modificar sua senha!';
    $msgadtl  = '<p>Nome:'.$fabUsuario->getNome().'</p>';
    $msgadtl .= '<p>Usuario:'.$fabUsuario->getCpf().'</p>';
    $msgadtl .= '<p>Senha:'.$newpass.'</p>';
    $msgfnl   = '<p>Atenciosamente, Equipe OctusPi</p>';

    $daoUsuario = new DaoUsuario();
    if($daoUsuario->changeUserPass($fabUsuario, md5($newpass), true)){
        $managerPst->sendMail($fabUsuario->getEmail(), $msgsbjc, $msgmail, $msgadtl, $msgfnl);
        $sectMsg->createMsg('sucs0002');
        //echo '<script> location.replace("pass-forget.php"); </script>';
    }else{
        $sectMsg->createMsg('error0004');
        //echo '<script> location.replace("pass-forget.php"); </script>';
    }
}else{
    $sectMsg->createMsg('error0003');
    echo '<script> location.replace("pass-forget.php"); </script>';
}

echo $newpass;