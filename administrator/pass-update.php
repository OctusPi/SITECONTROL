<?php
include_once('autoload.php');

$sectPolicy = new SecurityPolicy();
$daoUsuario = new DaoUsuario();
$sectMsg    = new SecurityMsg();
$fabUsuario = null;
$tokenfm    = time();

if($sectPolicy->verifySession()){
    $fabUsuario = $daoUsuario->getUserByLogin($_SESSION[$sectPolicy->getIndexSuser()], $_SESSION[$sectPolicy->getIndexSpass()]);
    $sectPolicy-> gateGuardian($fabUsuario, FabUsuario::getNumberPerfis(), '0', 'proc-logoff.php?code=error0002');
    $sectPolicy->validateStartForm($tokenfm);
}else{
    echo '<script> location.replace("proc-logoff.php"); </script>';
}
?>
<!doctype html>
<html lang="pt-br">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="OctusPi Developer">
    <link rel="icon" href="../imgs/icons/favicon.ico">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/singin.css">
    <title>Atualizar Senha Url Control</title>
</head>
<body class="text-center">
<form class="form-signin" action="proc-passupdate.php" method="post" enctype="multipart/form-data">
    <img class="mb-4" src="../imgs/logos/logo-urlcontrol.svg" alt="" width="312">
    <p>Modificar Senha Temporária</p>
    <p>Sistema de Contrtole Web</p>
    <label for="inputTempPass" class="sr-only">Senha Atual</label>
    <input type="password" name="tmppass" id="inputTempPass" class="form-control double-circle" placeholder="Senha Atual" required autocomplete="no">
    <label for="inputNewPass" class="sr-only">Nova Senha</label>
    <input type="password" name="newpass" id="inputNewPass" class="form-control double-circle" placeholder="Nova Senha" required autocomplete="off">
    <label for="inputConfPass" class="sr-only">Repita Senha</label>
    <input type="password" name="confpass" id="inputConfPass" class="form-control double-circle" placeholder="Confirmar Senha" required autocomplete="off">
    <input type="hidden" name="tokenform" value="<?=$tokenfm;?>">
    <br>
    <p>
        <a href="proc-logoff.php">Sair</a>
    </p>
    <button class="btn btn-lg btn-success btn-block" type="submit">Salvar</button>
    <?=$sectMsg->viewMsg(); $sectMsg->deleteMsg();?>
    <p class="mt-5 mb-3 text-muted">&copy; OctusPi Developer 2018</p>
</form>

<!-- jQuery, Popper, Bootstrap JS -->
<script src="../js/jquery-3.2.1.slim.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.alert').alert();
    });
</script>
</body>
</html>