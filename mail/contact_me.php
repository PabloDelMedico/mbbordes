<?php
// Check for empty fields
if (empty($_POST['name']) ||
    empty($_POST['email']) ||
    empty($_POST['phone']) ||
    empty($_POST['message']) ||
    !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
) {
    echo "No arguments Provided!";
    return false;
}


$asunto = 'Consulta desde la web';
$email = $_POST['email'];
$tel = $_POST['phone'];
$name = $_POST['name'];
$cuerpo = $_POST['message'] . "\n\n Consulta Enviada por " . $name . "    " . $email . "   Tel:" . $tel;

require 'phpmailer/PHPMailerAutoload.php';

$mail = new PHPMailer();

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'mail.wiphalasistemas.com.ar';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'a5000515';                 // SMTP username
$mail->Password = '44nozuZEre';                           // SMTP password
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->setFrom('web@wiphalasistemas.com.ar', 'Web Wiphala');
$mail->addAddress('contacto@wiphalasistemas.com.ar', 'Contacto Wiphala');     // Add a recipient
$mail->addAddress('pablodelmedico@gmail.com', 'Pablo');               // Name is optional
$mail->addAddress('luchopeco@gmail.com', 'Lucho');               // Name is optional
$mail->addReplyTo($email, $name);

$mail->Subject = $asunto;
$mail->msgHTML($cuerpo);
$mail->AltBody = $cuerpo;

//Si al enviar el correo devuelve true es que todo ha ido bien.
if ($mail->Send()) {
    //return true;
    echo 'true';
} else {
    //return false;
    echo $mail->ErrorInfo;;
}