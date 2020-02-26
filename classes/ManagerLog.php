<?php
/**
 * Created by PhpStorm.
 * User: kuroi
 * Date: 25/02/18
 * Time: 23:10
 */

class ManagerLog
{
    private $file;

    public function __construct() {
        $this->file = md5('arquivodelogtxt').'.txt';
    }

    /**
     * @param FabUsuario $usuario
     * @param $filedir
     * @param $action
     * @return bool
     */
    public function gravaLog(FabUsuario $usuario, $filedir, $action){

        if(!file_exists($filedir.$this->file)){
            $node = substr($this->setNode($usuario, $action), 3, strlen($this->setNode($usuario, $action)));
        }else{
            $node = $this->setNode($usuario, $action);
        }

        try{
            $handle = fopen($filedir.$this->file, 'a+');
            fwrite($handle, $node);
            fclose($handle);
            return true;
        } catch (Exception $ex) {
            print_r($ex->getMessage());
            return false;
        }
    }

    /**
     * @param $filedir
     * @return null
     */
    public function getLog($filedir){
        try{
            $arylog = null;
            $handle = fopen($filedir.$this->file, 'r');
            $vartxt = fgetc($handle);
            fclose($handle);
            foreach (explode('///', $vartxt) as $k=>$v){
                $arylog[$k] = explode('|', $v);
            }
            return $arylog;
        } catch (Exception $ex) {
            print_r($ex->getMessage());
            return null;
        }
    }

    /**
     * @param FabUsuario $usuario
     * @param $action
     * @return string
     */
    private function setNode(FabUsuario $usuario, $action){
        if($usuario != null){
            $row  = '///'.time().'|';
            $row .= $usuario->getId().'|';
            $row .= $usuario->getNome().'|';
            $row .= $action;
        }else{
            $row = '';
        }

        return $row;
    }
}