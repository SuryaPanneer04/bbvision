<?php
require '../../../connect.php';
include("../../../user.php");
$user=$_SESSION['userid'];
$candidateid=$_SESSION['candidateid'];

$uploadDir = 'resignation_file_upload/';  //File Upload Path.

require '../../../PHPMailer/PHPMailerAutoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../../../PHPMailer/src/Exception.php';
require '../../../PHPMailer/src/PHPMailer.php';
require '../../../PHPMailer/src/SMTP.php';


$filesArr3 = $_FILES["resignation_letter"]; //Resignation Letter upload.

//Resignation Letter
$uploadedFile = ''; 
// File upload path  
 foreach($filesArr3['name'] as $key=>$val)
 {
	 $fileName = basename($filesArr3['name'][$key]);  
	 $targetFilePath = $uploadDir . $fileName; 
	   
	 // Check whether file type is valid  
	  $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);  
	 
		 // Upload file to server  
		 if(move_uploaded_file($filesArr3["tmp_name"][$key], $targetFilePath)){  
			 $uploadedFile .= $fileName.',';  
	 }
 }


$dep_ids = $con->query("select emp_name,dep_id,reporting_person from staff_master where candid_id='$candidateid'"); //To find emp name,reporting person.
$dep_id = $dep_ids->fetch();
$emp_name = $dep_id['emp_name'];
$dep = $dep_id['dep_id'];
$reportingPerson = $dep_id['reporting_person']; 

$reporting_per = $con->query("select id,candid_id,emp_name from staff_master where id='$reportingPerson'"); //To find reporting person can id and full name.
$report = $reporting_per->fetch();
$FULLNAME = $report['emp_name']; 
$report_per_candid = $report['candid_id'];  


$reporting_canid_id = $con->query("select email_id from z_user_master where candidate_id='$report_per_candid'"); //To find reporting person mail id to send resignation mail for TO ADDRESS.
$can_id_report = $reporting_canid_id->fetch();
$SENDMAIL = $can_id_report['email_id'];

$emp_mailId = $con->query("select email_id from z_user_master where candidate_id='$candidateid'"); //To find employee mail id to send resignation mail for FROM ADDRESS.
$emp_mail = $emp_mailId->fetch();
$FROMADDRESS = $emp_mail['email_id'];

  $relieve_reason = $_REQUEST['relieve_reason'];
 // $remarks=$_REQUEST['remarks'];
  $status=1;
  $upd=$con->query("insert into resignation_form_details (candidate_id,candidate_dep_id,reason,remarks,applied_date,reporting_person,status)values('$candidateid','$dep','$relieve_reason','$fileName',now(),'$reportingPerson','$status')");

  echo "insert into resignation_form_details (candidate_id,candidate_dep_id,reason,remarks,applied_date,reporting_person,status)values('$candidateid','$dep','$relieve_reason','$fileName',now(),'$reportingPerson','$status')";



  if($upd)
  {
  
$mail = new PHPMailer;
$mail->SMTPDebug = 2; 
$mail->Mailer = "smtp";
$mail->IsSMTP(true); 
$mail->Port = 587;
$mail->Host = 'webmail.quadsel.in';        
$mail->SMTPAuth = true;                              // Enable SMTP authentication
$mail->Username = 'hr@quadsel.in';
$mail->Password = 'Hr@2024#';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
$mail->SMTPOptions = [
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
		'allow_self_singed' => true,
    ]
];
$mail->From = 'hr@quadsel.in';		//Sets the From email address for the message
// $mail->From = $FROMADDRESS;		//Sets the From email address for the message
$mail->FromName = $emp_name ;
$mail->AddAddress($SENDMAIL, $FULLNAME);		//Adds a "To" address
$mail->AddCC('hr@ssinformation.in'); // CC to HR to know about the Resignation.
$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
$mail->isHTML(true);                                 // Set email format to HTML

$subject="Applying for Resignation ";	


	
	$html_table = '<div style="color: #178ae3;">Dear&nbsp;&nbsp;'. $FULLNAME.',  <br> <br>
		&nbsp;&nbsp;' .$relieve_reason .'.<br><br> ';
		
	$html_table .=' <h4>Thanks & Regards,</h4><br>
	<p>'.$emp_name.'</p>
	<p>SS Information Systems Pvt Ltd.</p></div>';

	
	$mail->Subject =$subject;
	$mail->Body =$html_table;

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
	echo 0;
} 
else {
	echo 1;
} 

}
else
{
  echo 0;
}
?>
