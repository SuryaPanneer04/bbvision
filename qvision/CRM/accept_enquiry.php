<?php
require '../../connect.php';
require '../../user.php';

$id=$_REQUEST['get_id'];
$candidateid=$_SESSION['candidateid'];
$today_date=$_REQUEST['t_date'];
$feedback=$_REQUEST['feedback'];
$feedback_count=count($feedback);
$date=$_REQUEST['date'];


 for($i=0;$i<$feedback_count;$i++)
{
	
$todaydate= $today_date[$i];
$feedbacks= $feedback[$i];
$dates= $date[$i];

 
  $sql1=$con->query("insert into `feedback_enquiry_crm`(`enquiry_id`,`date`, `Feedback`, `feedback_date`, `created_by`)  values('$id','$todaydate','$feedbacks','$dates','$candidateid')");  


echo "insert into `feedback_enquiry_crm`(`enquiry_id`, `date`, `Feedback`, `feedback_date`, `created_by`)  values('$id','$todaydate','$feedbacks','$dates','$candidateid')";  

exit;
}





?>






