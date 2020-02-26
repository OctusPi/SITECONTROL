<?php
/**
 * Created by PhpStorm.
 * User: kuroi
 * Date: 08/09/18
 * Time: 23:57
 */

class FabUsuario
{
    private static $stuser = array('BLOQUEADO', 'ATIVO');

    private static $perfis = array('ADMINISTRADOR GERAL', 'OPERADOR MASTER MUNICIPIO', 'PEDAGOGO MUNICIPAL', 'DIRETOR ESCOLAR');

    private static $niveis = array(0 => 'SEM PERMISSÃO', 1 => 'MUNICIPIOS', 2 => 'GERIR ESCOLAS', 3 => 'GERIR SERIES E ANOS',
        4 => 'GERIR TURMAS', 5 => 'GERIR ALUNOS', 6 => 'GERIR MATRIZES', 7 => 'GERIR DESCRITORES', 8 => 'GERIR AVALIAÇÃO',
        9 => 'RESPONDER AVALIACAO', 10 => 'RESULTADOS', 11 => 'RELATÓRIOS', 12 => 'ADMINISTRAÇÃO');


    private $id;
    private $nome;
    private $email;
    private $cpf;
    private $iduser;
    private $idpass;
    private $status;
    private $perfil;
    private $nivel;
    private $vinculo;
    private $municipio;
    private $oldlogin;
    private $newlogin;
    private $uppass;

    /**
     * FabUsuario constructor.
     * @param $id
     * @param $nome
     * @param $email
     * @param $cpf
     * @param $iduser
     * @param $idpass
     * @param $status
     * @param $perfil
     * @param $nivel
     * @param $vinculo
     * @param $municipio
     * @param $oldlogin
     * @param $newlogin
     * @param $uppass
     */
    public function __construct($id, $nome, $email, $cpf, $iduser, $idpass, $status, $perfil, $nivel,
                                $vinculo, $municipio, $oldlogin, $newlogin, $uppass)
    {
        $this->setId($id);
        $this->setNome($nome);
        $this->setEmail($email);
        $this->setCpf($cpf);
        $this->setIduser($iduser);
        $this->setIdpass($idpass);
        $this->setStatus($status);
        $this->setPerfil($perfil);
        $this->setNivel($nivel);
        $this->setVinculo($vinculo);
        $this->setMunicipio($municipio);
        $this->setOldlogin($oldlogin);
        $this->setNewlogin($newlogin);
        $this->setUppass($uppass);
    }

    /**
     * @return array
     */
    public static function getPerfis(): array
    {
        return self::$perfis;
    }

    /**
     * @return array
     */
    public static function getStuser(): array
    {
        return self::$stuser;
    }

    /**
     * @return int
     */
    public static function getNumberPerfis()
    {
        return count(self::$perfis);
    }

    /**
     * @return array
     */
    public static function getNiveis(): array
    {

        return self::$niveis;

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
    public function getPerfil()
    {
        return $this->perfil;
    }

    /**
     * @param mixed $perfil
     */
    public function setPerfil($perfil)
    {
        $this->perfil = $perfil;
    }

    /**
     * @return mixed
     */
    public function getNivel()
    {
        return explode(',', $this->nivel);
    }

    /**
     * @param mixed $nivel
     */
    public function setNivel($nivel)
    {
        $this->nivel = $nivel;
    }

    public function getNivelStr()
    {
        return $this->nivel;
    }

    /**
     * @return mixed
     */
    public function getUppass()
    {
        return $this->uppass;
    }

    /**
     * @param mixed $uppass
     */
    public function setUppass($uppass)
    {
        $this->uppass = $uppass;
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
    public function getIduser()
    {
        return $this->iduser;
    }

    /**
     * @param mixed $iduser
     */
    public function setIduser($iduser)
    {
        $this->iduser = $iduser;
    }

    /**
     * @return mixed
     */
    public function getIdpass()
    {
        return $this->idpass;
    }

    /**
     * @param mixed $idpass
     */
    public function setIdpass($idpass)
    {
        $this->idpass = $idpass;
    }

    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * @param $cpf
     */
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }

    /**
     * @return mixed
     */
    public function getVinculo()
    {
        return explode(',', $this->vinculo);
    }

    /**
     * @param mixed $vinculo
     */
    public function setVinculo($vinculo)
    {
        $this->vinculo = $vinculo;
    }

    public function getVinculoStr()
    {
        return $this->vinculo;
    }

    public function getMunicipioStr()
    {
        return $this->municipio;
    }

    public function getMunicipio()
    {
        return explode(',', $this->municipio);
    }

    public function setMunicipio($municipio)
    {
        $this->municipio = $municipio;
    }

    /**
     * @return mixed
     */
    public function getNewlogin()
    {
        return $this->newlogin;
    }

    /**
     * @param mixed $newlogin
     */
    public function setNewlogin($newlogin)
    {
        $this->newlogin = $newlogin;
    }

    /**
     * @return mixed
     */
    public function getOldlogin()
    {
        return $this->oldlogin;
    }

    /**
     * @param mixed $oldlogin
     */
    public function setOldlogin($oldlogin)
    {
        $this->oldlogin = $oldlogin;
    }
}