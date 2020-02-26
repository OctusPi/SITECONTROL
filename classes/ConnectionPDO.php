<?php
/**PDO Connection Mysql*/
class ConnectionPDO{

    private $type = "mysql";
    private $host = "localhost";
    private $data = "dataaprovaplus";
    private $user = "root";
    private $pass = "root";
    private $dbn  = null;

    public static $TBUSERS = 'aplus_users';
    public static $TBCIDDS = 'aplus_municipios';
    public static $TBESCOL = 'aplus_escolas';
    public static $TBSERIS = 'aplus_series';
    public static $TBTURMS = 'aplus_turmas';


    /**
     * @return null|PDO
     */
    public function getConnection(){
        // Turn off all error reporting
        //error_reporting(0);

        if($this->dbn == null){
            try{
                $this->dbn = new PDO($this->type.':host='.$this->host.';dbname='.$this->data, $this->user, $this->pass);
            }catch(PDOException $e){
                //print "Error: ".$e->getMessage()."<br>";
                echo('Banco de Dados Nao Localizado. Contate o Administrador do Sistema');
                die;
            }
        }
        return $this->dbn;
    }

    public function finalizeConnection(){
        unset($this->dbn);
        $this->dbn = null;
    }
}