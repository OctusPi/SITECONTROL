<?php
/**
 * Created by PhpStorm.
 * User: kuroi
 * Date: 12/02/18
 * Time: 23:51
 */
include_once('FabUsuario.php');
class SecurityPolicy
{
    private $sname;
    private $sidus;
    private $sidps;
    private $sidun;
    private $stime;
    private $sexpire;

    public function __construct(){
        $this->sname   = md5('octuspiapplus'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
        $this->sidus   = md5("octpaprovaplusiduser");
        $this->sidps   = md5("octpaprovaplusidpass");
        $this->sidun   = md5("octpaprovaplusunique");
        $this->stime   = md5("octpaprovaplustime");
        $this->sexpire = 20000;

        if(session_status() != 2){
            session_name($this->sname);
            session_cache_expire(15);
        }

        if(session_cache_expire() == 0){
            session_destroy();
        }

        session_start();
    }

    /**
     *  return index session user
     */
    public function getIndexSuser(){
        return $this->sidus;
    }

    /**
     * return index session pass
     */
    public function getIndexSpass(){
        return $this->sidps;
    }

    /**
     * create session for unique id, user and pass
     * @param $iduser
     * @param $idpass
     */
    public function createSession($iduser, $idpass){
        $_SESSION[$this->sidun] = $this->sname;
        $_SESSION[$this->sidus] = $iduser;
        $_SESSION[$this->sidps] = $idpass;
        $_SESSION[$this->stime] = time()+$this->sexpire;
        session_regenerate_id();
    }

    /**
     * destroy session after logoff
     */
    public function destroySession(){
        try{
            unset($_SESSION[$this->sidun]);
            unset($_SESSION[$this->sidus]);
            unset($_SESSION[$this->sidps]);
            unset($_SESSION[$this->stime]);
        }catch (Exception $e){
           // print_r($e->getMessage());
        }

        session_destroy();
    }

    /**
     * Gate Guardian Session
     * @param FabUsuario $usuario
     * @param $perfil
     * @param $nivel
     * @param $redir
     */
    public function gateGuardian($usuario, $perfil, $nivel, $redir){
        if($usuario == null){
            echo '<script> location.replace("'.$redir.'"); </script>';
            die;
        }else{
            if($this->verifyTimeSession() == false){
                $this->destroySession();
                echo '<script> location.replace("'.$redir.'&code=error0011"); </script>';
            }elseif($this->verifySession() == false){
                $this->destroySession();
                echo '<script> location.replace("'.$redir.'"); </script>';
            }elseif ($this->verifyIdentity($usuario) == false){
                $this->destroySession();
                echo '<script> location.replace("'.$redir.'"); </script>';
            }elseif ($this->verifyPerfilAndStatus($usuario, $perfil) == false){
                $this->destroySession();
                echo '<script> location.replace("'.$redir.'"); </script>';
            }elseif ($this->verifyNivel($usuario, $nivel) == false){
                $this->destroySession();
                echo '<script> location.replace("'.$redir.'"); </script>';
            }
        }
    }

    /**
     * verify password is changed
     * @param FabUsuario $usuario
     * @param $redir
     */
    public function isChangePass($usuario, $redir){
        if($usuario->getUppass()){
            echo '<script> location.replace("'.$redir.'"); </script>';
        }
    }

    public function verifyTimeSession(){
        if(isset($_SESSION[$this->stime])){
            if($_SESSION[$this->stime] >= time()){
                $_SESSION[$this->stime] = time()+$this->sexpire;
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    /**
     *  verify session start
     */
    public function verifySession(){
        try{
            if(!isset($_SESSION[$this->sidun]) or !isset($_SESSION[$this->sidus]) or !isset($_SESSION[$this->sidps])){
                return false;
            }else{
                return true;
            }
        } catch (Exception $ex) {
            print $ex->getMessage();
            return false;
        }

    }

    /**
     *  verify id session
     * @param FabUsuario $usuario
     * @return bool
     */
    private function verifyIdentity($usuario){
        if($_SESSION[$this->sidun] != $this->sname or $_SESSION[$this->sidus] != $usuario->getIduser() or $_SESSION[$this->sidps] != $usuario->getIdpass()){
            return false;
        }else{
            return true;
        }
    }

    /**
     * verify perfil access and status
     * @param FabUsuario $usuario
     * @param $perfil
     */
    private function verifyPerfilAndStatus($usuario, $perfil){
        if($usuario->getStatus() == false){
            return false;
        }else{
            return $usuario->getPerfil() > $perfil ? false : true;
        }
    }

    /**
     * verify session nivel
     */
    public function verifyNivel($usuario, $nivel){
        if(!in_array($nivel, $usuario->getNivel())){
            return false;
        }else{
            return true;
        }
    }

    /**
     * verify input email
     * @param $email
     * @return null
     */
    public static function validateEmail($email){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            return $email;
        }else{
            return null;
        }
    }

    /**
     * verify input generic
     * @param $input
     * @return string
     */
    public static function validateInput($input){
        $str = preg_replace("/(from|select|insert|delete|truncate|where|drop table|show tables|#|\*|--|\\\\)/","",$input);
        return htmlentities(strip_tags($str));
    }

    /**
     * key not phantom post
     * @param $cvalue
     */
    public static function validateStartForm($cvalue){
        setcookie(md5('validaform1154684854ee'), $cvalue, time()+1200, '/');
    }

    /**
     * phantom post control
     * @param $cvalue
     */
    public static function controlHackerForm($cvalue, $redir){
        if(!isset($_COOKIE[md5('validaform1154684854ee')]) or $_COOKIE[md5('validaform1154684854ee')] != $cvalue){
            echo '<script> location.replace("'.$redir.'"); </script>';
            die();
        }
    }

    /**
     * number access times
     * @roboControl
     * @param $cname
     */
    public static function roboControl($cname){
        $cname = md5($cname);
        if(isset($_COOKIE[$cname])){
            setcookie($cname, $_COOKIE[$cname]+1, time()+1200, '/');
        }else{
            setcookie($cname, 1, time()+1200, '/');
        }

    }

    /**
     * reset access times
     * @roboControl
     * @param $cname
     */
    public static function resetRoboControl($cname){
        $cname = md5($cname);
        if(isset($_COOKIE[$cname])){
            setcookie($cname, '', time()-36000, '/');
        }

    }

    /**
     * control times access login
     * @expulsaRobo
     * @param $cname
     * @param $redir
     */
    public static function expulsaRobo($cname, $redir){
        if(isset($_COOKIE[md5($cname)]) && $_COOKIE[md5($cname)] >= 6){
            echo '<script type="text/javascript"> location.replace("'.$redir.'"); </script>';
            die();
        }
    }
}