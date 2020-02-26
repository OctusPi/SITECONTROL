<?php
/**
 * Created by PhpStorm.
 * User: octuspi
 * Date: 16/03/18
 * Time: 13:18
 * Class DaoEscola
 */

class DaoEscola extends DaoObject
{
    /**
     * DaoObject constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param FabEscola $fabEscola
     * @return bool
     */
    private function singleRegister(FabEscola $fabEscola){
        $obj = false;
        $sql = 'SELECT * FROM '.ConnectionPDO::$TBESCOL.' WHERE inep=:inep AND cidade=:cidade AND id!=:id';

        try{
            $this->sttm = $this->conn->prepare($sql);
            $this->sttm->bindValue(':inep', $fabEscola->getInep(), PDO::PARAM_STR);
            $this->sttm->bindValue(':cidade', $fabEscola->getCidade(), PDO::PARAM_INT);
            $this->sttm->bindValue(':id', $fabEscola->getId(), PDO::PARAM_INT);
            $this->sttm->execute();
            if($this->sttm->rowCount() >= 1){
                $obj = true;
            }
        }catch (PDOException $e){
            $secMsg = new SecurityMsg();
            $secMsg->createMsg('error0008');
            print_r($e->errorInfo);
        }

        return $obj;
    }

    /**
     * @param FabUsuario $fabUsuario
     * @param null $chave
     * @return array|null
     */
    public function consultRegister(FabUsuario $fabUsuario, $chave = null){
        $obj    = null;
        $daoMun = new DaoMunicipio();

        if($chave == null){
            $sql = 'SELECT * FROM '.ConnectionPDO::$TBESCOL.' ORDER BY nome';
            try{
                $this->sttm = $this->conn->prepare($sql);
                $this->sttm->execute();
                if($this->sttm->rowCount() >= 1){
                    $this->rslt = $this->sttm->fetchAll(PDO::FETCH_ASSOC);
                    $obj = array();
                    foreach($this->rslt as $v):
                        $rscMun = $daoMun->consultRegisterById($v['cidade']);
                        //verification profile and access
                        if($fabUsuario->getPerfil() == 0){
                            $fabEscola = new FabEscola($v['id'], $rscMun, $v['inep'], $v['nome'], $v['endereco'], $v['encarregado'], $v['telefone'], $v['email']);
                            array_push($obj, $fabEscola);
                        }else{
                            if(in_array($v['cidade'], $fabUsuario->getMunicipio())):
                                $fabEscola = new FabEscola($v['id'], $v['cidade'], $v['inep'], $v['nome'], $v['endereco'], $v['encarregado'], $v['telefone'], $v['email']);
                                array_push($obj, $fabEscola);
                            endif;
                        }
                    endforeach;
                }else{
                    $this->smsg->viewMsgDisplay('error0010');
                }
            }catch (PDOException $e){
                $this->smsg->viewMsgDisplay('error0008');
                print_r($e->errorInfo);
            }
        }else{
            $sql = 'SELECT * FROM '.ConnectionPDO::$TBESCOL.' WHERE inep=:inep OR nome LIKE :nome ORDER BY nome';
            try{
                $this->sttm = $this->conn->prepare($sql);
                $this->sttm-> bindValue(':inep', $chave, PDO::PARAM_STR);
                $this->sttm-> bindValue(':nome', '%'.$chave.'%', PDO::PARAM_STR);
                $this->sttm->execute();
                if($this->sttm->rowCount() >= 1){
                    $this->rslt = $this->sttm->fetchAll(PDO::FETCH_ASSOC);
                    $obj = array();
                    foreach($this->rslt as $v):
                        $rscMun = $daoMun->consultRegisterById($v['cidade']);
                        //verification profile and access
                        if($fabUsuario->getPerfil() == 0){
                            $fabEscola = new FabEscola($v['id'], $rscMun, $v['inep'], $v['nome'], $v['endereco'], $v['encarregado'], $v['telefone'], $v['email']);
                            array_push($obj, $fabEscola);
                        }else{
                            if(in_array($v['cidade'], $fabUsuario->getMunicipio())):
                                $fabEscola = new FabEscola($v['id'], $v['cidade'], $v['inep'], $v['nome'], $v['endereco'], $v['encarregado'], $v['telefone'], $v['email']);
                                array_push($obj, $fabEscola);
                            endif;
                        }
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
     * @param FabUsuario $fabUsuario
     * @return array|null
     */
    public function consultRegisterByAccess(FabUsuario $fabUsuario){
        $obj    = null;
        $daoMun = new DaoMunicipio();

        $sql = 'SELECT * FROM '.ConnectionPDO::$TBESCOL.' ORDER BY nome';
        try{
            $this->sttm = $this->conn->prepare($sql);
            $this->sttm->execute();
            if($this->sttm->rowCount() >= 1){
                $this->rslt = $this->sttm->fetchAll(PDO::FETCH_ASSOC);
                $obj = array();
                foreach($this->rslt as $v):
                    $rscMun = $daoMun->consultRegisterById($v['cidade']);
                    ///verification profile and access
                    if($fabUsuario->getPerfil() == 0){
                        $fabEscola = new FabEscola($v['id'], $rscMun, $v['inep'], $v['nome'], $v['endereco'], $v['encarregado'], $v['telefone'], $v['email']);
                        array_push($obj, $fabEscola);
                    }elseif($fabUsuario->getPerfil() == 1){
                        if(in_array($v['cidade'], $fabUsuario->getMunicipio())):
                            $fabEscola = new FabEscola($v['id'], $rscMun, $v['inep'], $v['nome'], $v['endereco'], $v['encarregado'], $v['telefone'], $v['email']);
                            array_push($obj, $fabEscola);
                        endif;
                    }else{
                        if(in_array($v['cidade'], $fabUsuario->getMunicipio()) && in_array($v['id'], $fabUsuario->getVinculo())):
                            $fabEscola = new FabEscola($v['id'], $rscMun, $v['inep'], $v['nome'], $v['endereco'], $v['encarregado'], $v['telefone'], $v['email']);
                            array_push($obj, $fabEscola);
                        endif;
                    }

                endforeach;
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
     * @param FabUsuario $fabUsuario
     * @param $chave
     * @return FabEscola|null
     */
    public function consultRegisterById(FabUsuario $fabUsuario, $chave){
        $obj    = null;
        $daoMun = new DaoMunicipio();

        $sql = 'SELECT * FROM '.ConnectionPDO::$TBESCOL.' WHERE id=:id';
        try{
            $this->sttm = $this->conn->prepare($sql);
            $this->sttm-> bindValue(':id', $chave, PDO::PARAM_INT);
            $this->sttm->execute();
            if($this->sttm->rowCount() == 1){
                $this->rslt = $this->sttm->fetch(PDO::FETCH_ASSOC);
                $rscMun = $daoMun->consultRegisterById($this->rslt['cidade']);

                if($fabUsuario->getPerfil() == 0 or ($fabUsuario->getPerfil() == 1 && in_array($this->rslt['cidade'], $fabUsuario->getMunicipio()))):
                    $obj = new FabEscola($this->rslt['id'], $rscMun, $this->rslt['inep'], $this->rslt['nome'], $this->rslt['endereco'],
                    $this->rslt['encarregado'], $this->rslt['telefone'], $this->rslt['email']);
                endif;
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
     * @param FabEscola $fabEscola
     * @return bool
     */
    public function newRegister(FabEscola $fabEscola){
        $obj = false;
        $sql = 'INSERT INTO '.ConnectionPDO::$TBESCOL.' (cidade, inep, nome, endereco, encarregado, telefone, email) VALUES (:cidade, :inep, :nome, :endereco, :encarregado, :telefone, :email)';

        if($this->singleRegister($fabEscola) == false){
            try{
                $this->sttm = $this->conn->prepare($sql);
                $this->sttm->bindValue(':cidade', $fabEscola->getCidade(), PDO::PARAM_INT);
                $this->sttm->bindValue(':inep', $fabEscola->getInep(), PDO::PARAM_STR);
                $this->sttm->bindValue(':nome', $fabEscola->getNome(), PDO::PARAM_STR);
                $this->sttm->bindValue(':endereco', $fabEscola->getEndereco(), PDO::PARAM_STR);
                $this->sttm->bindValue(':encarregado', $fabEscola->getEncarregado(), PDO::PARAM_STR);
                $this->sttm->bindValue(':telefone', $fabEscola->getTelefone(), PDO::PARAM_STR);
                $this->sttm->bindValue(':email', $fabEscola->getEmail(), PDO::PARAM_STR);
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
     * @param FabEscola $fabEscola
     * @return bool
     */
    public function upRegister(FabEscola $fabEscola){
        $obj = false;
        $sql = 'UPDATE '.ConnectionPDO::$TBESCOL.' SET cidade=:cidade, inep=:inep, nome=:nome, endereco=:endereco, encarregado=:encarregado, telefone=:telefone, email=:email WHERE id=:id';

        if($this->singleRegister($fabEscola) == false){
            try{
                $this->sttm = $this->conn->prepare($sql);
                $this->sttm->bindValue(':cidade', $fabEscola->getCidade(), PDO::PARAM_INT);
                $this->sttm->bindValue(':inep', $fabEscola->getInep(), PDO::PARAM_STR);
                $this->sttm->bindValue(':nome', $fabEscola->getNome(), PDO::PARAM_STR);
                $this->sttm->bindValue(':endereco', $fabEscola->getEndereco(), PDO::PARAM_STR);
                $this->sttm->bindValue(':encarregado', $fabEscola->getEncarregado(), PDO::PARAM_STR);
                $this->sttm->bindValue(':telefone', $fabEscola->getTelefone(), PDO::PARAM_STR);
                $this->sttm->bindValue(':email', $fabEscola->getEmail(), PDO::PARAM_STR);
                $this->sttm->bindValue(':id', $fabEscola->getId(), PDO::PARAM_INT);
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
            $this->smsg-> createMsg('error0007');
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
        $sql = 'DELETE FROM '.ConnectionPDO::$TBESCOL.' WHERE id=:id';

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