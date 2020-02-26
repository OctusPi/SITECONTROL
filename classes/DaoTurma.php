<?php
/**
 * Created by PhpStorm.
 * User: octus
 * Date: 01/04/18
 * Time: 23:38
 */
include_once('DaoObject.php');
include_once('FabEscola.php');
include_once('FabSeries.php');
include_once('DaoEscola.php');
include_once('DaoSeries.php');

/**
 * Class DaoTurma
 */
class DaoTurma extends DaoObject
{
    private $daoEscola;
    private $daoSerie;

    /**
     * DaoTurma constructor.
     */
    public function __construct()
    {
        $this->daoEscola = new DaoEscola();
        $this->daoSerie  = new DaoSeries();
        parent::__construct();
    }

    /**
     * @param FabTurma $fabTurma
     * @return bool
     */
    private function singleRegister(FabTurma $fabTurma){
        $obj = false;
        $sql = 'SELECT * FROM '.ConnectionPDO::$TBTURMS.' WHERE escola=:escola AND serie=:serie AND nome=:nome AND id!=:id';

        try{
            $this->sttm = $this->conn->prepare($sql);
            $this->sttm->bindValue(':escola', $fabTurma->getEscola()->getId(), PDO::PARAM_INT);
            $this->sttm->bindValue(':serie', $fabTurma->getSerie()->getId(), PDO::PARAM_INT);
            $this->sttm->bindValue(':nome', $fabTurma->getNome(), PDO::PARAM_STR);
            $this->sttm->bindValue(':id', $fabTurma->getId(), PDO::PARAM_INT);
            $this->sttm->execute();
            if($this->sttm->rowCount() >= 1){
                $obj = true;
            }
        }catch (PDOException $e){
            $msg = new SecurityMsg();
            $msg->createMsg('error0008');
            print_r($e->errorInfo);
        }

        return $obj;
    }

    /**
     * @param null $escola
     * @param null $serie
     * @return array|null
     */
    public function consultRegister($escola = null, $serie = null){
        $obj = null;
        $msg = new SecurityMsg();

        if($escola == null or $serie == null){
            $sql = 'SELECT * FROM '.ConnectionPDO::$TBTURMS.' ORDER BY escola ASC, serie ASC, nome ASC LIMIT 0,20';
            try{
                $this->sttm = $this->conn->prepare($sql);
                $this->sttm->execute();
                if($this->sttm->rowCount() >= 1){
                    $this->rslt = $this->sttm->fetchAll(PDO::FETCH_ASSOC);
                    $obj = array();
                    foreach($this->rslt as $v):
                        $fabEscola = $this->daoEscola->consultRegisterById($v['escola']);
                        $fabSerie  = $this->daoSerie->consultRegisterById($v['serie']);
                        $fabTurma  = new FabTurma($v['id'], $fabEscola, $fabSerie, $v['nome'], $v['turno'], $v['status']);
                        array_push($obj, $fabTurma);
                    endforeach;
                }else{
                    $msg->viewMsgDisplay('error0010');
                }
            }catch (PDOException $e){
                $msg->viewMsgDisplay('error0008');
                print_r($e->errorInfo);
            }
        }else{
            $sql = 'SELECT * FROM '.ConnectionPDO::$TBTURMS.' WHERE escola=:escola AND serie=:serie ORDER BY nome';
            try{
                $this->sttm = $this->conn->prepare($sql);
                $this->sttm-> bindValue(':escola', $escola, PDO::PARAM_INT);
                $this->sttm-> bindValue(':serie', $serie, PDO::PARAM_INT);
                $this->sttm->execute();
                if($this->sttm->rowCount() >= 1){
                    $this->rslt = $this->sttm->fetchAll(PDO::FETCH_ASSOC);
                    $obj = array();
                    foreach($this->rslt as $v):
                        $fabEscola = $this->daoEscola->consultRegisterById($v['escola']);
                        $fabSerie  = $this->daoSerie->consultRegisterById($v['serie']);
                        $fabTurma  = new FabTurma($v['id'], $fabEscola, $fabSerie, $v['nome'], $v['turno'], $v['status']);
                        array_push($obj, $fabTurma);
                    endforeach;
                }else{
                    $msg->viewMsgDisplay('error0010');
                }
            }catch (PDOException $e){
                $msg->viewMsgDisplay('error0008');
                print_r($e->errorInfo);
            }
        }

        $this->finalizaDao();
        return $obj;
    }

