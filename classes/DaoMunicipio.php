<?php
/**
 * Created by PhpStorm.
 * User: octuspi
 * Date: 16/09/2018
 * Time: 02:00
 */

class DaoMunicipio extends DaoObject
{
    /**
     * DaoMunicipio constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param FabMunicipio $fabObject
     * @return bool
     */
    private function singleRegister(FabMunicipio $fabObject){
        $obj = false;
        $sql = "SELECT id FROM ".ConnectionPDO::$TBCIDDS." WHERE pais=:pais AND estado=:estado AND cidade=:cidade AND id!=:id";

        try{
            $this->sttm = $this->conn->prepare($sql);
            $this->sttm ->bindValue(":pais", $fabObject->getPais(), PDO::PARAM_INT);
            $this->sttm ->bindValue(":estado", $fabObject->getEstado(), PDO::PARAM_INT);
            $this->sttm ->bindValue(":cidade", $fabObject->getCidade(), PDO::PARAM_STR);
            $this->sttm ->bindValue(":id", $fabObject->getId(), PDO::PARAM_INT);
            $this->sttm ->execute();
            if($this->sttm->rowCount() >= 1){
                $obj = true;
            }
        }catch (PDOException $exception){
           $this->smsg->createMsg('error0008');
           print_r($exception->errorInfo);
        }

        return $obj;
    }

    /**
     * @param null $chave
     * @return array|null
     */
    public function consultRegister($chave = null){
       $obj = null;
        if($chave == null){
            try{
                $sql = "SELECT * FROM ".ConnectionPDO::$TBCIDDS." ORDER BY cidade";
                $this->sttm = $this->conn->prepare($sql);
                $this->sttm->execute();
                if($this->sttm->rowCount() >= 1){
                    $obj = array();
                    $this->rslt = $this->sttm->fetchAll(PDO::FETCH_ASSOC);
                    foreach($this->rslt as $v):
                        $fabObj = new FabMunicipio($v["id"], $v["cnpj"], $v["pais"], $v["estado"], $v["cidade"], $v["status"]);
                        array_push($obj, $fabObj);
                    endforeach;
                }else{
                    $this->smsg->viewMsgDisplay('error0010');
                }
            }catch (PDOException $exception){
                $this->smsg-> createMsg('error0008');
                print_r($exception->errorInfo);
            }
        }else{
            try{
                $sql = "SELECT * FROM ".ConnectionPDO::$TBCIDDS." WHERE estado=:estado ORDER BY cidade";
                $this->sttm = $this->conn->prepare($sql);
                $this->sttm->bindValue(":estado", $chave, PDO::PARAM_INT);
                $this->sttm->execute();
                if($this->sttm->rowCount() >= 1){
                    $obj = array();
                    $this->rslt = $this->sttm->fetchAll(PDO::FETCH_ASSOC);
                    foreach($this->rslt as $v):
                        $fabObj = new FabMunicipio($v["id"], $v["cnpj"], $v["pais"], $v["estado"], $v["cidade"], $v["status"]);
                        array_push($obj, $fabObj);
                    endforeach;
                }else{
                    $this->smsg->viewMsgDisplay('error0010');
                }
            }catch (PDOException $exception){
                $this->smsg-> createMsg('error0008');
                print_r($exception->errorInfo);
            }
        }

        $this->finalizaDao();
        return $obj;
    }

    /**
     * @param FabUsuario $fabUsuario
     * @return array|null
     */
    public function consultRegisterByAccess(FabUsuario $fabUsuario){
        $obj = null;

        try{
            $sql = "SELECT * FROM ".ConnectionPDO::$TBCIDDS." ORDER BY cidade";
            $this->sttm = $this->conn->prepare($sql);
            $this->sttm->execute();
            if($this->sttm->rowCount() >= 1){
                $obj = array();
                $this->rslt = $this->sttm->fetchAll(PDO::FETCH_ASSOC);
                foreach($this->rslt as $v):
                    if($fabUsuario->getPerfil() == 0 or ($fabUsuario->getPerfil() == 1 && in_array($v['cidade'], $fabUsuario->getMunicipio()))):
                        $fabObj = new FabMunicipio($v["id"], $v["cnpj"], $v["pais"], $v["estado"], $v["cidade"], $v["status"]);
                        array_push($obj, $fabObj);
                    endif;
                endforeach;
            }else{
                $this->smsg->viewMsgDisplay('error0010');
            }
        }catch (PDOException $exception){
            $this->smsg-> createMsg('error0008');
            print_r($exception->errorInfo);
        }

        $this->finalizaDao();
        return $obj;
    }

