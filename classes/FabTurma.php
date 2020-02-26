<?php
/**
 * Created by PhpStorm.
 * User: octus
 * Date: 31/03/18
 * Time: 05:28
 */

class FabTurma
{
    private $id;
    private $escola;
    private $serie;
    private $nome;
    private $turno;
    private $status;

    private static $turnos  = array('MATUTINO', 'VESPERTINO', 'NOTURNO', 'INTEGRAL');
    private static $latters = array('A','B','C','D','E','F','G','H','I','J','L','M','N','O','P','Q','R','S','T','U','X','Z');
    private static $rstats  = array('INATIVO', 'ATIVO');

    /**
     * FabTurma constructor.
     * @param $id
     * @param $escola
     * @param $serie
     * @param $nome
     * @param $turno
     * @param $status
     */
    public function __construct($id, $escola, $serie, $nome, $turno, $status)
    {
        $this->setId($id);
        $this->setEscola($escola);
        $this->setSerie($serie);
        $this->setNome($nome);
        $this->setTurno($turno);
        $this->setStatus($status);
    }

    /**
     * @return array
     */
    public static function getTurnos(): array
    {
        return self::$turnos;
    }

    /**
     * @param $turno
     * @return mixed
     */
    public static function getTurnosExt($turno){
        return self::$turnos[$turno];
    }

    /**
     * @return array
     */
    public static function getLatters(): array
    {
        return self::$latters;
    }

    /**
     * @return array
     */
    public static function getRstats(): array
    {
        return self::$rstats;
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
    public function getEscola()
    {
        return $this->escola;
    }

    /**
     * @param mixed $escola
     */
    public function setEscola($escola)
    {
        $this->escola = $escola;
    }

    /**
     * @return mixed
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * @param mixed $serie
     */
    public function setSerie($serie)
    {
        $this->serie = $serie;
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
    public function getTurno()
    {
        return $this->turno;
    }

    /**
     * @param mixed $turno
     */
    public function setTurno($turno): void
    {
        $this->turno = $turno;
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
    public function setStatus($status): void
    {
        $this->status = $status;
    }
}