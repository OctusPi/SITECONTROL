<?php
/**
 * Created by PhpStorm.
 * User: kuroi
 * Date: 16/02/18
 * Time: 22:01
 */

class ManagerPostMail
{
    private $headers;

    public function __construct() {
        $this->headers  =  'MIME-Version: 1.0' . "\r\n";
        $this->headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $this->headers .= 'From: OctusPI Notificação <octuspi@mail.com>' . "\r\n";
        $this->headers .= 'Cc: octuspi@gmail.com' . "\r\n";
        $this->headers .= 'Bcc: octuspi@gmail.com' . "\r\n";
    }

    private function setMessage($subject, $content, $adtional, $final){
        $message = '
        <html>
            <head>
                <title>OctusPi: '.$subject.'</title>
            </head>
            <body style="font-family:Arial, tahoma, calibri; padding:10px; background:#fcfcfc; border:1px #CCC solid;">
                <h1 style="font-size:18px; border-bottom:1px #CCC solid; margin-bottom:10px;">'.$subject.'</h1>
                <p>'.$content.'</p>
                <p>'.$adtional.'</p>
                <p>'.$final.'</p>
            </body>
        </html>
        ';
        return $message;
    }

    public function sendMail($to, $subject, $content, $adtional, $final){
        try{
            mail($to, $subject, $this->setMessage($subject, $content, $adtional, $final), $this->headers);
            return true;
        } catch (Exception $ex) {
            print $ex->getMessage();
            return false;
        }
    }
}