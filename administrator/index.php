<?php
//includes
include_once('autoload.php');

//objects
$sectMsg    = new SecurityMsg();
$tokenfm    = time();
$msgRetorno = null;

if(isset($_COOKIE[md5('numbertimeswhenrobot')])){
    $addview = ' Tentativa '.$_COOKIE[md5('numbertimeswhenrobot')].' de 5';
    $msgRetorno = $sectMsg->viewMsg($addview);
}else{
    $msgRetorno = $sectMsg->viewMsg();
}
$sectMsg->deleteMsg();

//voids
SecurityPolicy::validateStartForm($tokenfm);
SecurityPolicy::expulsaRobo('numbertimeswhenrobot', '../robocontrol.html');

?>
<!doctype html>
<html lang="pt-br">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema de Controle Web">
    <meta name="author" content="OctusPi Developer">
    <link rel="icon" href="../imgs/icons/favicon.ico">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/singin.css">
    <title>URL Control</title>
</head>
<body class="text-center">
<form class="form-signin" action="proc-login.php" method="post" enctype="multipart/form-data">
    <img class="mb-4" src="../imgs/logos/logo-urlcontrol.svg" alt="" width="312"">
    <p>Sistema de Controle Web</p>
    <label for="inputCpf" class="sr-only">CPF</label>
    <input type="text" name="iduser" id="inputCpf" class="form-control" placeholder="CPF" required autofocus>
    <label for="inputPassword" class="sr-only">Senha</label>
    <input type="password" name="idpass" id="inputPassword" class="form-control" placeholder="Senha" required>
    <input type="hidden" name="tokenform"value="<?=$tokenfm;?>">
    <div class="checkbox mb-3">
       <a href="pass-forget.php">Esqueci a Senha!</a>
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
    <?
    if ($msgRetorno != null):
        echo $msgRetorno;
    endif;
    ?>
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