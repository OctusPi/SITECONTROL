<?php
/**
 * Created by PhpStorm.
 * User: kuroi
 * Date: 13/02/18
 * Time: 19:14
 */

include_once('ConnectionPDO.php');
include_once('SecurityMsg.php');

/**
 * Class DaoObject
 */
abstract class DaoObject
{
    protected $pdoc;
    protected $conn;
    protected $sttm;
    protected $rslt;
    protected $smsg;

    /**
     * DaoObject constructor.
     */
    public function __construct()
    {
        $this->pdoc = new ConnectionPDO();
        $this->conn = $this->pdoc->getConnection();
        $this->sttm = null;
        $this->rslt = null;
        $this->smsg = new SecurityMsg();
    }

    public function finalizaDao(){
        try{
            unset($this->sttm);
            unset($this->rslt);
        }catch (PDOException $e){
            print_r($e->getMessage());
        }
    }
}