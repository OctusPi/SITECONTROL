<?php
/**
 * Class ImpUsuarioDao
 */
class ImpUsuarioDao extends FactoryDao implements InterfaceDao
{
    private static $TABLE;
    private $ctSecurity;

    /**
     * ImpUsuarioDao constructor.
     */
    public function __construct(CTSecuritySystem $ctSecurity)
    {
        parent::__construct();
        self::$TABLE = DBConnection::$TBUSUARIO;
        $this->ctSecurity = $ctSecurity;
    }

    /**
     * @return CTSecuritySystem
     */
    public function getCtSecurity()
    {
        return $this->ctSecurity;
    }

    /**
     * @param $obj
     * @return bool
     */
    public function isUnique($obj)
    {
        $out = true;
        try{
            $sql  = 'SELECT * FROM '.self::$TABLE.' WHERE cpf = ? AND id != ?';

            $this->st  = $this->con->prepare($sql);
            $this->st -> bindValue(1, $obj->getCpf(), PDO::PARAM_STR);
            $this->st -> bindValue(2, $obj->getId(), PDO::PARAM_INT);
            $this->st -> execute();

            $rows = $this->st -> rowCount();
            $out  = $rows > 0 ? false : true;
        }
        catch (PDOException $e){
            throw new DBException($e->getMessage());
        }
        finally{
            parent::closeFactoryDao();
            return $out;
        }
    }

    /**
     * @param $id
     * @return EntiteUsuario|null
     */
    public function findById($id)
    {
        // TODO: Implement findById() method.
        $out  = null;

        try{
            $sql  = 'SELECT * FROM '.self::$TABLE.' WHERE id = ?';

            $this->st  = $this->con->prepare($sql);
            $this->st -> bindValue(1, $id, PDO::PARAM_INT);
            $this->st -> execute();

            $rows = $this->st -> rowCount();

            if($rows > 0){
                $this->rs = $this->st->fetch(PDO::FETCH_ASSOC);
                $out  = new EntiteUsuario($this->rs['id'], $this->rs['nome'], $this->rs['cpf'], $this->rs['email'],
                    $this->rs['id_user'], $this->rs['id_pass'], $this->rs['perfil_acesso'], $this->rs['nivel_acesso'],
                    $this->rs['status'],$this->rs['pass_change'], $this->rs['last_login'], $this->rs['now_login'],
                    $this->rs['vinculo'], $this->rs['escolas_associadas']);
            }
        }
        catch (PDOException $e){
            throw new DBException($e->getMessage());
        }
        finally{
            parent::closeFactoryDao();
            return $out;
        }
    }

    private function findByCpf($param)
    {
        // TODO: Implement findById() method.
        $out  = null;

        try{
            $sql  = 'SELECT * FROM '.self::$TABLE.' WHERE cpf = ?';

            $this->st  = $this->con->prepare($sql);
            $this->st -> bindValue(1, $param, PDO::PARAM_INT);
            $this->st -> execute();

            $rows = $this->st -> rowCount();

            if($rows > 0){
                $this->rs = $this->st->fetch(PDO::FETCH_ASSOC);
                $out  = new EntiteUsuario($this->rs['id'], $this->rs['nome'], $this->rs['cpf'], $this->rs['email'],
                    $this->rs['id_user'], $this->rs['id_pass'], $this->rs['perfil_acesso'], $this->rs['nivel_acesso'],
                    $this->rs['status'],$this->rs['pass_change'], $this->rs['last_login'], $this->rs['now_login'],
                    $this->rs['vinculo'], $this->rs['escolas_associadas']);
            }
        }
        catch (PDOException $e){
            throw new DBException($e->getMessage());
        }
        finally{
            parent::closeFactoryDao();
            return $out;
        }
    }

