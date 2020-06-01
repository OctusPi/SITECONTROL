<?php
class DBConnection{

    private static $type = "mysql";
    private static $host = "127.0.0.1";
    private static $data = "datasitecontrol";
    private static $user = "root";
    private static $pass = "devoctuspi";

    private static $conn = null;

    public static $TBPOSTS   = 'tab_posts';
    public static $TBCATPTS  = 'tab_catposts';
    public static $TBMIDIAS  = 'tab_midias';
    public static $TBMENUS   = 'tab_menus';
    public static $TBPAGINAS = 'tab_paginas';
    public static $TBCOMENTS = 'tab_coments';
    public static $TBAPERENC = 'tab_aparencia';
    public static $TBPLUGINS = 'tab_plugins';
    public static $TBWIDGETS = 'tab_widgets';
    public static $TBDOCS    = 'tab_docs';
    public static $TBCONFS   = 'tab_confs';
    public static $TBUSUARIO = 'tab_usuarios';


    /**
     * @return PDO|null
     */
    public static function getConnection(){
          if(self::$conn == null){
                try{
                  self::$conn = new PDO(self::$type.':host='.self::$host.';dbname='.self::$data, self::$user, self::$pass);
                }
                catch(PDOException $e){
                      echo '<p>Falha ao se conectar com o Bando de Dados</p>';
                      throw new DBException($e->getMessage());
                }
          }
          return self::$conn;
    }

    public static function closeConnection(){
          if(self::$conn != null){
                self::$conn = null;
          }
    }
}