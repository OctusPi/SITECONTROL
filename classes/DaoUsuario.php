<?php
/**
 * Created by PhpStorm.
 * User: kuroi
 * Date: 13/02/18
 * Time: 19:04
 */

include_once("DaoObject.php");
include_once ("FabUsuario.php");

/**
 * Class DaoUsuario
 */
class DaoUsuario extends DaoObject
{
    /**
     * DaoUsuario constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * verify user Login
     * @param $iduser
     * @param $idpass
     * @return null
     */
    public function getUserByLogin($iduser, $idpass){
        $obj = null;
        try{
            $sql = 'SELECT * FROM '.ConnectionPDO::$TBUSERS.' WHERE iduser=:iduser AND idpass=:idpass';
            $this->sttm = $this->conn->prepare($sql);
            $this->sttm->bindValue(':iduser', $iduser, PDO::PARAM_STR);
            $this->sttm->bindValue(':idpass', $idpass, PDO::PARAM_STR);
            $this->sttm->execute();
            if($this->sttm->rowCount() == 1){
                $this->rslt = $this->sttm->fetch(PDO::FETCH_ASSOC);
                $obj  = new FabUsuario($this->rslt['id'], $this->rslt['nome'], $this->rslt['email'],
                    $this->rslt['cpf'], $this->rslt['iduser'], $this->rslt['idpass'],
                    $this->rslt['status'], $this->rslt['perfil'], $this->rslt['nivel'],
                    $this->rslt['vinculo'], $this->rslt['municipio'], $this->rslt['oldlogin'], $this->rslt['newlogin'], $this->rslt['uppass']);
            }
        }catch (PDOException $e){
            print_r($e->getMessage());
        }
        $this->finalizaDao();
        return $obj;
    }

    /**
     * verify user exist
     * @param $iduser
     * @return null
     */
    public function getUserExist($iduser){
        $obj = null;
        try{
            $sql = 'SELECT * FROM '.ConnectionPDO::$TBUSERS.' WHERE iduser=:iduser';
            $this->sttm = $this->conn->prepare($sql);
            $this->sttm->bindValue(':iduser', $iduser, PDO::PARAM_STR);
            $this->sttm->execute();
            if($this->sttm->rowCount() == 1){
                $this->rslt = $this->sttm->fetch(PDO::FETCH_ASSOC);
                $obj  = new FabUsuario($this->rslt['id'], $this->rslt['nome'],
                $this->rslt['email'], $this->rslt['cpf'], $this->rslt['iduser'],
                $this->rslt['idpass'], $this->rslt['status'], $this->rslt['perfil'],
                $this->rslt['nivel'], $this->rslt['vinculo'], $this->rslt['municipio'], $this->rslt['oldlogin'], $this->rslt['newlogin'], $this->rslt['uppass']);
            }
        }catch (PDOException $e){
            print_r($e->getMessage());
        }

        $this->finalizaDao();
        return $obj;
    }

    /**
     * @param FabUsuario $usuario
     * @param $password
     * @param $uppass
     * @return bool
     */
    public function changeUserPass(FabUsuario $usuario, $password, $uppass){
        $obj = false;
        try{
            $sql  = 'UPDATE '.ConnectionPDO::$TBUSERS.' SET idpass=:idpass, uppass=:uppass WHERE id=:id';
            $this->sttm = $this->conn->prepare($sql);
            $this->sttm->bindValue(':idpass', $password, PDO::PARAM_STR);
            $this->sttm->bindValue(':uppass', $uppass, PDO::PARAM_BOOL);
            $this->sttm->bindValue(':id', $usuario->getId(), PDO::PARAM_INT);
            $this->sttm->execute();
            if($this->sttm->rowCount() == 1){
                $obj = true;
            }
        }catch (PDOException $e){
            print_r($e->getMessage());
        }
        $this->finalizaDao();
        return $obj;
    }

    /**
     * @param FabUsuario $usuario
     * @param $tempo
     * @return bool
     */
    public function registerLogin(FabUsuario $usuario, $tempo){
        $obj = false;
        try{
            $sql  = 'UPDATE '.ConnectionPDO::$TBUSERS.' SET oldlogin=:oldlogin, newlogin=:newlogin WHERE id=:id';
            $this->sttm = $this->conn->prepare($sql);
            $this->sttm->bindValue(':oldlogin', $usuario->getNewlogin(), PDO::PARAM_STR);
            $this->sttm->bindValue(':newlogin', $tempo, PDO::PARAM_STR);
            $this->sttm->bindValue(':id', $usuario->getId(), PDO::PARAM_INT);
            $this->sttm->execute();
            if($this->sttm->rowCount() == 1){
                $obj = true;
            }
        }catch (PDOException $e){
            print_r($e->getMessage());
        }
        $this->finalizaDao();
        return $obj;
    }