    /**
     * @param $param
     * @return array|null
     */
    public function findByParam($param)
    {
        $out  = null;

        try{
            $sql  = 'SELECT * FROM '.DBConnection::$TBUSUARIO.' WHERE cpf = ? OR  nome LIKE  %?% ORDER BY nome';

            $this->st  = $this->con->prepare($sql);
            $this->st -> bindValue(1, $param, PDO::PARAM_STR);
            $this->st -> bindValue(2, $param, PDO::PARAM_STR);
            $this->st -> execute();

            $rows = $this->st -> rowCount();

            if($rows > 0){
                $this->rs = $this->st->fetchAll(PDO::FETCH_ASSOC);
                $out = array();
                foreach($this->rs as $col):
                    array_push($out, new EntiteUsuario($col['id'], $col['nome'], $col['cpf'], $col['email'],
                        $col['id_user'], $col['id_pass'], $col['perfil_acesso'], $col['nivel_acesso'],
                        $col['status'],$col['pass_change'], $col['last_login'], $col['now_login'],
                        $col['vinculo'], $col['escolas_associadas']));
                endforeach;
            }
        }
        catch (PDOException $e){
            throw new DBException($e->getMessage());
        }
        finally{
            parent::closeFactoryDao();
            return $out;
        }
    }

    public function findByLogin($id_user, $id_pass)
    {
        $out  = null;

        try{
            if($id_user != null && $id_pass != null):
                $sql  = 'SELECT * FROM '.DBConnection::$TBUSUARIO.' WHERE id_user = ? AND id_pass = ?';

                $this->st  = $this->con->prepare($sql);
                $this->st -> bindValue(1, $id_user, PDO::PARAM_STR);
                $this->st -> bindValue(2, $id_pass, PDO::PARAM_STR);
                $this->st -> execute();

                $rows = $this->st -> rowCount();

                if($rows > 0){
                    $this->rs = $this->st->fetch(PDO::FETCH_ASSOC);
                    $out  = new EntiteUsuario($this->rs['id'], $this->rs['nome'], $this->rs['cpf'], $this->rs['email'],
                        $this->rs['id_user'], $this->rs['id_pass'], $this->rs['perfil_acesso'], $this->rs['nivel_acesso'],
                        $this->rs['status'],$this->rs['pass_change'], $this->rs['last_login'], $this->rs['now_login'],
                        $this->rs['vinculo'], $this->rs['escolas_associadas']);
                }
            endif;
        }
        catch (PDOException $e){
            throw new DBException($e->getMessage());
        }
        finally{
            parent::closeFactoryDao();
            return $out;
        }
    }

    public function findAll()
    {
        $out  = null;

        try{
            $sql  = 'SELECT * FROM '.DBConnection::$TBUSUARIO.' ORDER BY nome';

            $this->st  = $this->con->prepare($sql);
            $this->st -> execute();

            $rows = $this->st -> rowCount();

            if($rows > 0){
                $this->rs = $this->st->fetchAll(PDO::FETCH_ASSOC);
                $out = array();
                foreach($this->rs as $col):
                    array_push($out, new EntiteUsuario($col['id'], $col['nome'], $col['cpf'], $col['email'],
                        $col['id_user'], $col['id_pass'], $col['perfil_acesso'], $col['nivel_acesso'],
                        $col['status'],$col['pass_change'], $col['last_login'], $col['now_login'],$col['vinculo'],
                        $this->rs['escolas_associadas']));
                endforeach;
            }
        }
        catch (PDOException $e){
            throw new DBException($e->getMessage());
        }
        finally{
            parent::closeFactoryDao();
            return $out;
        }
    }

