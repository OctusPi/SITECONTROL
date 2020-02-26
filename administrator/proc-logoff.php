<?php
/**
 * Created by PhpStorm.
 * User: kuroi
 * Date: 14/02/18
 * Time: 02:43
 */
include_once('autoload.php');

$sectPolicy = new SecurityPolicy();
$sectMsg    = new SecurityMsg();

$code = isset($_GET['code']) ? SecurityPolicy::validateInput($_GET['code']) : null;

if($code != null):
    $sectMsg->createMsg($code);
endif;

$sectPolicy->destroySession();
header("Location:index.php");