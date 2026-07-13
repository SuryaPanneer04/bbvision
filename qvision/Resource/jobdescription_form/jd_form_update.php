<?php 
include('../../../connect.php');
include('../../../user.php');
$userid=$_SESSION['userid'];
$candidid=$_SESSION['candidateid'];

$jid=$_REQUEST['jid'];
$jd_title=$_REQUEST['jd_title'];
$location=$_REQUEST['location'];
$experience=$_REQUEST['experience'];
$education=$_REQUEST['education'];
$certificate=$_REQUEST['certificate'];
$roles=$_REQUEST['roles'];
$skills=$_REQUEST['skills'];
$date_joining=$_REQUEST['date_joining'];
$date_close=$_REQUEST['date_close'];
$replacement=$_REQUEST['replacement'];
$ctc=$_REQUEST['ctc'];
$no_of_postion=$_REQUEST['no_of_postion'];
$status=0;


$upd=$con->query("update jobdescription_form_details set jobdescription_id='$jd_title',location='$location',experience='$experience',education='$education',certifications='$certificate',roles='$roles',skills='$skills',joining_date='$date_joining',closed_date='$date_close',replacement='$replacement',ctc='$ctc',no_of_postion='$no_of_postion',status='$status',modified_by='$userid',modified_on=now() where id='$jid'");

if($upd)
{
	echo 1;
}
else
{
	echo 0;
}
?>