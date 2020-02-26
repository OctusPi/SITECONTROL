<?php
//includes
include_once('autoload.php');

//objects
$sectMsg = new SecurityMsg();
$tokenfm = time();

//voids
SecurityPolicy::validateStartForm($tokenfm);
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
    <title>Recuperar Senha Url Control</title>
</head>
<body class="text-center">
<form class="form-signin" action="proc-passforget.php" method="post" enctype="multipart/form-data">
    <img class="mb-4" src="../imgs/logos/logo-urlcontrol.svg" alt="" width="312">
    <p>Recuperar Senha</p>
    <p>Sistema de Controle Web</p>
    <label for="inputEmail" class="sr-only">Email</label>
    <input type="text" name="iduser" id="inputEmail" class="form-control" placeholder="CPF" required autofocus>
    <input type="hidden" name="tokenform" value="<?=$tokenfm;?>">
    <br>
    <p>
        <a href="index.php">Voltar para o Login</a>
    </p>
    <button class="btn btn-lg btn-warning btn-block" type="submit">Recuperar</button>
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