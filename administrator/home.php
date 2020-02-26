<?php
include_once('autoload.php');

$sectPolicy = new SecurityPolicy();
$daoUsuario = new DaoUsuario();
$sectMsg    = new SecurityMsg();
$fabUsuario = null;
$msgRetorno = null;
$tokenfm    = time();

if($sectPolicy->verifySession()){
    /** @var FabUsuario $fabUsuario */
    $fabUsuario = $daoUsuario->getUserByLogin($_SESSION[$sectPolicy->getIndexSuser()], $_SESSION[$sectPolicy->getIndexSpass()]);
    $sectPolicy-> gateGuardian($fabUsuario, FabUsuario::getNumberPerfis(), '0', 'proc-logoff.php?code=error0002');
    $sectPolicy-> isChangePass($fabUsuario, 'pass-update.php');
    $sectPolicy-> validateStartForm($tokenfm);

    $msgRetorno = $sectMsg->viewMsg();
    $sectMsg   -> deleteMsg();
}else{
    echo '<script> location.replace("proc-logoff.php"); </script>';
}
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema de Avaliação de Aprendizado">
    <meta name="author" content="OctusPi Developer">
    <link rel="icon" href="../imgs/icons/favicon.ico">

    <title>Octuspi Livro Ideal - Aprova+</title>

    <!-- CSS -->
    <link href="../css/reset.css" rel="stylesheet" >
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/home-admin.css?ver=<?=md5(rand(1111, 9999))?>" rel="stylesheet">
</head>

<body class="bg-light">
<nav class="navbar navbar-light sticky-top bg-primary flex-md-nowrap p-0">
    <a class="navbar-brand text-white col-sm-3 col-md-2 mr-0" href="home.php">
        <img src="../imgs/logos/brand-livroideal.svg" width="28" height="28" class="d-inline-block align-top" alt="">
        Livro Ideal Aprova+
    </a>
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <div class="row">
                <div class="col-auto"><a class="nav-link" href="#">Contato</a></div>
                <div class="col-auto"><a class="nav-link" href="#">Ajuda</a></div>
            </div>
        </li>
    </ul>
