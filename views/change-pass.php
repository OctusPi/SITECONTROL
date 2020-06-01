<?php
include_once('../autoload.php');

//default variables
$key_form   = md5(time());
$ctSecurity = new CTSecuritySystem();
$ctAlerts   = new CTAlertsSystem();
$impUser    = new ImpUsuarioDao($ctSecurity);
$crdPage    = new CTCredencialSystem('inicio', count(EntiteUsuario::getArSystemPerfis()), '0');


//require logoff system
if(isset($_GET['useraction']) && $_GET['useraction'] == 'require_logout'):
    $impUser->logoff();
endif;

//security instances
$loggedUser =  $impUser->findByLogin($ctSecurity->getSessionIduserValue(), $ctSecurity->getSessionIdpassValue());
$ctSecurity -> accessVerificationSecurity($loggedUser, $crdPage);
CTSecuritySystem::keyFormSubmit($key_form);

//actions form
if(isset($_POST['key_form']) && !empty($_POST['key_form'])):
    CTSecuritySystem::validateFormSubmit($_POST['key_form']);

    $pass_atual = isset($_POST['login_pass_atual']) ? CTSecuritySystem::validateFormInput($_POST['login_pass_atual']) : null;
    $new_pass   = isset($_POST['login_pass_new']) ? CTSecuritySystem::validateFormInput($_POST['login_pass_new']) : null;
    $pass_repet = isset($_POST['login_pass_repeat']) ? CTSecuritySystem::validateFormInput($_POST['login_pass_repeat']) : null;

    if($pass_atual == null or $new_pass == null or $pass_repet == null){
        $ctAlerts->sendAlert('ERROR', '007');
    }elseif(md5($pass_atual) !== $loggedUser->getIdPass()){
        $ctAlerts->sendAlert('ERROR', '008');
    }elseif($new_pass !== $pass_repet){
        $ctAlerts->sendAlert('ERROR', '009');
    }elseif(md5($pass_atual) === md5($new_pass)){
        $ctAlerts->sendAlert('ERROR', '010');
    }else{
        if($impUser->changePass($loggedUser, md5($new_pass),false)){
            $impUser->logoff('../index.php');
        }else{
            $ctAlerts->sendAlert('ERROR', '003');
        }
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
    <link rel="icon" href="../imgs/logos/FAVICON-SISAAP-2020.png">

    <!-- Bootstrap core CSS -->
    <link href="../libs/css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../libs/css/ocpdev/ocp-login-style.css" rel="stylesheet">

</head>
<body id="ocp-fundo-login">
<form class="form-signin" action="" method="post" enctype="multipart/form-data">
    <div class="text-center mb-4">
        <img class="mb-4" src="../imgs/logos/LOGO-SISAAP-2020.svg" alt="" width="256">
        <h1 class="h3 font-weight-normal">ALTERACAO DE SENHA</h1>
        <p class="text-warning">Você deve cadastrar uma nova senha antes de continuar!</p>
    </div>

    <div class="form-label-group">
        <input type="text" name="login_pass_atual" id="inputPassAtual" class="form-control" placeholder="Senha Atual"
               <?php if($loggedUser->getPassChange() == false){echo 'disabled';}?> required autofocus>
        <label for="inputPassAtual">Senha Atual</label>
    </div>

    <div class="form-label-group">
        <input type="text" name="login_pass_new" id="inputPassNew" class="form-control" placeholder="Nova Senha"
               <?php if($loggedUser->getPassChange() == false){echo 'disabled';}?> required>
        <label for="inputPassNew">Nova Senha</label>
    </div>

    <div class="form-label-group">
        <input type="text" name="login_pass_repeat" id="inputPassRepeat" class="form-control" placeholder="Repitir Senha"
               <?php if($loggedUser->getPassChange() == false){echo 'disabled';}?> required>
        <label for="inputPassRepeat">Repitir Senha</label>
    </div>


    <div class="mb-3 text-center">
        <label>
            <a href="../index.php" class="text-primary">Sair!</a>
        </label>
    </div>
    <button class="btn btn-lg btn-success btn-block" type="submit" <?php if($loggedUser->getPassChange() == false){echo 'disabled';}?>>Cadastrar</button>
    <p class="mt-5 mb-3 text-muted text-center">&copy; Todos os Direitos Reservados OctusPI Dev 2020</p>

    <input type="hidden" name="key_form" value="<?php echo $key_form;?>">
    <?php $ctAlerts->viewAlert(); ?>
</form>

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="../libs/js/jquery/jquery-3.4.1.js"></script>
<script src="../libs/js/bootstrap/popper-min.js"></script>
<script src="../libs/js/bootstrap/bootstrap.js"></script>
<!-- Optional JavaScript -->
<script type="text/javascript" src="../libs/js/ocpdev/active-function.js"></script>
</body>
</html>