    /**
     * @param $chave
     * @return FabMunicipio|null
     */
    public function consultRegisterById($chave){
        $obj = null;
        try{
            $sql = "SELECT * FROM ".ConnectionPDO::$TBCIDDS." WHERE id=:id";
            $this->sttm = $this->conn->prepare($sql);
            $this->sttm->bindValue(":id", $chave, PDO::PARAM_INT);
            $this->sttm->execute();
            if($this->sttm->rowCount() == 1){
                $this->rslt = $this->sttm->fetch(PDO::FETCH_ASSOC);
                $obj = new FabMunicipio($this->rslt["id"], $this->rslt["cnpj"], $this->rslt["pais"], $this->rslt["estado"], $this->rslt["cidade"], $this->rslt["status"]);
            }
        }catch (PDOException $exception){
            $this->smsg-> createMsg('error0008');
            print_r($exception->errorInfo);
        }

        $this->finalizaDao();
        return $obj;
    }

    /**
     * @param FabMunicipio $fabObj
     * @return bool
     */
    public function newRegister(FabMunicipio $fabObj){
        $obj = false;
        if($this->singleRegister($fabObj) == false){
            try{
                $sql = "INSERT INTO ".ConnectionPDO::$TBCIDDS." (cnpj, pais, estado, cidade, status) VALUES (:cnpj, :pais, :estado, :cidade, :status)";
                $this->sttm = $this->conn->prepare($sql);
                $this->sttm->bindValue(":cnpj", $fabObj->getCnpj(), PDO::PARAM_STR);
                $this->sttm->bindValue(":pais", $fabObj->getPais(), PDO::PARAM_INT);
                $this->sttm->bindValue(":estado", $fabObj->getEstado(), PDO::PARAM_INT);
                $this->sttm->bindValue(":cidade", $fabObj->getCidade(), PDO::PARAM_STR);
                $this->sttm->bindValue(":status", $fabObj->getStatus(), PDO::PARAM_BOOL);
                $this->sttm->execute();
                if($this->sttm->rowCount() >= 1){
                    //Sucesso
                    $obj = true;
                    $this->smsg->createMsg('sucs0003');
                }else{
                    //Alteracao Nao Solicitada
                    $this->smsg->createMsg('sucs0009');
                }
            }catch (PDOException $exception){
                //Falha 500
                $this->smsg-> createMsg('error0008');
                print_r($exception->errorInfo);
            }
        }else{
            //Falha Duplicacao Dados
            $this->smsg->createMsg('error0007');
        }
       $this->finalizaDao();
       return $obj;
    }

    /**
     * @param FabMunicipio $fabObj
     * @return bool
     */
    public function upRegister(FabMunicipio $fabObj){
        $obj = false;
        if($this->singleRegister($fabObj) == false){
            try{
                $sql = "UPDATE ".ConnectionPDO::$TBCIDDS." SET cnpj=:cnpj, pais=:pais, estado=:estado, cidade=:cidade, 
                status=:status WHERE id=:id";
                $this->sttm = $this->conn->prepare($sql);
                $this->sttm->bindValue(":cnpj", $fabObj->getCnpj(), PDO::PARAM_STR);
                $this->sttm->bindValue(":pais", $fabObj->getPais(), PDO::PARAM_INT);
                $this->sttm->bindValue(":estado", $fabObj->getEstado(), PDO::PARAM_INT);
                $this->sttm->bindValue(":cidade", $fabObj->getCidade(), PDO::PARAM_STR);
                $this->sttm->bindValue(":status", $fabObj->getStatus(), PDO::PARAM_BOOL);
                $this->sttm->bindValue(":id", $fabObj->getId(), PDO::PARAM_INT);
                $this->sttm->execute();
                if($this->sttm->rowCount() >= 1){
                    //Sucesso
                    $obj = true;
                    $this->smsg->createMsg('sucs0003');
                }else{
                    //Alteracao Nao Solicitada
                    $this->smsg->createMsg('sucs0009');
                }
            }catch (PDOException $exception){
                //Falha Code or Server
                $this->smsg-> createMsg('error0008');
                print_r($exception->errorInfo);
            }
        }else{
            //Falha Duplicacao Dados
            $this->smsg->createMsg('error0007');
        }
        $this->finalizaDao();
        return $obj;
    }

    /**
     * @param $chave
     * @return bool
     */
    public function delRegister($chave){
        $obj = false;
        try{
            $sql = "DELETE FROM ".ConnectionPDO::$TBCIDDS." WHERE id=:id";
            $this->sttm = $this->conn->prepare($sql);
            $this->sttm->bindValue(":id", $chave, PDO::PARAM_INT);
            $this->sttm->execute();
            if($this->sttm->rowCount() >= 1){
                //Sucesso
                $obj = true;
                $this->smsg->createMsg('sucs0003');
            }else{
                //Alteracao Nao Solicitada
                $this->smsg->createMsg('sucs0009');
            }
        }catch (PDOException $exception){
            //Falha Code or Server
            $this->smsg->createMsg('error0008');
            print_r($exception->errorInfo);
        }

        $this->finalizaDao();
        return $obj;
    }
}