    public function insere($obj)
    {
        $out = false;
        try{
            if($this->isUnique($obj)) {
                $sql = 'INSERT INTO ' . self::$TABLE . ' (nome, cpf, email, id_user, id_pass, perfil_acesso, nivel_acesso, 
                status, pass_change, last_login, now_login, vinculo, escolas_associadas) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)';

                $this->st = $this->con->prepare($sql);
                $this->st-> bindValue(1, $obj->getNome(), PDO::PARAM_STR);
                $this->st-> bindValue(2, $obj->getCpf(), PDO::PARAM_STR);
                $this->st-> bindValue(3, $obj->getEmail(), PDO::PARAM_STR);
                $this->st-> bindValue(4, $obj->getIdUser(), PDO::PARAM_STR);
                $this->st-> bindValue(5, $obj->getIdPass(), PDO::PARAM_STR);
                $this->st-> bindValue(6, $obj->getPerfilAcesso(), PDO::PARAM_INT);
                $this->st-> bindValue(7, $obj->getNivelAcesso(), PDO::PARAM_STR);
                $this->st-> bindValue(8, $obj->getStatus(), PDO::PARAM_BOOL);
                $this->st-> bindValue(9, $obj->getPassChange(), PDO::PARAM_BOOL);
                $this->st-> bindValue(10, $obj->getLastLogin(), PDO::PARAM_STR);
                $this->st-> bindValue(11, $obj->getNowLogin(), PDO::PARAM_STR);
                $this->st-> bindValue(12, $obj->getVinculo(), PDO::PARAM_INT);
                $this->st-> bindValue(13, $obj->getEscolasAssociadas(), PDO::PARAM_STR);
                $this->st-> execute();

                $rows = $this->st ->rowCount();
                $out  = $rows > 0 ? true : false;

            }
        }
        catch (PDOException $e){
            throw new DBException($e->getMessage());
        }
        finally{
            parent::closeFactoryDao();
            return $out;
        }
    }

    public function update($obj)
    {
        $out = false;

        try{
            if($this->isUnique($obj)) {
                $sql = 'UPDATE ' . self::$TABLE . ' SET nome=?, cpf=?, email=?, id_user=?, id_pass=?, nivel_acesso=?, 
                perfil_acesso=?, status=?, pass_change=?, vinculo=?, escolas_associadas=? WHERE id=?';

                $this->st = $this->con->prepare($sql);
                $this->st-> bindValue(1, $obj->getNome(), PDO::PARAM_STR);
                $this->st-> bindValue(2, $obj->getCpf(), PDO::PARAM_STR);
                $this->st-> bindValue(3, $obj->getEmail(), PDO::PARAM_STR);
                $this->st-> bindValue(4, $obj->getIdUser(), PDO::PARAM_STR);
                $this->st-> bindValue(5, $obj->getIdPass(), PDO::PARAM_STR);
                $this->st-> bindValue(6, $obj->getPerfilAcesso(), PDO::PARAM_INT);
                $this->st-> bindValue(7, $obj->getNivelAcesso(), PDO::PARAM_STR);
                $this->st-> bindValue(8, $obj->getStatus(), PDO::PARAM_BOOL);
                $this->st-> bindValue(9, $obj->getStatus(), PDO::PARAM_BOOL);
                $this->st-> bindValue(10, $obj->getVinculo(), PDO::PARAM_INT);
                $this->st-> bindValue(11, $obj->getEscolasAssociadas(), PDO::PARAM_STR);
                $this->st-> bindValue(12, $obj->getId(), PDO::PARAM_INT);
                $this->st-> execute();

                $rows = $this->st ->rowCount();
                $out  = $rows > 0 ? true : false;
            }
        }
        catch (PDOException $e){
            throw new DBException($e->getMessage());
        }
        finally{
            parent::closeFactoryDao();
            return $out;
        }
    }

    public function delete($id)
    {
        $out = false;

        try{
            $sql = 'DELETE FROM '.self::$TABLE.' WHERE id = ?';

            $this->st  = $this->con ->prepare($sql);
            $this->st -> bindValue(1, $id, PDO::PARAM_INT);
            $this->st -> execute();

            $rows = $this->st ->rowCount();
            $out  = $rows > 0 ? true : false;
        }
        catch (PDOException $e){
            throw new DBException($e->getMessage());
        }
        finally{
            parent::closeFactoryDao();
            return $out;
        }
    }

    public function login($iduser, $idpass){
        $out = false;
        try{
            $obj = null;
            $sql = 'SELECT * FROM '.self::$TABLE.' WHERE id_user = ? AND id_pass = ?';

            $this->st  = $this->con ->prepare($sql);
            $this->st -> bindValue(1, $iduser, PDO::PARAM_STR);
            $this->st -> bindValue(2, $idpass, PDO::PARAM_STR);
            $this->st -> execute();

            $rows = $this->st -> rowCount();

            if($rows > 0):
                $this->rs = $this->st->fetch(PDO::FETCH_ASSOC);
                $obj = new EntiteUsuario($this->rs['id'], $this->rs['nome'], $this->rs['cpf'], $this->rs['email'],
                    $this->rs['id_user'], $this->rs['id_pass'], $this->rs['perfil_acesso'], $this->rs['nivel_acesso'],
                    $this->rs['status'],$this->rs['pass_change'], $this->rs['last_login'], $this->rs['now_login'],
                    $this->rs['vinculo'], $this->rs['escolas_associadas']);
            endif;

            if($obj != null) {
                $this->ctSecurity -> createSession($obj);
                $out = $obj->getStatus();

                if ($out):
                    $this->registerLogin($obj);
                    CTLogSystem::registerLog($obj, 'Realizou Login');
                endif;
            }else{
                CTSecuritySystem::countControlBruteForce();
                CTSecuritySystem::preventBruteForce();
            }

        }catch (PDOException $e){
            throw new DBException($e->getMessage());
        }
        finally{
            parent::closeFactoryDao();
            return $obj;
        }
    }

    public function logoff($url){
        $this->ctSecurity -> closeSession();
        CTSecuritySystem::redirectionPage($url);
        die();
    }

    public function forgotPass($param){
        $out = false;
        $obj = $this->findByCpf($param);
        if($obj != null){
            $newPass = rand(111111, 999999);
            if($this->changePass($obj, md5($newPass), true)) {
                $subject = 'SISAAP: Alteracao de Senha';
                $mensege = '<h1>Sistema SISAAP</h1>'
                    . '<p>Solicitacao de Alteracao de Senha</p>'
                    . '<p>User esse dados para fazer o login e alterar sua senha:</p>'
                    . '<span>Usuario: ' . $obj->getCpf() . '</span><br>'
                    . '<span>Senha: ' . $newPass . '</span><br>'
                    . '<p> Se voce nao tem conciencia dessa solicitacao, entre em contato com seu administrador</p>';

                $ctPostMan = new CTPostManSystem();
                $ctPostMan->sendMail($obj->getEmail(), $subject, $mensege);

                CTLogSystem::registerLog($obj, 'Solicitou Nova Senha por Email');

                $out = true;
            }
        }
        return $out;
    }

    public function changePass(EntiteUsuario $obj, $newpass, $passChange){
        $out = false;
        try {
            if($obj != null):
                $sql = 'UPDATE '.self::$TABLE.' SET id_pass = ?, pass_change = ? WHERE id = ?';

                $this->st =  $this->con -> prepare($sql);
                $this->st -> bindValue(1, $newpass, PDO::PARAM_STR);
                $this->st -> bindValue(2, $passChange, PDO::PARAM_BOOL);
                $this->st -> bindValue(3, $obj->getId(), PDO::PARAM_INT);
                $this->st -> execute();

                $rows = $this->st -> rowCount();
                $out  = $rows > 0 ? true : false;
            endif;
        }catch (PDOException $e){
            throw new DBException($e->getMessage());
        } finally {
            parent::closeFactoryDao();
            return $out;
        }
    }

    private function registerLogin(EntiteUsuario $obj){
        $obj->setLastLogin($obj->getNowLogin());
        $obj->setNowLogin(CTTimeManagerSystem::convertDataDB(CTTimeManagerSystem::getDataNow()));

        try{
            $sql = 'UPDATE '.self::$TABLE.' SET last_login = ?, now_login = ? WHERE id = ?';

            $this->st  = $this->con -> prepare($sql);
            $this->st -> bindValue(1, $obj->getLastLogin());
            $this->st -> bindValue(2, $obj->getNowLogin());
            $this->st -> bindValue(3, $obj->getId(), PDO::PARAM_INT);
            $this->st -> execute();

            $rows = $this->st ->rowCount();
            $out  = $rows > 0 ? true : false;

            return $out;

        }catch (PDOException $e){
            throw new DBException($e->getMessage());
        }
    }

}