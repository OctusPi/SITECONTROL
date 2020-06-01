<?php
/**
 * Class CTAlertsSystem
 */
class CTAlertsSystem
{

    //  LEMBRETE TRATAR FORA DO INDEX OF ARRAY NO SENDALERT

    private $alert = null;

    private static $ALERT_TYPES    = ['ERROR'=>'alert-danger', 'WARNING'=>'alert-warning', 'SUCCESS'=>'alert-success'];
    private static $ALERT_HEADERS  = ['ERROR'=>'ERRO: ', 'WARNING'=>'ALERTA: ', 'SUCCESS'=>'SUCESSO: '];
    private static $ALERT_CONTENTS = [
                                     '001'=>'Solicitacão realizada!',
                                     '002'=>'Falha! Requisicao não acatada!',
                                     '003'=>'Falha no Sistema, contate o desenvolverdor!',
                                     '004'=>'Dados de acesso incorretos!',
                                     '005'=>'Tetativas de acesso restantes: ',
                                     '006'=>'Usuário não Localizado: ',
                                     '007'=>'Campos obrigatórios não preenchidos ',
                                     '008'=>'Senha Atual Inválida ',
                                     '009'=>'Nova senha não coincide! ',
                                     '010'=>'Nova senha não pode ser igual a senha atual! ',
                                     '011'=>'Senha de validacao incorreta! ',
                                     ];


    /**
     * CTAlertsSystem constructor.
     */
    public function __construct()
    {
        if(isset($_COOKIE[md5('SYSTEM_ALERT_RELOADPAGE')])){
            $cookie_value = explode(',', $_COOKIE[md5('SYSTEM_ALERT_RELOADPAGE')]);
            $this->sendAlert($cookie_value[0], $cookie_value[1]);
        }
    }

    /**
     * @param $type
     * @param $content
     */
    public function sendAlert($type, $content){
        //add alert fail login times
        $add = '';
        $cookie_login  = md5('EMPRESA_SYSTEMNAME_BRUTEFORCECONTROL');
        if(isset($_COOKIE[$cookie_login]) && $_COOKIE[$cookie_login] != null && $content == '004'):
            $add = ' Tetantivas de Acesso: '.$_COOKIE[$cookie_login].'/5';
        endif;

        //add value alert
        $this->alert = '<div class="alert text-center small '.self::$ALERT_TYPES[$type].' alert-dismissible fade show" role="alert">
                    <strong>'.self::$ALERT_HEADERS[$type].'</strong> '.self::$ALERT_CONTENTS[$content].$add.'
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
    }

    /**
     * @param $type
     * @param $content
     */
    public function sendAlertReload($type, $content){
        $cookie_name = md5('SYSTEM_ALERT_RELOADPAGE');
        $cookie_val  = $type.','.$content;
        setcookie($cookie_name, $cookie_val, time()+60, '/');
    }

    /**
     *
     */
    public  function viewAlert(){
        $out = null;
        if($this->alert != null):
            $out = $this->alert;
            unset($this->alert);
            if(isset($_COOKIE[md5('SYSTEM_ALERT_RELOADPAGE')]) && $_COOKIE[md5('SYSTEM_ALERT_RELOADPAGE')] != null){
                $cookie_name = md5('SYSTEM_ALERT_RELOADPAGE');
                setcookie($cookie_name, null, 1, '/');
            }
        endif;

        if($out != null):
            echo $out;
        endif;
    }
}