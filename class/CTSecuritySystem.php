<?php

/**
 * Class CTSecuritySystem
 */
class CTSecuritySystem
{
    private $session_name;
    private $session_iduser;
    private $session_idpass;
    private $session_idunique;
    private $session_idtime;
    private $session_time_expire;

    /**
     * CTSecuritySystem constructor.
     */
    public function __construct()
    {
        $this->session_name        = md5('OCP-SITECONTROL_'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
        $this->session_iduser      = md5('OCP-SITECONTROL_IDUSER');
        $this->session_idpass      = md5('OCP-SITECONTROL_IDPASS');
        $this->session_idunique    = md5('OCP-SITECONTROL_IDUNIQ');
        $this->session_idtime      = md5('OCP-SITECONTROL_IDTIME');
        $this->session_time_expire = 30; //TIME IM MINUTES

        if(session_status() != PHP_SESSION_ACTIVE){
            session_name($this->session_name);
            session_cache_expire($this->session_time_expire);
            session_start();
        }else{
            if(session_cache_expire() == 0){
                session_start();
                session_destroy();
            }else{
                session_name($this->session_name);
                session_cache_expire($this->session_time_expire);
                session_start();
            }
        }
    }


    //***CONTROLES DE SESSAO
    public function accessVerificationSecurity($entiteUsuario, CTCredencialSystem $crd){
        $this->verifyActivatedSession();
        $this->verifyIdentitySession($entiteUsuario);
        $this->verifyTimeSession();

        if(self::verifyNivelCrendicial($entiteUsuario, $crd) == false or session_status() !== PHP_SESSION_ACTIVE):
            $this->closeSession();
            self::forceOutInvalidaSecurity();
        endif;
    }
    //->verify time session limit to expire
    private function verifyTimeSession(){
        if($_SESSION[$this->session_idtime] >= time()){
            $_SESSION[$this->session_idtime] = time()+($this->session_time_expire*1000*60);
        }else{
            $this->closeSession();
        }
    }
    //->verify variable of session started
    private function verifyActivatedSession(){
        if(session_status() === PHP_SESSION_ACTIVE){
            if(!isset($_SESSION[$this->session_iduser]) or ! isset($_SESSION[$this->session_idpass])):
                $this->closeSession();
            endif;
        }
    }
    //verify identity user session
    private function verifyIdentitySession($entiteUsuario){
        if(session_status() === PHP_SESSION_ACTIVE && $entiteUsuario != null){
            if($_SESSION[$this->session_idunique] !== $this->session_name or $_SESSION[$this->session_iduser] != $entiteUsuario->getIdUser() or $_SESSION[$this->session_idpass] != $entiteUsuario->getIdPass()):
                $this->closeSession();
            endif;
        }else{
            $this->closeSession();
        }
    }
    //->create variables of session
    public function createSession($entiteUsuario){
        if($entiteUsuario != null):
            $_SESSION[$this->session_iduser]   = $entiteUsuario->getIdUser();
            $_SESSION[$this->session_idpass]   = $entiteUsuario->getIdPass();
            $_SESSION[$this->session_idunique] = $this->session_name;
            $_SESSION[$this->session_idtime]   = time()+($this->session_time_expire*1000*60);
        endif;
    }
    //->end all sessions
    public function closeSession(){
        try{
            unset($_SESSION[$this->session_iduser]);
            unset($_SESSION[$this->session_idpass]);
            unset($_SESSION[$this->session_idunique]);
            unset($_SESSION[$this->session_idtime]);
        }catch (Exception $exception){
            throw new DBException($exception->getMessage());
        }finally{
            session_start();
            session_destroy();
        }
    }
    /**
     * @return string
     */
    public function getSessionIduser()
    {
        return $this->session_iduser;
    }
    /**
     * @return string
     */
    public function getSessionIdpass()
    {
        return $this->session_idpass;
    }
    /**
     * @return mixed|null
     */
    public function getSessionIduserValue(){
        if(session_status() === PHP_SESSION_ACTIVE && isset($_SESSION[$this->session_iduser])){
            return $_SESSION[$this->session_iduser];
        }else{
            return null;
        }
    }
    /**
     * @return mixed|null
     */
    public function getSessionIdpassValue(){
        if(session_status() === PHP_SESSION_ACTIVE && isset($_SESSION[$this->session_idpass])){
            return $_SESSION[$this->session_idpass];
        }else{
            return null;
        }
    }



    //***VALIDACAO DOS FOMULARIOS
    //->filter users inputs
    public static function validateFormInput($input){
        $str = preg_replace("/(from|script|select|insert|delete|truncate|where|drop table|show tables|#|\*|--|\\\\)/","",$input);
        return htmlentities(strip_tags($str));
    }
    //->generate key exclusive of form
    public static function keyFormSubmit($chave_radon){
        $cookie_form   = md5('EMPRESA_SYSTEMNAME_VALIDATEFORM');
        setcookie($cookie_form, $chave_radon, time()+31*60, '/');
    }
    //verify exclusive key form
    public static function validateFormSubmit($chave_form){
        $cookie_form   = md5('EMPRESA_SYSTEMNAME_VALIDATEFORM');
        if(!isset($_COOKIE[$cookie_form]) or $_COOKIE[$cookie_form] != $chave_form):
            self::forceOutInvalidaSecurity();
        endif;
    }
    //->simple location replace
    public static function forceOutInvalidaSecurity($url = null){
        $rpl = $url == null ? 'main.php' : $url;
        echo '<script type="text/javascript"> window.location.replace("'.$rpl.'"); </script>';
        die();
    }



    //***CONTROLE DE TENTATIVAS BRUTEFORCE LOGIN
    //->counter number times requisition
    public static function countControlBruteForce(){
        $cookie_name  = md5('EMPRESA_SYSTEMNAME_BRUTEFORCECONTROL');
        $cookie_value = 1;
        if(isset($_COOKIE[$cookie_name])){
            $cookie_value = $_COOKIE[$cookie_name]+1;
            setcookie($cookie_name, $cookie_value, time()+31*60, '/');
        }else{
            setcookie($cookie_name, $cookie_value, time()+31*60, '/');
        }
    }
    //->verify limiter requisitions
    public static function preventBruteForce(){
        $cookie_name  = md5('EMPRESA_SYSTEMNAME_BRUTEFORCECONTROL');
        if(isset($_COOKIE[$cookie_name]) && $_COOKIE[$cookie_name] > 5):
            self::forceOutInvalidaSecurity('prison.html');
        endif;
    }


    //***VERIFICACAO E CONTROLE DE NIVEL DE CREDENCIAL
    public static function verifyNivelCrendicial($obj, $crd){
        $out = true;
        //quanto menor o perfil mais poder de acesso
        if($obj == null or $obj->getPerfilAcesso() > $crd->getPerfil()){
            $out = false;
        }elseif (!in_array($crd->getNivel(), $obj->convetArray($obj->getNivelAcesso()))){
            $out = false;
        }
        return $out;
    }
    public static function redirectionPage($url){
        echo '<script type="text/javascript"> window.location.replace("'.$url.'"); </script>';
    }

}