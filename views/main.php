<?php
include_once('../autoload.php');

//default variables
$key_form   = md5(time());
$ctSecurity = new CTSecuritySystem();
$ctAlerts   = new CTAlertsSystem();
$impUser    = new ImpUsuarioDao($ctSecurity);
$crdPage    = new CTCredencialSystem('inicio', count(EntiteUsuario::getArSystemPerfis()), '0');

//require logoff system
if (isset($_GET['useraction']) && $_GET['useraction'] == 'require_logout') :
    $impUser->logoff('../index.php');
endif;


//security instances
$loggedUser =  $impUser->findByLogin($ctSecurity->getSessionIduserValue(), $ctSecurity->getSessionIdpassValue());
$ctSecurity->accessVerificationSecurity($loggedUser, $crdPage);
CTSecuritySystem::keyFormSubmit($key_form);

//verify change pass
if ($loggedUser->getPassChange() == true) {
    CTSecuritySystem::redirectionPage('change-pass.php');
}
?>
<!doctype html>
<html lang="pt-br" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="OctusPI Dev">
    <title>SISAAP - Sistema de Avaliacão de Aprendizado</title>

    <!-- OcpDev FavIcon -->
    <link rel="icon" href="../imgs/logos/FAVICON-SISAAP-2020.png">

    <!-- Reset core CSS -->
    <link href="../libs/css/ocpdev/reset.css" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="../libs/css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../libs/css/ocpdev/ocp-system-style.css?ver=<?php echo md5(rand(1, 9999)); ?>" rel="stylesheet">

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="../libs/js/jquery/jquery-3.4.1.js"></script>
    <script src="../libs/js/bootstrap/popper-min.js"></script>
    <script src="../libs/js/bootstrap/bootstrap.js"></script>
    <script src="../libs/js/bootstrap/icons.js"></script>
    <!-- Optional JavaScript -->
    <script type="text/javascript" src="../libs/js/ocpdev/active-function.js"></script>
    <script type="text/javascript" src="../libs/js/ocpdev/active-ajax.js"></script>

</head>

<body class="bg-light d-flex flex-column h-100" id="ocp-fundo-page">
<main role="main" class="flex-shrink-0">
    <!-- brand-bar -->
    <div class="container-fluid bg-primary">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
                <a class="navbar-brand" href="main.php">
                    <img src="../imgs/logos/BRAND-SISAAP.svg" width="30" height="30" class="d-inline-block align-top" alt="">
                </a>
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="disabled text-light text-decoration-none" href="#" tabindex="-1" aria-disabled="true">SISAAP<small>Sistema de Avaliacao de Aprendizado</small></a>
                    </li>
                </ul>
                <div class="dropdown dropleft ocp-point-cursor text-uppercase">
                    <i class="fas fa-user-circle fa-lg text-light" id="dropdownLoggedInfo" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                    <div class="dropdown-menu" aria-labelledby="dropdownLoggedInfo">
                        <div class="dropdown-item small text-left"><span class="small"> Usuário</span> <br> <?php echo $loggedUser->getNome(); ?></div>
                        <div class="dropdown-item small text-left"><span class="small"> Perfil</span> <br> <?php echo EntiteUsuario::getArSystemPerfis()[$loggedUser->getPerfilAcesso()]; ?></div>
                        <div class="dropdown-item small text-left"><span class="small"> Ultimo Acesso</span> <br> <?php echo CTTimeManagerSystem::convertDataView($loggedUser->getLastLogin()); ?></div>
                        <div class="dropdown-item small text-left">
                            <a href="?useraction=require_logout" class="btn btn-sm btn-danger"><i class="fas fa-power-off fa-lg text-light"></i> Sair</a>
                            <a href="?pag=<?php echo md5('perfil');?>" class="btn btn-sm btn-primary"><i class="fas fa-user fa-lg text-light"></i> Perfil</a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- nav-bar -->
    <div class="container-fluid">
        <div class="container ocp-conteiner-page">

            <!-- io user view alerts -->
            <div id="ocp-view-alertr">
                <?php $ctAlerts->viewAlert();?>
            </div>

            <?php
            if (isset($_GET['pag'])) {

                switch ($_GET['pag']) {
                    case md5('regioes'):
                        include_once 'pag-regioes.php';
                        break;
                    case md5('escolas'):
                        include_once 'pag-escolas.php';
                        break;
                    case md5('series'):
                        include_once 'pag-series.php';
                        break;
                    case md5('turmas'):
                        include_once 'pag-turmas.php';
                        break;
                    case md5('alunos'):
                        include_once 'pag-alunos.php';
                        break;
                    case md5('disciplinas'):
                        include_once 'pag-disciplinas.php';
                        break;
                    case md5('matrizes'):
                        include_once 'pag-matrizes.php';
                        break;
                    case md5('descritores'):
                        include_once 'pag-descritores.php';
                        break;
                    case md5('avaliacoes'):
                        include_once 'pag-avaliacoes.php';
                        break;
                    case md5('resp-avaliacoes'):
                        include_once 'pag-avaliacoes-responder.php';
                        break;
                    case md5('resultados'):
                        include_once 'pag-resultados.php';
                        break;
                    case md5('reports'):
                        include_once 'pag-reports.php';
                        break;
                    case md5('tools'):
                        include_once 'pag-tools.php';
                        break;
                    case md5('perfil'):
                        include_once 'pag-perfil.php';
                        break;
                    default:
                        include_once 'navgation-full.php';
                        break;
                }
            } else {
                include_once('navgation-full.php');
            }
            ?>
        </div>
    </div>
</main>
<footer class="footer mt-auto py-3">
    <div class="container">
        <span class="text-muted small">&copy; OctusPi - Dev Todos os direitos reservados 2020</span>
    </div>
</footer>
</body>
</html>
