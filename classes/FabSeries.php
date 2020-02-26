<?php
/**
 * Created by PhpStorm.
 * User: octus
 * Date: 29/03/18
 * Time: 17:04
 */

class FabSeries
{
    private $id;
    private $nome;
    private $nivel;
    private $status;

    private static $niveis = array('INFANTIL', 'FUNDAMENTAL I', 'FUNDAMENTAL II', 'MÉDIO', 'SUPERIOR');
    private static $rstats = array('INATIVO', 'ATIVO');

    /**
     * Series constructor.
     * @param $id
     * @param $nome
     * @param $nivel
     * @param $status
     */
    public function __construct($id, $nome, $nivel, $status)
    {
        $this->setId($id);
        $this->setNome($nome);
        $this->setNivel($nivel);
        $this->setStatus($status);
    }

    /**
     * @return array
     */
    public static function getNiveis(): array
    {
        return self::$niveis;
    }

    /**
     * @param $nivel
     * @return array
     */
    public static function getNiveisExt($nivel)
    {
        return self::$niveis[$nivel];
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
    public function getNivel()
    {
        return $this->nivel;
    }

    /**
     * @param mixed $nivel
     */
    public function setNivel($nivel)
    {
        $this->nivel = $nivel;
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