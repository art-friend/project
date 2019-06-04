<?php
$mail = new PHPMailer(true);

    //$mail->SMTPDebug = 2;                                       // Enable verbose debug output
    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Host       = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'testdemo256@gmail.com';                     // SMTP username
    $mail->Password   = 'demotest12345';                               // SMTP password
    $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 587;  
    $mail->setFrom('from@example.com', 'Mailer');
    $mail->isHTML(true);