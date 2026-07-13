<?php 
include('../../../connect.php');
include('../../../user.php');
$userid=$_SESSION['userid'];

$resourceid=$_REQUEST['rid'];

$consl_date=$_REQUEST['consl_date'];
$first_name=$_REQUEST['first_name'];
$last_name=$_REQUEST['last_name'];
$gender=$_REQUEST['gender'];
$phone=$_REQUEST['phone'];
$whatsapp=$_REQUEST['whatsapp'];
$mail=$_REQUEST['mail'];
$adharnumber=$_REQUEST['adharnumber'];
$degree=$_REQUEST['degree'];
$university=$_REQUEST['university'];
$year_of_pass=$_REQUEST['year_of_pass'];
$percentage=$_REQUEST['percentage'];
 

$sql=$con->query("update resource_form_detail set `date`='$consl_date', `first_name`='$first_name', `last_name`='$last_name', `gender`= '$gender', `mobile`='$phone', `whatsapp`='$whatsapp',`mail`='$mail',`aadhar_no`='$adharnumber', `degree`='$degree', `university`='$university', `year_of_pass`='$year_of_pass', `percentage`='$percentage' where id='$resourceid'");

$candidateUpdate = $con -> query("UPDATE `candidate_form_details` SET `first_name`='$first_name',`last_name`='$last_name',`gender`='$gender',`phone`='$phone',`alternative_phone`='$whatsapp',`mail`='$mail',`adharnumber`='$adharnumber',`educationalDetails`='$degree',`year_of_pass`='$year_of_pass' WHERE `resource_id`='$resourceid'");


if ($sql)
{
	echo 1;
}
else
{
	echo 0;
}
?>