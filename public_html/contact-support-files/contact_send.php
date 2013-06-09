<?
require_once('../frameworks/tcpdf/config/lang/eng.php');
require_once('../frameworks/tcpdf/tcpdf.php');
require_once('../frameworks/PHPMailer/class.phpmailer.php');
session_start();
$PHPSESSID=session_id();
$fullName = $_POST["contact_form_full_name"];
$company = $_POST["contact_form_company"];
$email = $_POST["contact_form_email"];
$phone = $_POST["contact_form_phone"];
$message = $_POST["contact_form_message"];

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

</head>

<body>
<div style="font-size: 24px; padding: 25px; margin-top: 25px;">
<p>Dear <strong><? echo $_POST['contact_form_full_name']; ?></strong>,</p>
<div style="height: 25px;"><hr size="1"></div>
<p>Thank you for your message.</p>
<div style="height: 20px;"></div>
<p>We will be in contact shortly about your inquiry!</p>
<div style="height: 25px;"><hr size="1"></div>
<p>The <strong>Australian Karaoke Team</strong></p>
</div>

<?
$mailBody="";
$mail = new PHPMailer(true);
$mail->AddReplyTo('contact@australiankaraoke.com.au', 'Australian Karaoke Pty. Ltd.');
$mail->AddAddress('contact@australiankaraoke.com.au', 'Australian Karaoke Pty. Ltd.');
$mail->SetFrom($email);
$mail->WordWrap = 50;
$mail->Subject = "Australian Karaoke [web inquiry]";
$mail->MsgHTML("
<p><h2>WEB INQUIRY</h2></p>
<p><h3>From: ".$fullName."</h3></p>
<p><h3>Company: ".$company."</h3></p>
<p><h3>Email: ".$email."</h3></p>
<p><h3>Phone: ".$phone."</h3></p>

$message
");

if(!$mail->Send()) {
     echo "Sorry ... EMAIL FAILED"; 
}

?>
</body>
</html>