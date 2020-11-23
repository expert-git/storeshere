<?php
require 'PHPMailerAutoload.php';
	//require 'mail_config.php';
	$mail   = new PHPMailer; // call the class 
	$mail->IsSMTP(); 
	$mail->Host = "mail.storeshere.com"; //Hostname of the mail server
	$mail->Port = 25; //Port of the SMTP like to be 25, 80, 465 or 587
	$mail->SMTPAuth = false; //Whether to use SMTP authentication
	/*$mail->SMTPSecure = "TLS";*/
	$mail->Username = "noreply@storeshere.com"; //Username for SMTP authentication any valid email created in your domain
	$mail->Password = "st0r3sh3r3.c0m"; //Password for SMTP authentication
	$mail->SetFrom("noreply@storeshere.com","noreply@storeshere.com"); //From address of the mail
	$mail->Subject = 'test'; //Subject od your mail
	//$mail->AddAddress('sales@hybriditrfp.com','hybriditrfp.com'); //To address who will receive this email
	$mail->AddAddress('kam1988@gmail.com','Kamal'); //To address who will receive this email
	$mail->MsgHTML('TESTING TESTING TESTING'); //Put your body of the message you can place html code here
	if(!$mail->Send()) {
		 echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
	} else {  
		echo 'Message has been sent';
	}

?>
