<?php
/**
 * Created by PhpStorm.
 * User: kuroi
 * Date: 13/02/18
 * Time: 19:48
 */
include_once('autoload.php');

$iduser = isset($_POST['iduser']) ? md5(SecurityPolicy::validateInput($_POST['iduser'])) : null;
$idpass = isset($_POST['idpass']) ? md5(SecurityPolicy::validateInput($_POST['idpass'])) : null;
$tkform = isset($_POST['tokenform']) ? SecurityPolicy::validateInput($_POST['tokenform']) : null;

$sectPolicy = new SecurityPolicy();
$sectMsg    = new SecurityMsg();
$daoUsuario = new DaoUsuario();
$fabUsuario = null;

SecurityPolicy::controlHackerForm($tkform, 'proc-logoff.php');

$fabUsuario = $daoUsuario->getUserByLogin($iduser, $idpass);
if($fabUsuario != null){
    $sectPolicy->createSession($iduser, $idpass);
    $daoUsuario->registerLogin($fabUsuario, ManagerTempo::getDataTempoFull());
    echo '<script> location.replace("home.php"); </script>';
}else{
    $sectPolicy->roboControl('numbertimeswhenrobot');
    $sectMsg->createMsg('error0001');
    echo '<script> location.replace("index.php"); </script>';
}