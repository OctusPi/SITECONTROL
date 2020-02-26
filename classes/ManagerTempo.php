<?php
/**
 * Created by PhpStorm.
 * User: octuspi
 * Date: 14/09/2018
 * Time: 14:31
 */

class ManagerTempo
{
    /**
     * @return false|string
     */
    public static function getDataTempoFull(){
        $dataTempo = date('Y-m-d H:i:s');
        return $dataTempo;
    }
}