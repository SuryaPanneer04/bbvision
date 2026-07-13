<?php
require '../../connect.php';
require '../../user.php';
$userid=$_SESSION['userid'];

$cid=$_REQUEST['cid'];
$rid=$_REQUEST['rid'];
$round_type=$_REQUEST['round_type'];
$qn_name=$_REQUEST['qn_type'];
$allocate_person=$_REQUEST['allocate_person'];
//$approve=$_REQUEST['approve']; 
$interviewround=$_REQUEST['round'];

//$status=1;

if($allocate_person=='')
{	
 $ins=$con->query("insert into candidate_round_details(candid_id,round_id,qn_id,status,created_by,created_on)values('$cid','$round_type','$qn_name','4','$userid',now())");
 
 echo "insert into candidate_round_details(candid_id,round_id,qn_id,status,created_by,created_on)values('$cid','$round_type','$qn_name','4','$userid',now())"; 

 $upd=$con->query("update candidate_form_details set status=4 where id='$cid' and status=2");
 echo "update candidate_form_details set status=4 where id='$cid' and status=2";

 $iupd=$con->query("update interview_schedule_detail set status=2 where id='$rid'");
 echo "update interview_schedule_detail set status=2 where id='$rid'";
}

else
{	
 $ins=$con->query("insert into candidate_round_details(candid_id,round_id,person_id,status,created_by,created_on)values('$cid','$round_type','$allocate_person','3','$userid',now())");
 
 echo "insert into candidate_round_details(candid_id,round_id,person_id,status,created_by,created_on)values('$cid','$round_type','$allocate_person','3','$userid',now())";

 $upd=$con->query("update candidate_form_details set status=3 where id='$cid'");
 echo "update candidate_form_details set status=3 where id='$cid' and status=2";
 
 $iupd=$con->query("update interview_schedule_detail set status=2 where id='$rid' ");
 echo "update interview_schedule_detail set status=2 where id='$rid'";

 $round = $con -> query("INSERT INTO `interview_round_level`(`candidate_id`, `interview_round_level`, `status`, `created_by`, `created_on`) VALUES ('$cid','$interviewround',1,'$allocate_person',now())");

 echo "INSERT INTO `interview_round_level`(`candidate_id`, `interview_round_level`, `status`, `created_by`, `created_on`) VALUES ('$cid','$interviewround',1,'$allocate_person',now())";

}

if($upd)
{
	echo"<script>alert('Allocated successfully');</script>";
	echo "<script> interview_candidate_list(); </script>";
}
?>
