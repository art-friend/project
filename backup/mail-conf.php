<?php
$mail = new PHPMailer(true);

    //$mail->SMTPDebug = 2;                                       // Enable verbose debug output
    //$mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Host       = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'art.friend.art@gmail.com';                     // SMTP username
    $mail->Password   = 'Katlanim';                               // SMTP password
    $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 587;  
    $mail->setFrom('art.friend.art@gmail.com', 'Mailer');
    $mail->isHTML(true);