</nav>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-dark sidebar">
            <div class="sidebar-sticky">
                <div class="card-body octp-view-login">
                    <p class="card-text">
                        <b>Ola, <?=$fabUsuario->getNome();?></b>
                        <br/><?=FabUsuario::getPerfis()[$fabUsuario->getPerfil()];?>
                        <br/>LOGOU EM: <?=$fabUsuario->getOldlogin();?>
                    </p>
                    <a href="<?='?pag='.md5('perfil');?>" class="btn btn-sm btn-secondary">Perfil</a>
                    <a href="proc-logoff.php?code=sucs0001" class="btn btn-sm btn-danger">Sair</a>
                    <hr class="bg-secondary">
                </div>

                <ul class="nav flex-column nav-down-prop">
                    <li class="nav-item">
                        <a class="nav-link <?if(!isset($_GET['pag'])): echo 'active'; endif;?>" href="home.php">
                            <span data-feather="home"></span>
                            Home
                        </a>
                    </li>

                    <?if($fabUsuario != null && $sectPolicy->verifyNivel($fabUsuario, 1)):?>
                    <li class="nav-item">
                        <a class="nav-link <?if(isset($_GET['pag']) && $_GET['pag'] == md5('municipios')): echo 'active'; endif;?>" href="<?='?pag='.md5('municipios');?>">
                            <span data-feather="flag"></span>
                            Municípios
                        </a>
                    </li>
                    <?endif;?>

                    <?if($fabUsuario != null && $sectPolicy->verifyNivel($fabUsuario, 2)):?>
                    <li class="nav-item">
                        <a class="nav-link <?if(isset($_GET['pag']) && $_GET['pag'] == md5('escolas')): echo 'active'; endif;?>" href="<?='?pag='.md5('escolas');?>">
                            <span data-feather="server"></span>
                            Escolas
                        </a>
                    </li>
                    <?endif;?>

                    <?if($fabUsuario != null && $sectPolicy->verifyNivel($fabUsuario, 3)):?>
                    <li class="nav-item">
                        <a class="nav-link <?if(isset($_GET['pag']) && $_GET['pag'] == md5('series')): echo 'active'; endif;?>" href="<?='?pag='.md5('series');?>">
                            <span data-feather="layers"></span>
                            Séries e Anos
                        </a>
                    </li>
                    <?endif;?>

                    <?if($fabUsuario != null && $sectPolicy->verifyNivel($fabUsuario, 4)):?>
                    <li class="nav-item">
                        <a class="nav-link <?if(isset($_GET['pag']) && $_GET['pag'] == md5('turmas')): echo 'active'; endif;?>" href="<?='?pag='.md5('turmas');?>">
                            <span data-feather="bookmark"></span>
                            Turmas
                        </a>
                    </li>
                    <?endif;?>

                    <?if($fabUsuario != null && $sectPolicy->verifyNivel($fabUsuario, 5)):?>
                    <li class="nav-item">
                        <a class="nav-link <?if(isset($_GET['pag']) && $_GET['pag'] == md5('alunos')): echo 'active'; endif;?>" href="<?='?pag='.md5('alunos');?>">
                            <span data-feather="users"></span>
                            Alunos
                        </a>
                    </li>
                    <?endif;?>

                    <?if($fabUsuario != null && $sectPolicy->verifyNivel($fabUsuario, 6)):?>
                    <li class="nav-item">
                        <a class="nav-link <?if(isset($_GET['pag']) && $_GET['pag'] == md5('matrizes')): echo 'active'; endif;?>" href="<?='?pag='.md5('matrizes');?>">
                            <span data-feather="box"></span>
                            Matrizes
                        </a>
                    </li>
                    <?endif;?>

                    <?if($fabUsuario != null && $sectPolicy->verifyNivel($fabUsuario, 7)):?>
                    <li class="nav-item">
                        <a class="nav-link <?if(isset($_GET['pag']) && $_GET['pag'] == md5('descritores')): echo 'active'; endif;?>" href="<?='?pag='.md5('descritores');?>">
                            <span data-feather="book-open"></span>
                            Descritores
                        </a>
                    </li>
                    <?endif;?>

                    <?if($fabUsuario != null && ($sectPolicy->verifyNivel($fabUsuario, 8) or $sectPolicy->verifyNivel($fabUsuario, 9))):?>
                    <li class="nav-item">
                        <a class="nav-link <?if(isset($_GET['pag']) && $_GET['pag'] == md5('avaliacoes')): echo 'active'; endif;?>" href="<?='?pag='.md5('avaliacoes');?>">
                            <span data-feather="edit"></span>
                            Avaliações
                        </a>
                    </li>
                    <?endif;?>

                    <?if($fabUsuario != null && $sectPolicy->verifyNivel($fabUsuario, 10)):?>
                    <li class="nav-item">
                        <a class="nav-link <?if(isset($_GET['pag']) && $_GET['pag'] == md5('resultados')): echo 'active'; endif;?>" href="<?='?pag='.md5('resultados');?>">
                            <span data-feather="pie-chart"></span>
                            Resultados
                        </a>
                    </li>
                    <?endif;?>

                    <?if($fabUsuario != null && $sectPolicy->verifyNivel($fabUsuario, 11)):?>
                    <li class="nav-item">
                        <a class="nav-link <?if(isset($_GET['pag']) && $_GET['pag'] == md5('reports')): echo 'active'; endif;?>" href="<?='?pag='.md5('reports');?>">
                            <span data-feather="file-text"></span>
                            Relatórios
                        </a>
                    </li>
                    <?endif;?>

                    <?if($fabUsuario != null && $sectPolicy->verifyNivel($fabUsuario, 12)):?>
                    <li class="nav-item">
                        <a class="nav-link <?if(isset($_GET['pag']) && $_GET['pag'] == md5('tools')): echo 'active'; endif;?>" href="<?='?pag='.md5('tools');?>">
                            <span data-feather="settings"></span>
                            Administração
                        </a>
                    </li>
                    <?endif;?>
                </ul>
            </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
            <?
            if ($msgRetorno != null):
                echo $msgRetorno;
            endif;

            if(isset($_GET['pag'])){
                switch ($_GET['pag']) {
                    case md5('municipios'):
                        include_once 'pag-municipios.php';
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
                    case md5('matrizes'):
                        include_once 'pag-matrizes.php';
                        break;
                    case md5('descritores'):
                        include_once 'pag-descritores.php';
                        break;
                    case md5('avaliacoes'):
                        include_once 'pag-avaliacoes.php';
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
                    default:
                        include_once 'pag-default.php';
                        break;
                }
            }else{
                include_once('pag-default.php');
            }
            ?>
        </main>
    </div>
</div>


<!-- Java Scripts -->
<script src="../js/jquery-3.2.1.slim.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/ocp-active-functions.js"></script>

<!-- Icons -->
<script src="../js/feather.min.js"></script>
<script>feather.replace(); </script>
</body>
</html>