    /**
     * @param FabUsuario $usuario
     * @return bool
     */
    private function singleRegister(FabUsuario $usuario){
        $obj = false;
        try{
            $sql  = 'SELECT * FROM '.ConnectionPDO::$TBUSERS.' WHERE cpf=:cpf AND id!=:id';
            $this->sttm = $this->conn->prepare($sql);
            $this->sttm->bindValue(':cpf', $usuario->getCpf(), PDO::PARAM_STR);
            $this->sttm->bindValue(':id', $usuario->getId(), PDO::PARAM_INT);
            $this->sttm->execute();
            if($this->sttm->rowCount() >= 1){
                $obj = true;
            }
        }catch (PDOException $e){
            print_r($e->getMessage());
        }
        return $obj;
    }

    /**
     * @param null $chave
     * @return array|null
     */
    public function consultRegister($chave = null){
        $obj = null;
        $sec = new SecurityMsg();

        if($chave == null){
            $sql = 'SELECT * FROM '.ConnectionPDO::$TBUSERS.' ORDER BY nome';
            try{
                $this->sttm = $this->conn->prepare($sql);
                $this->sttm->execute();
                if($this->sttm->rowCount() >= 1){
                    $this->rslt = $this->sttm->fetchAll(PDO::FETCH_ASSOC);
                    $obj = array();
                    foreach($this->rslt as $v):
                        $fabUsuario = new FabUsuario($v['id'], $v['nome'], $v['email'], $v['cpf'], $v['iduser'],
                        $v['idpass'], $v['status'], $v['perfil'], $v['nivel'], $v['vinculo'], $v['municipio'], $v['oldlogin'], $v['newlogin'], $v['uppass']);
                        array_push($obj, $fabUsuario);
                    endforeach;
                }else{
                    $sec->viewMsgDisplay('error0010');
                }
            }catch (PDOException $e){
                $sec->viewMsgDisplay('error0008');
                print_r($e->errorInfo);
            }
        }else{
            $sql = 'SELECT * FROM '.ConnectionPDO::$TBUSERS.' WHERE cpf=:cpf OR nome LIKE :nome ORDER BY nome';
            try{
                $this->sttm = $this->conn->prepare($sql);
                $this->sttm-> bindValue(':cpf', $chave, PDO::PARAM_STR);
                $this->sttm-> bindValue(':nome', '%'.$chave.'%', PDO::PARAM_STR);
                $this->sttm->execute();
                if($this->sttm->rowCount() >= 1){
                    $this->rslt = $this->sttm->fetchAll(PDO::FETCH_ASSOC);
                    $obj = array();
                    foreach($this->rslt as $v):
                        $fabUsuario = new FabUsuario($v['id'], $v['nome'], $v['email'], $v['cpf'], $v['iduser'], $v['idpass'],
                            $v['status'], $v['perfil'], $v['nivel'], $v['vinculo'], $v['municipio'], $v['oldlogin'], $v['newlogin'], $v['uppass']);
                        array_push($obj, $fabUsuario);
                    endforeach;
                }else{
                    $sec->viewMsgDisplay('error0010');
                }
            }catch (PDOException $e){
                $sec->viewMsgDisplay('error0008');
                print_r($e->errorInfo);
            }
        }

        $this->finalizaDao();
        return $obj;
    }

    /**
     * @param $chave
     * @return FabUsuario|null
     */
    public function consultRegisterById($chave){
        $obj = null;
        $sec = new SecurityMsg();

        $sql = 'SELECT * FROM '.ConnectionPDO::$TBUSERS.' WHERE id=:id';
        try{
            $this->sttm = $this->conn->prepare($sql);
            $this->sttm-> bindValue(':id', $chave, PDO::PARAM_INT);
            $this->sttm->execute();
            if($this->sttm->rowCount() == 1){
                $this->rslt = $this->sttm->fetch(PDO::FETCH_ASSOC);
                $obj = new FabUsuario($this->rslt['id'], $this->rslt['nome'], $this->rslt['email'],
                $this->rslt['cpf'], $this->rslt['iduser'], $this->rslt['idpass'], $this->rslt['status'],
                $this->rslt['perfil'], $this->rslt['nivel'], $this->rslt['vinculo'], $this->rslt['municipio'], $this->rslt['oldlogin'], $this->rslt['newlogin'], $this->rslt['uppass']);
            }else{
                $sec->viewMsgDisplay('error0010');
            }
        }catch (PDOException $e){
            $sec->viewMsgDisplay('error0008');
            print_r($e->errorInfo);
        }

        $this->finalizaDao();
        return $obj;
    }

