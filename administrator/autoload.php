<?php
/**
 * Created by PhpStorm.
 * User: Kuroi
 * Date: 13/10/2017
 * Time: 01:11
 */
spl_autoload_register(function ($class_name) {
    if(file_exists('../classes/'.$class_name.'.php')){
        include_once('../classes/'.$class_name.'.php');
    }
});