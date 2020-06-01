<?php


class CTPostManSystem
{
    private $headers;
    private $maildisp;

    public function __construct()
    {
        $this->maildisp = 'octdevautomatico@gmail.com';
        $this->headers  = 'MIME-Version: 1.0' . "\r\n";
        $this->headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $this->headers .= 'From: E-mail Automático <'.$this->maildisp.'>' . "\r\n";
    }

    private function prepareMensage($mensage)
    {
        $msg = '<!DOCTYPE html> '
             . '<html lang="pt-br"> '
             . '<head>'
             . '<meta charset="UTF-8"> '
             . '<title>E-mail Automatico</title> '
             . '</head> '
             . '<body> '
             .  wordwrap($mensage, 80)
             . '</body> '
             . '</html>';

        return $msg;
    }

    public function sendMail($to, $subject, $mensage){
        $out = false;
        try {
            $out = mail($to, $subject, $this->prepareMensage($mensage), $this->headers);
        }catch (ErrorException $e){
            printf($e->getMessage());
        } finally {
            return $out;
        }
    }
}