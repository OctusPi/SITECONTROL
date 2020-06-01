<?php
class EntiteUsuario extends Entite
{
      private $id;
      private $nome;
      private $cpf;
      private $email;
      private $idUser;
      private $idPass;
      private $perfilAcesso;
      private $nivelAcesso;
      private $status;
      private $passChange;
      private $lastLogin;
      private $nowLogin;

      private static $arSystemPerfis = array(0=>'ADMINISTRADOR GERAL', 1=>'GERENTE', 2=>'COORDENADOR', 3=>'EDITOR');
      private static $arSystemNiveis = array(1=>'REGIÕES', 2=>'ESCOLAS', 3=>'SERIES', 4=>'TURMAS', 5=>'ALUNOS', 6=>'DISCIPLINAS', 7=>'MATRIZES',
      8=>'DESCRITORES', 9=>'AVALIACÕES', 10=>'RESULTADOS', 11=>'RELATÓRIOS', 12=>'CONFIGURACÕES');
      private static $arStatusBox = array('INATIVO', 'ATIVO');

    public function __construct($id, $nome, $cpf, $email, $idUser, $idPass, $perfilAcesso, $nivelAcesso, $status,
                                $passChange, $lastLogin, $nowLogin)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->cpf = $cpf;
        $this->email = $email;
        $this->idUser = $idUser;
        $this->idPass = $idPass;
        $this->perfilAcesso = $perfilAcesso;
        $this->nivelAcesso = $nivelAcesso;
        $this->status = $status;
        $this->passChange = $passChange;
        $this->lastLogin = $lastLogin;
        $this->nowLogin = $nowLogin;
    }

    /**
     * @return array
     */
    public static function getArSystemPerfis()
    {
        return self::$arSystemPerfis;
    }

    /**
     * @return array
     */
    public static function getArSystemNiveis()
    {
        return self::$arSystemNiveis;
    }

    /**
     * @return array
     */
    public static function getArStatusBox()
    {
        return self::$arStatusBox;
    }



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * @param mixed $cpf
     */
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param mixed $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * @return mixed
     */
    public function getIdPass()
    {
        return $this->idPass;
    }

    /**
     * @param mixed $idPass
     */
    public function setIdPass($idPass)
    {
        $this->idPass = $idPass;
    }

    /**
     * @return mixed
     */
    public function getPerfilAcesso()
    {
        return $this->perfilAcesso;
    }

    /**
     * @param mixed $perfilAcesso
     */
    public function setPerfilAcesso($perfilAcesso)
    {
        $this->perfilAcesso = $perfilAcesso;
    }



    /**
     * @return mixed
     */
    public function getNivelAcesso()
    {
        return $this->nivelAcesso;
    }

    /**
     * @param mixed $nivelAcesso
     */
    public function setNivelAcesso($nivelAcesso)
    {
        $this->nivelAcesso = $nivelAcesso;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * @param mixed $lastLogin
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;
    }

    /**
     * @return mixed
     */
    public function getNowLogin()
    {
        return $this->nowLogin;
    }

    /**
     * @param mixed $nowLogin
     */
    public function setNowLogin($nowLogin)
    {
        $this->nowLogin = $nowLogin;
    }

    /**
     * @return mixed
     */
    public function getPassChange()
    {
        return $this->passChange;
    }

    /**
     * @param mixed $passChange
     */
    public function setPassChange($passChange)
    {
        $this->passChange = $passChange;
    }

}