    /**
     * @param FabUsuario $usuario
     * @return bool
     */
    public function newRegister(FabUsuario $usuario){
        $obj = false;
        $msg = new SecurityMsg();
        $sql = 'INSERT INTO '.ConnectionPDO::$TBUSERS.' (nome, email, cpf, iduser, idpass, status, perfil, nivel, vinculo, municipio, uppass) 
                VALUES (:nome, :email, :cpf, :iduser, :idpass, :status, :perfil, :nivel, :vinculo, :municipio, :uppass)';

        if($this->singleRegister($usuario) == false){
            $this->sttm = $this->conn->prepare($sql);
            $this->sttm->bindValue(':nome', $usuario->getNome(), PDO::PARAM_STR);
            $this->sttm->bindValue(':email', $usuario->getEmail(), PDO::PARAM_STR);
            $this->sttm->bindValue(':cpf', $usuario->getCpf(), PDO::PARAM_STR);
            $this->sttm->bindValue(':iduser', $usuario->getIduser(), PDO::PARAM_STR);
            $this->sttm->bindValue(':idpass', $usuario->getIdpass(), PDO::PARAM_STR);
            $this->sttm->bindValue(':status', $usuario->getStatus(), PDO::PARAM_BOOL);
            $this->sttm->bindValue(':perfil', $usuario->getPerfil(), PDO::PARAM_INT);
            $this->sttm->bindValue(':nivel', $usuario->getNivelStr(), PDO::PARAM_STR);
            $this->sttm->bindValue(':vinculo', $usuario->getVinculoStr(), PDO::PARAM_STR);
            $this->sttm->bindValue(':municipio', $usuario->getMunicipioStr(), PDO::PARAM_STR);
            $this->sttm->bindValue(':uppass', $usuario->getUppass(), PDO::PARAM_BOOL);
            $this->sttm->execute();
            if($this->sttm->rowCount() >= 1){
                $obj = true;
                $msg->createMsg('sucs0003');
            }else{
                $msg->createMsg('error0009');
                print_r($this->sttm->errorInfo());
            }
        }else{
            $msg->createMsg('error0007');
        }

        $this->finalizaDao();
        return $obj;
    }

    /**
     * @param FabUsuario $usuario
     * @return bool
     */
    public function upRegister(FabUsuario $usuario){
        $obj = false;
        $msg = new SecurityMsg();
        $sql = 'UPDATE '.ConnectionPDO::$TBUSERS.' SET nome=:nome, email=:email, cpf=:cpf, iduser=:iduser, 
                status=:status, perfil=:perfil, nivel=:nivel, vinculo=:vinculo, municipio=:municipio, uppass=:uppass WHERE id=:id';

        if($this->singleRegister($usuario) == false){
            $this->sttm = $this->conn->prepare($sql);
            $this->sttm->bindValue(':nome', $usuario->getNome(), PDO::PARAM_STR);
            $this->sttm->bindValue(':email', $usuario->getEmail(), PDO::PARAM_STR);
            $this->sttm->bindValue(':cpf', $usuario->getCpf(), PDO::PARAM_STR);
            $this->sttm->bindValue(':iduser', $usuario->getIduser(), PDO::PARAM_STR);
            $this->sttm->bindValue(':status', $usuario->getStatus(), PDO::PARAM_BOOL);
            $this->sttm->bindValue(':perfil', $usuario->getPerfil(), PDO::PARAM_INT);
            $this->sttm->bindValue(':nivel', $usuario->getNivelStr(), PDO::PARAM_STR);
            $this->sttm->bindValue(':vinculo', $usuario->getVinculoStr(), PDO::PARAM_STR);
            $this->sttm->bindValue(':municipio', $usuario->getMunicipioStr(), PDO::PARAM_STR);
            $this->sttm->bindValue(':uppass', $usuario->getUppass(), PDO::PARAM_BOOL);
            $this->sttm->bindValue(':id', $usuario->getId(), PDO::PARAM_INT);
            $this->sttm->execute();
            if($this->sttm->rowCount() >= 1){
                $obj = true;
                $msg->createMsg('sucs0003');
            }else{
                $msg->createMsg('error0009');
                print_r($this->sttm->errorInfo());
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
        $sql = 'DELETE FROM '.ConnectionPDO::$TBUSERS.' WHERE id=:id';

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