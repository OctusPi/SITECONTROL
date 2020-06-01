<?php


/**
 * Class CTLogSystem
 */
class CTLogSystem
{
    private static $filedir = '3.0-SITECONTROL';
    private static $filelog = 'LOGSYSTEM.txt';

    /**
     * @param EntiteUsuario $obj
     * @param $action
     */
    public static function registerLog(EntiteUsuario $obj, $action){
        if($obj != null){
            $data = date('d-m-Y H:i:s');
            $log  = $data.'#'
                  . $obj->getNome().'#'
                  . $obj->getCpf().'#'
                  . $action.'-@#$-';

            try {
                $fp = fopen($_SERVER['DOCUMENT_ROOT'].'/'.self::$filedir.'/'.self::$filelog, 'a');
                fwrite($fp, $log);
                fclose($fp);
            }catch (Exception $e){
                printf($e->getMessage());
            }

        }
    }

    public static function rescueLog(){
        $log = null;

        try {
            $fp = fopen($_SERVER['DOCUMENT_ROOT'].'/'.self::$filedir.'/'.self::$filelog, 'r');
            $ct = fread($fp, filesize(self::$filelog));
            fclose($fp);

            $log = explode('-@#$-', $ct);
        }catch (Exception $e){
            printf($e->getMessage());
        } finally {
            return $log;
        }
    }
}