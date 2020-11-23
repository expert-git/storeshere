<?php
$mail = new PHPMailer;
$mail->SMTPDebug = 3;                               // Enable verbose debug output
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.office365.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = false;                               // Enable SMTP authentication
/*$mail->Username = 'alfifa@saudiatour.com';                 // SMTP username
$mail->Password = 'real12site';                          // SMTP password
$mail->SMTPSecure = 'TLS';    */                         // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;
$mail->isHTML(true);
?>
