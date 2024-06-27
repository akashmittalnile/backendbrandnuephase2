<?php

//error_reporting(E_ALL);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


$msg = '';

$headerBody = '<table border="0" width="100%"><tr>
<td><img src="https://admin.brandnueweightloss.com/admin/images/logo.svg" alt="Logo" width="130" /></td>
</tr></table><hr />';

$footerBody = '';

$bodyMessage = '<table width="650" border="0" bgcolor="#f1f1f1" style="padding:10px;"><tr><td>'; 
$bodyMessage .= $headerBody; 
$bodyMessage .= "<p>Hi Admin, </p><p>Below are the test email info:</p>";
$bodyMessage .= "<table border='1' width='100%' cellpadding='10'>";
$bodyMessage .= "<tr><td>Name: </td><td>Arun Kumar</td></tr>";
$bodyMessage .= "<tr><td>Email: </td><td>arun.kumar@niletechnologies.com</td></tr>";
$bodyMessage .= "<tr><td>Address: </td><td>Noida, India</td></tr>";
$bodyMessage .= "<tr><td>Message: </td><td>Testing message</td></tr>";
$bodyMessage .= "</table>";
$bodyMessage .= '<p>Warm Regards <br />Brand Nue Team</p><hr />';
$bodyMessage .= $footerBody;
$bodyMessage .= '</td></tr></table>';
// print_r($_POST);
// die('=');
//echo $bodyMessage; die;
if(isset($_POST['to_mail']) && !empty($_POST['to_mail'])){
	$mail = new PHPMailer;
	$mail->isHTML(true);
	$mail->Host = 'localhost';
	$mail->Port = 25; 
	//$mail->CharSet = PHPMailer::CHARSET_UTF8;
	$mail->setFrom('admin@brandnueweightloss.com', 'Brand Nue' );
	$mail->addAddress($_POST['to_mail'], $_POST['to_mail']);
	//$mail->addReplyTo( $postData['email'], $postData['full_name'] );

	$mail->Subject = $_POST['subject'] ?? 'Brand Nue';
	$mail->Body = $_POST['html'] ?? $bodyMessage;
	if(!$mail->send()) {
		echo json_encode(array('flag' => false, 'message'=>"Error: ".$mail->ErrorInfo ));
		die;
	}else{
		echo json_encode(array('flag' => true,'message'=>"We have sent an activation link to your registered email Id."));
		die;
	}
}
?>