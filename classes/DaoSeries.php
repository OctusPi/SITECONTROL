<?
/**
 * Created by PhpStorm.
 * User: octus
 * Date: 29/03/18
 * Time: 17:16
 */
include_once('DaoObject.php');
include_once ('FabSeries.php');

/**
 * Class DaoSeries
 */
class DaoSeries extends DaoObject
{
    /**
     * DaoSeries constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param FabSeries $fabSeries
     * @return bool
     */
    private function singleRegister(FabSeries $fabSeries){
        $obj = false;
        $sql = 'SELECT * FROM '.ConnectionPDO::$TBSERIS.' WHERE nome=:nome AND nivel=:nivel AND id!=:id';

        try{
            $this->sttm = $this->conn->prepare($sql);
            $this->sttm->bindValue(':nome', $fabSeries->getNome(), PDO::PARAM_STR);
            $this->sttm->bindValue(':nivel', $fabSeries->getNivel(), PDO::PARAM_INT);
            $this->sttm->bindValue(':id', $fabSeries->getId(), PDO::PARAM_INT);
            $this->sttm->execute();
            if($this->sttm->rowCount() >= 1){
                $obj = true;
            }
        }catch (PDOException $e){
            $this->smsg-> createMsg('error0008');
            print_r($e->errorInfo);
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
            $sql = 'SELECT * FROM '.ConnectionPDO::$TBSERIS.' ORDER BY nivel ASC, nome ASC';
            try{
                $this->sttm = $this->conn->prepare($sql);
                $this->sttm->execute();
                if($this->sttm->rowCount() >= 1){
                    $this->rslt = $this->sttm->fetchAll(PDO::FETCH_ASSOC);
                    $obj = array();
                    foreach($this->rslt as $v):
                        $fabSerie = new FabSeries($v['id'], $v['nome'], $v['nivel'], $v['status']);
                        array_push($obj, $fabSerie);
                    endforeach;
                }else{
                    $this->smsg->viewMsgDisplay('error0010');
                }
            }catch (PDOException $e){
                $this->smsg->viewMsgDisplay('error0008');
                print_r($e->errorInfo);
            }
        }else{
            $sql = 'SELECT * FROM '.ConnectionPDO::$TBSERIS.' WHERE nivel=:nivel ORDER BY nome';
            try{
                $this->sttm = $this->conn->prepare($sql);
                $this->sttm-> bindValue(':nivel', $chave, PDO::PARAM_INT);
                $this->sttm->execute();
                if($this->sttm->rowCount() >= 1){
                    $this->rslt = $this->sttm->fetchAll(PDO::FETCH_ASSOC);
                    $obj = array();
                    foreach($this->rslt as $v):
                        $fabSerie = new FabSeries($v['id'], $v['nome'], $v['nivel'], $v['status']);
                        array_push($obj, $fabSerie);
                    endforeach;
                }else{
                    $this->smsg->viewMsgDisplay('error0010');
                }
            }catch (PDOException $e){
                $this->smsg->viewMsgDisplay('error0008');
                print_r($e->errorInfo);
            }
        }

        $this->finalizaDao();
        return $obj;
    }

    /**
     * @param $chave
     * @return FabSeries|null
     */
    public function consultRegisterById($chave){
        $obj = null;
        $sql = 'SELECT * FROM '.ConnectionPDO::$TBSERIS.' WHERE id=:id';

        try{
            $this->sttm = $this->conn->prepare($sql);
            $this->sttm-> bindValue(':id', $chave, PDO::PARAM_INT);
            $this->sttm->execute();
            if($this->sttm->rowCount() == 1){
                $this->rslt = $this->sttm->fetch(PDO::FETCH_ASSOC);
                $obj = new FabSeries($this->rslt['id'], $this->rslt['nome'], $this->rslt['nivel'], $this->rslt['status']);
            }else{
                $this->smsg->viewMsgDisplay('error0010');
            }
        }catch (PDOException $e){
            $this->smsg->viewMsgDisplay('error0008');
            print_r($e->errorInfo);
        }

        $this->finalizaDao();
        return $obj;
    }

    /**
     * @param FabSeries $fabSeries
     * @return bool
     */
    public function newRegister(FabSeries $fabSeries){
        $obj = false;
        $sql = 'INSERT INTO '.ConnectionPDO::$TBSERIS.' (nome, nivel, status) VALUES (:nome, :nivel, :status)';

        if($this->singleRegister($fabSeries) == false){
            try{
                $this->sttm = $this->conn->prepare($sql);
                $this->sttm->bindValue(':nome', $fabSeries->getNome(), PDO::PARAM_STR);
                $this->sttm->bindValue(':nivel', $fabSeries->getNivel(), PDO::PARAM_INT);
                $this->sttm->bindValue(':status', $fabSeries->getStatus(), PDO::PARAM_BOOL);
                $this->sttm->execute();
                if($this->sttm->rowCount() >= 1){
                    $obj = true;
                    $this->smsg->createMsg('sucs0003');
                }else{
                    $this->smsg->createMsg('error0009');
                    print_r($this->sttm->errorInfo());
                }
            }catch (PDOException $e){
                $this->smsg->createMsg('error0008');
                print_r($e->errorInfo);
            }
        }else{
            $this->smsg->createMsg('error0007');
        }

        $this->finalizaDao();
        return $obj;
    }

    /**
     * @param FabSeries $fabSeries
     * @return bool
     */
    public function upRegister(FabSeries $fabSeries){
        $obj = false;
        $sql = 'UPDATE '.ConnectionPDO::$TBSERIS.' SET nome=:nome, nivel=:nivel, status=:status WHERE id=:id';

        if($this->singleRegister($fabSeries) == false){
            try{
                $this->sttm = $this->conn->prepare($sql);
                $this->sttm->bindValue(':nome', $fabSeries->getNome(), PDO::PARAM_STR);
                $this->sttm->bindValue(':nivel', $fabSeries->getNivel(), PDO::PARAM_INT);
                $this->sttm->bindValue(':status', $fabSeries->getStatus(), PDO::PARAM_BOOL);
                $this->sttm->bindValue(':id', $fabSeries->getId(), PDO::PARAM_INT);
                $this->sttm->execute();
                if($this->sttm->rowCount() >= 1){
                    $obj = true;
                    $this->smsg->createMsg('sucs0003');
                }else{
                    $this->smsg->createMsg('error0009');
                    print_r($this->sttm->errorInfo());
                }
            }catch (PDOException $e){
                $this->smsg->createMsg('error0008');
                print_r($e->errorInfo);
            }
        }else{
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
        $sql = 'DELETE FROM '.ConnectionPDO::$TBSERIS.' WHERE id=:id';

        try{
            $this->sttm = $this->conn->prepare($sql);
            $this->sttm->bindValue(':id', $chave, PDO::PARAM_INT);
            $this->sttm->execute();
            if($this->sttm->rowCount() >= 1){
                $obj = true;
                $this->smsg->createMsg('sucs0003');
            }else{
                $this->smsg->createMsg('error0009');
                print_r($this->sttm->errorInfo());
            }
        }catch (PDOException $e){
            $this->smsg->createMsg('error0008');
            print_r($e->errorInfo);
        }

        $this->finalizaDao();
        return $obj;
    }
}