<?php
include_once('autoload.php');

//objects
$sectPolicy = new SecurityPolicy();
$sectMsg    = new SecurityMsg();
$daoUsuario = new DaoUsuario();
$managerPst = new ManagerPostMail();
$fabUsuario = null;

//instances
$tmppass  = isset($_POST['tmppass']) ? md5(SecurityPolicy::validateInput($_POST['tmppass'])) : null;
$newpass  = isset($_POST['newpass']) ? SecurityPolicy::validateInput($_POST['newpass']) : null;
$confpass = isset($_POST['confpass']) ? SecurityPolicy::validateInput($_POST['confpass']) : null;
$tkform   = isset($_POST['tokenform']) ? SecurityPolicy::validateInput($_POST['tokenform']) : null;

if($sectPolicy->verifySession()){
    $fabUsuario = $daoUsuario->getUserByLogin($_SESSION[$sectPolicy->getIndexSuser()], $_SESSION[$sectPolicy->getIndexSpass()]);
    $sectPolicy-> gateGuardian($fabUsuario, FabUsuario::getNumberPerfis(), '0', 'proc-logoff.php?code=error0002');
    SecurityPolicy::controlHackerForm($tkform, 'proc-logoff.php');
}else{
    echo '<script> location.replace("proc-logoff.php"); </script>';
}

if($fabUsuario != null){
    if($newpass == $confpass) {
        if($tmppass == $fabUsuario->getIdpass()){
            $msgsbjc = 'Alteração de Senha Realizada Livro Ideal - Aprova+';
            $msgmail = 'Você esta recebendo essa mensagem devido a alteração de senha da Plataforma de Avaliação 
                        de Aprendizado Livro Ideal - Aprova+. Realizada em ' . date('d') . '-' . date('m') . '-' . date('Y') . ' às '
                . date('H') . ':' . date('i') . ':' . date('s') . '. Se você não tem conhecimento sobre esta alteração entre 
                        em contato com seu administrador de sistemas! Use os dados abaixo para acessar o sistema!';
            $msgadtl  = '<p>Nome: '.$fabUsuario->getNome() . '</p>';
            $msgadtl .= '<p>Usuario: '.$fabUsuario->getCpf() . '</p>';
            $msgadtl .= '<p>Senha: '.$newpass.'</p>';
            $msgfnl   = '<p>Atenciosamente, Equipe OctusPi</p>';

            $daoUsuario = new DaoUsuario();
            if ($daoUsuario->changeUserPass($fabUsuario, md5($newpass), false)) {
                $managerPst->sendMail($fabUsuario->getEmail(), $msgsbjc, $msgmail, $msgadtl, $msgfnl);
                $sectMsg->createMsg('sucs0003');
                echo '<script> location.replace("index.php"); </script>';
            } else {
                $sectMsg->createMsg('error0004');
                echo '<script> location.replace("pass-update.php"); </script>';
            }
        }else{
            $sectMsg->createMsg('error0005');
            echo '<script> location.replace("pass-update.php"); </script>';
        }
    }else{
        $sectMsg->createMsg('error0006');
        echo '<script> location.replace("pass-update.php"); </script>';
    }
}else{
    $sectMsg->createMsg('error0002');
    echo '<script> location.replace("pro-logoff.php"); </script>';
}

