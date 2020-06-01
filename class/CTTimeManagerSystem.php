<?php


class CTTimeManagerSystem
{
    public static function getDataNow(){
        //return datetime mysql
        return date('d-m-Y H:i:s');
    }

    public static function convertDataView($datetime){
        return date('d-m-Y H:i:s', strtotime($datetime));
    }

    public static function convertDataDB($datetime){
        return date('Y-m-d H:i:s', strtotime($datetime));
    }
}