<?php

namespace Classes;
use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public $nombre;
    public $email;
    public $token;

    public function __construct($nombre, $email, $token) {
        $this->nombre = $nombre;
        $this->email = $email;
        $this->token = $token;

    }

    public function enviarConfirmacion() {

        // crear el objeto de email

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'Appsalon.com');
        $mail->Subject = 'Confirm your account';

        //set HTML
        $mail->isHTML(TRUE);
        

        $contenido = "<html>";
        $contenido .= "<p><strong>Hello " . $this->nombre . "</strong> You have created your account in Appsalon, please click on the link to confirm </p>";
        $contenido .= "<p> Click here: <a href='" .  $_ENV['APP_URL']  . "/confirmar-cuenta?token="
         . $this->token . "'>Confirm Account</a> </p>";
        $contenido .= "<p> you haven't created this account? please ignore this message </p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;  
        
        //enviar el email
        $mail->send();
    }

    public function enviarInstrucciones() { 

        // crear el objeto de email

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'Appsalon.com');
        $mail->Subject = 'Reset your password';

        //set HTML
        $mail->isHTML(TRUE);
        

        $contenido = "<html>";
        $contenido .= "<p><strong>Hello " . $this->nombre . "</strong> You have required reset your password, please click on the link to reset.</p>";
        $contenido .= "<p> Click here: <a href='" .  $_ENV['APP_URL']  . "/recuperar?token="
        . $this->token . "'>Reset your password</a> </p>";
        $contenido .= "<p> you haven't require this? please ignore this message </p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;  
        
        //enviar el email
        $mail->send();


    }
    
}