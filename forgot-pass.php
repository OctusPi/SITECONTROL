<?php
include_once('autoload.php');

//default variables
$key_form = md5(time());
CTSecuritySystem::keyFormSubmit($key_form);

//default methods
$ctSecurity  = new CTSecuritySystem();
$ctAlerts    = new CTAlertsSystem();
$impUsurario = new ImpUsuarioDao($ctSecurity);

//actions form
if(isset($_POST['key_form']) && !empty($_POST['key_form'])):
    CTSecuritySystem::validateFormSubmit($_POST['key_form']);

    $id_user = isset($_POST['login_iduser']) ? CTSecuritySystem::validateFormInput($_POST['login_iduser']) : '';

    if($impUsurario->forgotPass($id_user)){
        $ctAlerts->sendAlert('SUCCESS', '001');
    }else{
        $ctAlerts->sendAlert('WARNING', '006');
    }
endif;
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="OctusPI Dev">
    <title>SISAAP - Recuperacao de Senha</title>

    <!-- OcpDev FavIcon -->
    <link rel="icon" href="imgs/logos/FAVICON-SISAAP-2020.png">

    <!-- Bootstrap core CSS -->
    <link href="libs/css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="libs/css/ocpdev/ocp-login-style.css" rel="stylesheet">

</head>
<body id="ocp-fundo-login">
<form class="form-signin" action="" method="post" enctype="multipart/form-data">
    <div class="text-center mb-4">
        <img class="mb-4" src="imgs/logos/LOGO-SISAAP-2020.svg" alt="" width="256">
        <h1 class="h3 font-weight-normal">RECUPERAR SENHA</h1>
        <p class="text-warning">Solicitar Nova Senha por E-mail!</p>
    </div>

    <div class="form-label-group">
        <input type="text" name="login_iduser" id="inputUsuario" class="form-control" placeholder="CPF Usuário" maxlength="11" required autofocus>
        <label for="inputUsuario">CPF Usuário</label>
    </div>

    <div class="mb-3 text-center">
        <label>
            <a href="index.php" class="text-primary">Voltar para o Login!</a>
        </label>
    </div>
    <button class="btn btn-lg btn-success btn-block" type="submit">Solicitar</button>
    <p class="mt-5 mb-3 text-muted text-center">&copy; Todos os Direitos Reservados OctusPI Dev 2020</p>

    <input type="hidden" name="key_form" value="<?=$key_form;?>">
    <?php $ctAlerts->viewAlert(); ?>
</form>

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="libs/js/jquery/jquery-3.4.1.js"></script>
<script src="libs/js/bootstrap/popper-min.js"></script>
<script src="libs/js/bootstrap/bootstrap.js"></script>
<!-- Optional JavaScript -->
<script type="text/javascript" src="libs/js/ocpdev/active-function.js"></script>
</body>
</html>