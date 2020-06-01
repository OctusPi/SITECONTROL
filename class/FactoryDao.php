<?php

/**
 * Class FactoryDao
 */
abstract class FactoryDao{
      protected $con = null;
      protected $st  = null;
      protected $rs  = null;

      public function __construct()
      {
            $this->con = DBConnection::getConnection();
      }

      public function closeFactoryDao(){
            try{
                  if($this->st != null){
                        unset($this->st);
                        $this->st = null;
                  }

                  if($this->rs != null){
                        unset($this->rs);
                        $this->rs = null;
                  }
            }
            catch(PDOException $e){
                  print 'Error: '.$e->getMessage();
            }
      }
}