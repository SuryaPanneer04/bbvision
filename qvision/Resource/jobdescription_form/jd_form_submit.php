<?php 
include('../../../connect.php');
include('../../../user.php');
$userid=$_SESSION['userid'];
$candidid=$_SESSION['candidateid'];

$reportingId = $con -> query("Select reporting_person from staff_master where candid_id='$candidid'");

$staffId = $reportingId -> fetch();
$reportingPerson = $staffId['reporting_person']; 

$txt_org_name=$_REQUEST['org_name'];
$explodevalorgname=explode("-",$txt_org_name);
$org_name=$explodevalorgname[1];
//ho $org_name."pppppppppppppppppppppppppppppppppp";
$jd_title=$_REQUEST['jd_title'];
$location=$_REQUEST['location'];
$shift_timing=$_REQUEST['shift_timing'];
$weekly_off=$_REQUEST['weekly_off'];
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
//$approve=$_REQUEST['approve'];
$round=$_REQUEST['round'];
$status=6;

$sql=$con->query("insert into jobdescription_form_details (jobdescription_id,client_org_name,location,shift_timing,weekly_off,experience,education,certifications,roles,skills,joining_date,closed_date,replacement,ctc,no_of_position, status,created_by,created_on,interview_round_level,reportingPerson) values('$jd_title','$org_name','$location','$shift_timing','$weekly_off','$experience','$education','$certificate','$roles','$skills','$date_joining','$date_close','$replacement','$ctc','$no_of_postion','$status','$userid',now(),'0','$reportingPerson')");
//echo "insert into jobdescription_form_details (jobdescription_id,client_org_name,location,shift_timing,weekly_off,experience,education,certifications,roles,skills,joining_date,closed_date,replacement,ctc,no_of_position, status,created_by,created_on,interview_round_level,reportingPerson) values('$jd_title','$org_name','$location','$shift_timing','$weekly_off','$experience','$education','$certificate','$roles','$skills','$date_joining','$date_close','$replacement','$ctc','$no_of_postion','$status','$userid',now(),'0','$reportingPerson')";
if($sql)
{
echo 1;
}
else
{
	echo 0;
}
?>