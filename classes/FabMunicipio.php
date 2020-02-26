<?php
/**
 * Created by PhpStorm.
 * User: octuspi
 * Date: 16/09/2018
 * Time: 01:47
 */

class FabMunicipio
{
    private $id;
    private $cnpj;
    private $pais;
    private $estado;
    private $cidade;
    private $status;

    private static $statsb = array("BLOQUEADO", "ATIVO");
    private static $paises  = array("Brasil");
    private static $estados = array("BUSCAR TODOS", "AC","AL","AM","AP","BA","CE","DF","ES","GO","MA","MG","MS","MT",
        "PA","PB","PE","PI","PR","RJ","RN","RO","RR","RS","SC","SE","SP","TO",);


    public function __construct($id, $cnpj, $pais, $estado, $cidade, $status)
    {
        $this->setId($id);
        $this->setCnpj($cnpj);
        $this->setPais($pais);
        $this->setEstado($estado);
        $this->setCidade($cidade);
        $this->setStatus($status);
    }

    /**
     * @return array
     */
    public static function getPaises(): array
    {
        return self::$paises;
    }

    /**
     * @return array
     */
    public static function getEstados(): array
    {
        return self::$estados;
    }

    /**
     * @return array
     */
    public static function getStatsb(): array
    {
        return self::$statsb;
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
    public function getCnpj()
    {
        return $this->cnpj;
    }

    /**
     * @param mixed $cnpj
     */
    public function setCnpj($cnpj)
    {
        $this->cnpj = $cnpj;
    }

    /**
     * @return mixed
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * @param mixed $pais
     */
    public function setPais($pais)
    {
        $this->pais = $pais;
    }

    /**
     * @return mixed
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param mixed $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    /**
     * @return mixed
     */
    public function getCidade()
    {
        return $this->cidade;
    }

    /**
     * @param mixed $cidade
     */
    public function setCidade($cidade)
    {
        $this->cidade = $cidade;
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


}