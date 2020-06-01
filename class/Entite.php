<?php


/**
 * Class Entite
 */
abstract class Entite
{
    /**
     * @param $str
     * @return array
     */
    public function convetArray($str){
        return explode('-@#$-', $str);
    }

    public function getStringStatus($b){
        $b == true ? $out = 'ATIVO' : $out = 'INATIVO';
        return $out;
    }
}