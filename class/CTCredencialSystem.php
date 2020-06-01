<?php


class CTCredencialSystem
{
    private $nome;
    private $url;
    private $perfil;
    private $nivel;

    /**
     * CTCredencialSystem constructor.
     * @param $nome
     * @param $url
     * @param $perfil
     * @param $nivel
     */
    public function __construct($nome, $perfil, $nivel)
    {
        $this->nome = $nome;
        $this->setUrl(md5($this->nome));
        $this->perfil = $perfil;
        $this->nivel = $nivel;
    }

    public static function identifyPage($pageUrl, $pageView){
        return $pageUrl == $pageView ? true : false;
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
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
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
        return $this->nivel;
    }

    /**
     * @param mixed $nivel
     */
    public function setNivel($nivel)
    {
        $this->nivel = $nivel;
    }


}