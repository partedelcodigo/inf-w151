<?php
  header('Access-Control-Allow-Origin: *');
//error_reporting(1);

require("plugins/phpmailer/class.phpmailer.php");
//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

$contactMailData = array('name' => 'IAA', 'host' => 'mail.enbolivia.com', 'usermail' => 'joseluis@enbolivia.com', 'password' => 'Tnpjoseluis1', 'completemail' => 'joseluis@enbolivia.com', 'SMTPAuth' => '1');

//$fromP = array('usermail_info' => 'gaston@enbolivia.com','usermail' => 'gaston@enbolivia.com', 'message'=>'este el contenido');
$fromP = array('usermail_info' => 'gastonnina@gmail.com','usermail' => 'gastonnina@gmail.com', 'name'=>'Gaston Nina', 'message'=>'este el contenido');

//comentado
//$fromP['usermail_info']='codigobase.com@gmail.com';
$fromP['usermail_info']='info@codigobase.com';
/**/
if(isset($_POST['type']) && $_POST['type']=='appB'){
    $fromP['name']=isset($_POST['name'])?$_POST['name']:'Anonimo';
    $fromP['usermail']=isset($_POST['usermail'])?$_POST['usermail']:$fromP['usermail'];
    $fromP['message']=isset($_POST['message'])?$_POST['message']:$fromP['message'];
}else{
    $msg='{"has_sent":"bad1"}';
    echo $msg;
    exit;
}
/**/

$fromP['subject'] = 'Form Contact';




$mail             = new PHPMailer();

//--$body             = file_get_contents('contents.html');
$body = '<b>gastobn demo</b>';
$body = @preg_replace('/[\]/i', '', $body);
$body = '<b>contenido' . $fromP['message'] . '</b>';



include_once('plugins/tbs/tbs_class.php');

//global $bmsg,$name;
$formd[0]=array('lbl'=>'Nombre','value'=>$fromP['name']);
$formd[1]=array('lbl'=>'Correo','value'=>$fromP['usermail']);
$formd[2]=array('lbl'=>'Mensaje','value'=>$fromP['message']);
$TBS = new clsTinyButStrong;
$TBS->LoadTemplate('templates/basic.html');
$TBS->MergeBlock('element',$formd);



$body = $TBS->Source ;
//echo $body;exit;
//FIXME - poner template desde tbs

//$mail->IsSMTP(); // telling the class to use SMTP
$mail->Host       = $contactMailData['host']; // SMTP server
//$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only*/
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->Host       = $contactMailData['host']; // sets the SMTP server
//--$mail->Port       = 26;                    // set the SMTP port for the GMAIL server
$mail->Port       = 25;                    // set the SMTP port for the GMAIL server
$mail->Username   = $contactMailData['usermail']; // SMTP account username
$mail->Password   = $contactMailData['password'];        // SMTP account password

$mail->SetFrom($fromP['usermail_info'], 'Cliente App');

$mail->AddReplyTo($fromP['usermail'],"Cliente App");

$mail->Subject    = $fromP['subject'];

//--$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

$mail->MsgHTML($body);

$address = $fromP['usermail_info'];;
$mail->AddAddress($address, "Admininstrator");

//--$mail->AddAttachment("images/phpmailer.gif");      // attachment
//--$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment

if(!$mail->Send()) {
  //echo "Mailer Error: " . $mail->ErrorInfo;
  $msg='{"has_sent":"bad"}';
} else {
  //echo "Message sent!";
    $msg='{"has_sent":"ok"}';
}
echo $msg;
    

