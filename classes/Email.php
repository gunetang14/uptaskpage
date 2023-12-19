<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;
#[\AllowDynamicProperties]
class Email {
    protected $email;
    protected $nombre;
    protected $token;

    public function __construct($email, $nombre, $token) {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
        
    }
    public function enviarConfirmacion(){

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom($_ENV['EMAIL_MAIL']);
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject = 'Confirma tu Cuenta';

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= " <p><strong>Hola " . $this->nombre . "</strong> Has creado tu cuenta en UpTask, solo debes confirmarla en el siguiente enlace</p>";
        $contenido .= "<p>Presiona aquí: <a href='" . $_ENV['HOST'] . "/confirm?token=". $this->token . "'>Confirmar Cuenta</a></p>";
        $contenido .= "<p>Si tu no creaste esta cuenta, puedes ignorar este mensaje</p>";
        $contenido .= '</html>';

        $mail->Body = $contenido;

        //enviar el mail
        $mail->send();

    }
    public function enviarInstrucciones(){

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom($_ENV['EMAIL_MAIL']);
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject = 'Reestablece Tu Contraseña';

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= " <p><strong>Hola " . $this->nombre . "</strong> Parece que has olvidado tu password, sigue el siguiente enlace para recuperarlo</p>";
        $contenido .= "<p>Presiona aquí: <a href='" . $_ENV['HOST'] . "/reset?token=". $this->token . "'>Reestablecer Contraseña</a></p>";
        $contenido .= "<p>Si tu no creaste esta cuenta, puedes ignorar este mensaje</p>";
        $contenido .= '</html>';

        $mail->Body = $contenido;

        //enviar el mail
        $mail->send();

    }
}

?>