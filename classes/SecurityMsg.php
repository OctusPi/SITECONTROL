<?php
/**
 * Created by PhpStorm.
 * User: kuroi
 * Date: 13/02/18
 * Time: 20:02
 */

class SecurityMsg
{
    private $msg;
    private $tpm;

    /**
     * SecurityMsg constructor.
     */
    public function __construct()
    {
        //msg error
        $this->msg['error0001'] = 'Usuário ou Senha inválidos!';
        $this->msg['error0002'] = 'Você não tem permissão!';
        $this->msg['error0003'] = 'Usuário não localizado!';
        $this->msg['error0004'] = 'Ocorreu um erro na sua solicitação, tente novamente!';
        $this->msg['error0005'] = 'Senha não confere!';
        $this->msg['error0006'] = 'Confirmação de senha não confere!';
        $this->msg['error0007'] = 'Operação não realizada. Tentativa de duplicação de dados!';
        $this->msg['error0008'] = 'Erro Fatal na Operaçao! Fuja para as colinas ou contate o ADM...';
        $this->msg['error0009'] = 'Nenhum Dado foi alterado!';
        $this->msg['error0010'] = 'Não existem registros a serem retornados!';
        $this->msg['error0011'] = 'Sua sessão expirou!';

        //type error
        $this->tpm['error0001'] = 'alert-warning';
        $this->tpm['error0002'] = 'alert-danger';
        $this->tpm['error0003'] = 'alert-warning';
        $this->tpm['error0004'] = 'alert-warning';
        $this->tpm['error0005'] = 'alert-warning';
        $this->tpm['error0006'] = 'alert-warning';
        $this->tpm['error0007'] = 'alert-warning';
        $this->tpm['error0008'] = 'alert-danger';
        $this->tpm['error0009'] = 'alert-warning';
        $this->tpm['error0010'] = 'alert-warning';
        $this->tpm['error0011'] = 'alert-danger';

        //msg success
        $this->msg['sucs0001'] = 'Saída Realizada!';
        $this->msg['sucs0002'] = 'Nova senha enviada para o seu E-mail!';
        $this->msg['sucs0003'] = 'Operação realizada com sucesso!';

        //type success
        $this->tpm['sucs0001'] = 'alert-success';
        $this->tpm['sucs0002'] = 'alert-success';
        $this->tpm['sucs0003'] = 'alert-success';
    }

    /**
     * @param $code
     * @return mixed
     */
    public function getMsgInt($code){
        return $this->msg[$code];
    }

    /**
     * @param $code
     * @return mixed
     */
    public function getTpmInt($code){
        return $this->tpm[$code];
    }

    /**
     * @param $code
     */
    public function createMsg($code){
        setcookie('msgretorno', $code, time()+1800, '/');
    }

    public function deleteMsg(){
        setcookie('msgretorno', '', time()-3600, '/');
    }

    /**
     * @param null $addview
     * @return null|string
     */
    public function viewMsg($addview = null){

        if(isset($_COOKIE["msgretorno"])){
            $vmsg = '<div style="margin-top: 10px;" class="alert '.$this->getTpmInt($_COOKIE["msgretorno"]).' alert-dismissible fade show" role="alert">
                    <strong>Alerta!</strong> '.$this->getMsgInt($_COOKIE["msgretorno"]).$addview.'
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
        }else{
            $vmsg = null;
        }

        return $vmsg;
    }

    /**
     * function void
     * @param $cod
     */
    public function viewMsgDisplay($cod){
        /** @var SplString $vmsg */
        $vmsg = '<div style="margin-top: 10px;" class="alert '.$this->getTpmInt($cod).' alert-dismissible fade show" role="alert">
                    <strong>Alerta!</strong> '.$this->getMsgInt($cod).'
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
        echo $vmsg;
    }
}