<?php 
require '../../../connect.php'; 
require '../../../user.php'; 

include ('pdf.php');

require '../../../PHPMailer/PHPMailerAutoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../../../PHPMailer/src/Exception.php';
require '../../../PHPMailer/src/PHPMailer.php';
require '../../../PHPMailer/src/SMTP.php';


$userid=$_SESSION['userid'];
$jid=$_REQUEST['jid'];
$consid=$_REQUEST['allocate'];

$cou=count($consid);
for($i=0;$i< $cou;$i++)
{
$ins=$con->query("insert into jd_allocation(jd_id,consultant_id,status,created_by,created_on)values('$jid','$consid[$i]',1,'$userid',now())");

 echo "insert into jd_allocation(jd_id,consultant_id,status,created_by,created_on)values('$jid','$consid[$i]',1,'$userid',now())"; echo "<br>";
}
if($ins)
{
	echo "insert Query is Working..."; echo "<br>";
}

$upd=$con->query("update jobdescription_form_details set status=2 where id='$jid'");

echo "update jobdescription_form_details set status=2 where id='$jid'"; echo "<br>";

if($upd)
{
	echo "update Query is Working..."; echo "<br>";
}
?>

<?php 
 $imp=implode(',',$consid);

 $consl_query= $con->query("select * from z_user_master u left join consultant_master c on u.consultant_id=c.consultant_id left join candidate_form_details f on u.candidate_id=f.id where u.consultant_id in($imp)");
 
 echo "select * from z_user_master u left join consultant_master c on u.consultant_id=c.consultant_id left join candidate_form_details f on u.candidate_id=f.id where u.consultant_id in($imp)"; echo "<br>";
 
 while($row= $consl_query->fetch())

 {	
    $FULLNAME       =  $row['full_name'];;
    $SENDMAIL       =  $row['email_id'];
    $USERNAME       =  $row['user_name'];
    $PASSWORD       =  "Welcome@123";
   

$mail = new PHPMailer;
$mail->SMTPDebug = 2; 
$mail->Mailer = "smtp";
$mail->IsSMTP(true); 
$mail->Port = 587;
$mail->Host = 'mail2.ssinformation.in';        
$mail->SMTPAuth = true;                              // Enable SMTP authentication
$mail->Username = 'purcahse.in';
$mail->Password = 'dqR8mdSzsb';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
$mail->SMTPOptions = [
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
		'allow_self_singed' => true,
    ]
];
$mail->From = 'test1@ssinformation.in';		//Sets the From email address for the message

$mail->FromName = 'SS Information';
$mail->AddAddress($SENDMAIL, $FULLNAME);		//Adds a "To" address
		
	$mail->WordWrap = 50;							//Sets word wrapping on the body of the message to a given number of characters
	$mail->IsHTML(true);							//Sets message type to HTML				
	 				//Adds an attachment from a path on the filesystem
	$mail->Subject = 'New JD';			//Sets the Subject of the message
					//An HTML or plain text message body
		
	$html_table = 'Dear&nbsp;&nbsp;'. $FULLNAME.', <br> 
		&nbsp;&nbsp;
		SS Information Systems Software has been shared a Job Description with you. Please login by clicking on 
		SS Information Software. You can Submit Candidates Profile for Further Processing. Contact your SS Information recruiting partner for further guidance.
		
			 <table class="table table-hover table-bordered"  border=1 style="margin: 15px 0 98px 0px!important;">   
			<thead style="color:#0033FF;">					
			<tr style="text-align:center;">			
			<th style="font-size:15px;">#</th>
			<th style="font-size:15px;">User Name</th>
			<th style="font-size:15px;">Password</th> 
			
			</tr>	
			</thead>';
		$html_table .='<tr>
									<td>' . "1".'</td>
									<td>' . $USERNAME.'</td>
									<td>' . $PASSWORD.'</td> 
									
							  </tr>'; 
	$html_table .=' </table>';
	$html_table .='<button class="btn btn-primary"><a href="http://bsplassetsrv.bluebase.in:8084/ssinfo1/index.php">Bluebase Software Services Private Limited</a></button>';

	$html_table .=' <h4>Thanks & Regards,</h4><br>
	<p>SS Information</p> <br>';				
    
	
	
	$mail->Body = $html_table;
	
	if(!$mail->send()) 
	{
       echo 'Message could not be sent.';
       echo 'Mailer Error: ' . $mail->ErrorInfo;
	   echo "0";
    } 
    else 
	{
        $message = '<label class="text-success">UserName and PassWord has been send successfully...</label>';echo $message;
	   // $update_query = $con->query("update quotation_entry set flag ='1' , modified_by ='$user_id',modified_on =NOW() WHERE quote_no= '$QuoteNo'");  
		//echo "update quotation_entry set flag ='1' , modified_by ='$user_id',modified_on =NOW() WHERE quote_no= '$QuoteNo'";
	
	}
 }
	?>