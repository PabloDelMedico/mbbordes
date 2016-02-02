<?php
//Return data
$return = new stdClass();
$return->success = false;
$return->message = '';

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

// Check for empty fields
if (empty($request->name) ||
    empty($request->email) ||
    empty($request->message) ||
    !filter_var($request->email, FILTER_VALIDATE_EMAIL)
) {
    $return->success = false;
    $return->message = 'No arguments Provided!';
    echo json_encode($return);
}


$asunto = 'Consulta desde la web';
$email = $request->email;
$tel = $request->tel;
$name = $request->name;
$cuerpo = $request->message . "\n\n Consulta Enviada por " . $name . "    " . $email . "   Tel:" . $tel;

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
    $return->success = true;
} else {
    //return false;
    $return->success = false;
    $return->message = $mail->ErrorInfo;
}

echo json_encode($return);
return;
