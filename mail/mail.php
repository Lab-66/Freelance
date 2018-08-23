<?php 
require_once('class.phpmailer.php');
$email = new PHPMailer();
$email->From      = 'webtest.am@gmail.com';
$email->FromName  = 'Your Name';
$email->Subject   = 'Message Subject';
$email->Body      = 'first mail';
$email->AddAddress( 'webtest.am@gmail.com' );

$file_to_attach = 'PATH_OF_YOUR_FILE_HERE';

$email->AddAttachment( '1.jpg' );

return $email->Send();

?>