    /**
     * @param $chave
     * @return FabTurma|null
     */
    public function consultRegisterById($chave){
        $obj = null;
        $msg = new SecurityMsg();

        $sql = 'SELECT * FROM '.ConnectionPDO::$TBTURMS.' WHERE id=:id';
        try{
            $this->sttm = $this->conn->prepare($sql);
            $this->sttm-> bindValue(':id', $chave, PDO::PARAM_INT);
            $this->sttm->execute();
            if($this->sttm->rowCount() == 1){
                $this->rslt = $this->sttm->fetch(PDO::FETCH_ASSOC);
                $fabEscola  = $this->daoEscola->consultRegisterById($this->rslt['escola']);
                $fabSerie   = $this->daoSerie->consultRegisterById($this->rslt['serie']);
                $obj = new FabTurma($this->rslt['id'], $fabEscola, $fabSerie, $this->rslt['nome'],
                    $this->rslt['turno'], $this->rslt['status']);
            }else{
                $msg->viewMsgDisplay('error0010');
            }
        }catch (PDOException $e){
            $msg->viewMsgDisplay('error0008');
            print_r($e->errorInfo);
        }

        $this->finalizaDao();
        return $obj;
    }


    /**
     * @param FabTurma $fabTurma
     * @return bool
     */
    public function newRegister(FabTurma $fabTurma){
        $obj = false;
        $msg = new SecurityMsg();
        $sql = 'INSERT INTO '.ConnectionPDO::$TBTURMS.' (escola, serie, nome, turno, status) VALUES (:escola, :serie, :nome, :turno, :status)';

        if($this->singleRegister($fabTurma) == false){
            try{
                $this->sttm = $this->conn->prepare($sql);
                $this->sttm->bindValue(':escola', $fabTurma->getEscola()->getId(), PDO::PARAM_INT);
                $this->sttm->bindValue(':serie', $fabTurma->getSerie()->getId(), PDO::PARAM_INT);
                $this->sttm->bindValue(':nome', $fabTurma->getNome(), PDO::PARAM_STR);
                $this->sttm->bindValue(':turno', $fabTurma->getTurno(), PDO::PARAM_INT);
                $this->sttm->bindValue(':status', $fabTurma->getStatus(), PDO::PARAM_BOOL);
                $this->sttm->execute();
                if($this->sttm->rowCount() >= 1){
                    $obj = true;
                    $msg->createMsg('sucs0003');
                }else{
                    $msg->createMsg('error0009');
                    print_r($this->sttm->errorInfo());
                }
            }catch (PDOException $e){
                $msg->createMsg('error0008');
                print_r($e->errorInfo);
            }
        }else{
            $msg->createMsg('error0007');
        }

        $this->finalizaDao();
        return $obj;
    }

    /**
     * @param FabTurma $fabTurma
     * @return bool
     */
    public function upRegister(FabTurma $fabTurma){
        $obj = false;
        $msg = new SecurityMsg();
        $sql = 'UPDATE '.ConnectionPDO::$TBTURMS.' SET escola=:escola, serie=:serie, nome=:nome, turno=:turno, status=:status WHERE id=:id';

        if($this->singleRegister($fabTurma) == false){
            try{
                $this->sttm = $this->conn->prepare($sql);
                $this->sttm->bindValue(':escola', $fabTurma->getEscola()->getId(), PDO::PARAM_INT);
                $this->sttm->bindValue(':serie', $fabTurma->getSerie()->getId(), PDO::PARAM_INT);
                $this->sttm->bindValue(':nome', $fabTurma->getNome(), PDO::PARAM_STR);
                $this->sttm->bindValue(':turno', $fabTurma->getTurno(), PDO::PARAM_INT);
                $this->sttm->bindValue(':status', $fabTurma->getStatus(), PDO::PARAM_BOOL);
                $this->sttm->bindValue(':id', $fabTurma->getId(), PDO::PARAM_INT);
                $this->sttm->execute();
                if($this->sttm->rowCount() >= 1){
                    $obj = true;
                    $msg->createMsg('sucs0003');
                }else{
                    $msg->createMsg('error0009');
                    print_r($this->sttm->errorInfo());
                }
            }catch (PDOException $e){
                $msg->createMsg('error0008');
                print_r($e->errorInfo);
            }
        }else{
            $msg->createMsg('error0007');
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
        $msg = new SecurityMsg();
        $sql = 'DELETE FROM '.ConnectionPDO::$TBTURMS.' WHERE id=:id';

        try{
            $this->sttm = $this->conn->prepare($sql);
            $this->sttm->bindValue(':id', $chave, PDO::PARAM_INT);
            $this->sttm->execute();
            if($this->sttm->rowCount() >= 1){
                $obj = true;
                $msg->createMsg('sucs0003');
            }else{
                $msg->createMsg('error0009');
                print_r($this->sttm->errorInfo());
            }
        }catch (PDOException $e){
            $msg->createMsg('error0008');
            print_r($e->errorInfo);
        }

        $this->finalizaDao();
        return $obj;
    }
}