<?php
/**
 * Created by PhpStorm.
 * User: octuspi
 * Date: 16/03/18
 * Time: 13:07
 */

class FabEscola
{
    private $id;
    private $cidade;
    private $inep;
    private $nome;
    private $endereco;
    private $encarregado;
    private $telefone;
    private $email;

    public function __construct($id, $cidade, $inep, $nome, $endereco, $encarregado, $telefone, $email)
    {
        $this->setId($id);
        $this->setCidade($cidade);
        $this->setInep($inep);
        $this->setNome($nome);
        $this->setEndereco($endereco);
        $this->setEncarregado($encarregado);
        $this->setTelefone($telefone);
        $this->setEmail($email);
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
    public function getInep()
    {
        return $this->inep;
    }

    /**
     * @param mixed $inep
     */
    public function setInep($inep)
    {
        $this->inep = $inep;
    }

    /**
     * @return mixed
     */
    public function getEndereco()
    {
        return $this->endereco;
    }

    /**
     * @param mixed $endereco
     */
    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;
    }

    /**
     * @return mixed
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * @param mixed $telefone
     */
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
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
    public function getEncarregado()
    {
        return $this->encarregado;
    }

    /**
     * @param mixed $encarregado
     */
    public function setEncarregado($encarregado)
    {
        $this->encarregado = $encarregado;
    }
}