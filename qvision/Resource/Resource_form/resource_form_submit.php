<?php
include('../../../connect.php');
include('../../../user.php');

$userid = $_SESSION['userid'];

//echo $userid.'dfghgfd';
$uploadDir = 'resume_upload/';



$org_name = $_REQUEST['Client_Org_Name']; //org_name
$location = $_REQUEST['location']; //location

//echo $org_name."**".$location;
$source = $_REQUEST['source'];
$consl_name = $_REQUEST['consl_name'];
$referal_type = $_REQUEST['referal_type'];

$ref_name = $_REQUEST['get_ref_name'];
$ref_name2 = $_REQUEST['get_ref_name2'];

$consl_date = $_REQUEST['consl_date'];
$pos = $_REQUEST['position'];
$pos_get = explode(".", $pos);
$position = $pos_get[0];
$jdcode = $pos_get[1];
//echo $jdcode=$_REQUEST['jdcode'];


$first_name = $_REQUEST['first_name'];
$last_name = $_REQUEST['last_name'];
$full_name = $first_name . " " . $last_name;
$gender = $_REQUEST['gender'];
$phone = $_REQUEST['phone'];
$whatsapp = $_REQUEST['whatsapp'];
$mail = $_REQUEST['mail'];
$adharnumber = $_REQUEST['adharnumber'];
$degree = $_REQUEST['degree'];
$university = $_REQUEST['university'];
$year_of_pass = $_REQUEST['year_of_pass'];
$percentage = $_REQUEST['percentage'];
$EmployeeStatus = $_REQUEST['EmployeeStatus'];
$companyname = $_REQUEST['companyname'];
$no_of_year_exp = $_REQUEST['no_of_year'];
$cer_status = $_REQUEST['cer_status'];
$certificate = $_REQUEST['certificate'];
$validity_to = $_REQUEST['validity'];
$cer_from = $_REQUEST['cer_from'];

$filesArr3 = $_FILES['file'];

$status = 1;

if ($referal_type == "Internal Referal") {
	$sql_asset = $ref_name;
} else if ($referal_type == "External Referal") {
	$sql_asset = $ref_name2;
} else {
	$sql_asset = NULL;
}
//Resume
$uploadedFile = '';
// File upload path  
foreach ($filesArr3['name'] as $key => $val) {
	$fileName = basename($filesArr3['name'][$key]);
	$targetFilePath = $uploadDir . $fileName;

	// Check whether file type is valid  
	$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

	// Upload file to server  
	if (move_uploaded_file($filesArr3["tmp_name"][$key], $targetFilePath)) {
		$uploadedFile .= $fileName . ',';
	}
}

$candidate = $con->query("SELECT interview_round_level FROM jobdescription_form_details WHERE jdcode = '$jdcode'");
$approve_round = $candidate->fetch();
//$approve_level = $approve_round['approval_level'];
$interview_round = $approve_round['interview_round_level'];




if ($interview_round != '') //interview round not empty
{
	$sql = $con->query("insert into resource_form_detail (source,jdid,client_org_name,location,consultant_name,referal_type,referal_name,date, position, first_name, last_name, gender, mobile, whatsapp,mail,aadhar_no, degree, university, year_of_pass, percentage, employement_status, company_name, year_experience,certification_status, certification, validity, certified_from,resume,status, created_by, created_on,interview_round,old_status)values('$source','$jdcode','$org_name','$location','$consl_name','$referal_type','$sql_asset','$consl_date','$position','$first_name','$last_name','$gender','$phone','$whatsapp','$mail','$adharnumber','$degree','$university','$year_of_pass','$percentage','$EmployeeStatus','$companyname','$no_of_year_exp','$cer_status','$certificate','$validity_to','$cer_from','$fileName',1,'$userid',now(),'$interview_round',0)");

	if ($sql) {

		$resources_id = $con->query("SELECT  id from resource_form_detail ORDER BY id DESC LIMIT 1");
		$res_id = $resources_id->fetch();
		$resourceID = $res_id['id'];

		if ($EmployeeStatus == "Fresher") {
			$year_of_pass = $_REQUEST['year_of_pass'];

			$inserts = $con->query("INSERT INTO candidate_form_details(`resource_id`,`position`,`first_name`,`client_org_name`,`location`,`last_name`, `gender`, `phone`,`alternative_phone`,`mail`, `adharnumber`, `educationalDetails`, `EmployeeStatus`, `year_of_pass`,`resume`, `status`, `created_by`, `created_on`, `interview_round_level`,`old_status`) VALUES ('$resourceID','$position','$first_name','$org_name','$location', '$last_name', '$gender', '$phone', '$whatsapp','$mail', '$adharnumber', '$degree', '$EmployeeStatus', '$year_of_pass','$fileName',1,'$userid',now(),'$interview_round',0)");
			//echo $inserts;
		} else {

			$inserts = $con->query("INSERT INTO candidate_form_details(resource_id, position,first_name,client_org_name,location,last_name,gender,phone,alternative_phone,mail,adharnumber,educationalDetails, EmployeeStatus,companyname,no_of_year,resume,status,created_by, created_on, interview_round_level,old_status)VALUES ('$resourceID','$position','$first_name','$org_name','$location','$last_name', '$gender','$phone','$whatsapp', '$mail', '$adharnumber', '$degree', '$EmployeeStatus','$companyname', '$no_of_year_exp','$fileName', 1 ,'$userid',now(),'$interview_round',0)");
		}

		$edit_id = $con->query("SELECT id FROM candidate_form_details order by id desc limit 1");
		$res = $edit_id->fetch();
		$candidate_id = $res['id'];

		if ($inserts) {
			$password = md5("Welcome@123");
			if ($gender == 'female') {
				$ingenter = 2;
			} else {
				$ingenter = 1;
			}
			$insert = $con->query("insert into z_user_master(candidate_id,user_name,password,full_name,status,email_id,user_group_code,mobile_no,gender,created_by,created_on)values('$candidate_id','','','$full_name','1','$mail','ROLE-006','$phone','$ingenter','$userid',now())");
		}
	}
}
/////////////////////////////////////////////////////////////////////////////////////////////////////

else // interview round is an empty
{
	$sql = $con->query("insert into resource_form_detail (source,jdid,client_org_name,location,consultant_name,referal_type,referal_name,date, position, first_name, last_name, gender, mobile, whatsapp,mail,aadhar_no, degree, university, year_of_pass, percentage, employement_status, company_name, year_experience,certification_status, certification, validity, certified_from,resume,status, created_by, created_on,interview_round,old_status)values('$source','$jdcode','$org_name','$location','$consl_name','$referal_type','$sql_asset','$consl_date','$position','$first_name','$last_name','$gender','$phone','$whatsapp','$mail','$adharnumber','$degree','$university','$year_of_pass','$percentage','$EmployeeStatus','$companyname','$no_of_year_exp','$cer_status','$certificate','$validity_to','$cer_from','$fileName',1,'$userid',now(),'2',0)");
	//  echo "insert into resource_form_detail (source,jdid,client_org_name,location,consultant_name,referal_type,referal_name,date, position, first_name, last_name, gender, mobile, whatsapp,mail,aadhar_no, degree, university, year_of_pass, percentage, employement_status, company_name, year_experience,certification_status, certification, validity, certified_from,resume,status, created_by, created_on,interview_round)values('$source','$jdcode','$org_name','$location','$consl_name','$referal_type','$sql_asset','$consl_date','$position','$first_name','$last_name','$gender','$phone','$whatsapp','$mail','$adharnumber','$degree','$university','$year_of_pass','$percentage','$EmployeeStatus','$companyname','$no_of_year_exp','$cer_status','$certificate','$validity_to','$cer_from','$fileName',1,'$userid',now(),'2')";
	if ($sql) {

		$resources_id = $con->query("SELECT  id from resource_form_detail ORDER BY id DESC LIMIT 1");
		$res_id = $resources_id->fetch();
		$resourceID = $res_id['id'];

		if ($EmployeeStatus == "Fresher") {
			//echo "vimalaif";
			$year_of_pass = $_REQUEST['year_of_pass'];

			$inserts = $con->query("INSERT INTO candidate_form_details(resource_id,position,first_name,client_org_name,location,last_name, gender, phone,alternative_phone, mail, adharnumber, educationalDetails, EmployeeStatus, year_of_pass, resume, status, created_by, created_on, interview_round_level,old_status) VALUES ('$resourceID','$position','$first_name','$org_name','$location', '$last_name', '$gender', '$phone', '$whatsapp','$mail', '$adharnumber', '$degree', '$EmployeeStatus', '$year_of_pass','$fileName',1,'$userid',now(),'2',0)");
			//echo $inserts;
		} else {
			//echo "priyaelse";
			$inserts = $con->query("INSERT INTO candidate_form_details(resource_id,position,first_name,client_org_name,location,last_name,gender,phone,alternative_phone,mail,adharnumber, educationalDetails, EmployeeStatus,  companyname, no_of_year, resume, status, created_by, created_on, interview_round_level,old_status)VALUES ('$resourceID','$position', '$first_name','$org_name','$location','$last_name', '$gender','$phone','$whatsapp', '$mail', '$adharnumber', '$degree', '$EmployeeStatus', '$companyname', '$no_of_year_exp','$fileName', 1 ,'$userid',now(),'2',0)");
			//echo $inserts;

		}

		$edit_id = $con->query("SELECT id FROM candidate_form_details order by id desc limit 1");
		$res = $edit_id->fetch();
		$candidate_id = $res['id'];

		if ($inserts) {
			$password = md5("Welcome@123");
			$insert = $con->query("insert into z_user_master(candidate_id,user_name,password,full_name,status,email_id,user_group_code,mobile_no,gender,created_by,created_on)values('$candidate_id','','','$full_name','1','$mail','ROLE-006','$phone','$gender','$userid',now())");
		}
	}
}
//echo $sql;


// father_name , dob , address , paddress, alternative_phone,pannumber, voternumber, driving_license.

if ($sql) {
	echo 1;
} else {
	echo 0;
}
?><?php
	include('../../../connect.php');
	include('../../../user.php');

	$userid = $_SESSION['userid'];

	//echo $userid.'dfghgfd';
	$uploadDir = 'resume_upload/';

	$org_name = $_REQUEST['Client_Org_Name']; //org_name
	$location = $_REQUEST['location']; //location

	//echo $org_name."**".$location;
	$source = $_REQUEST['source'];
	$consl_name = $_REQUEST['consl_name'];
	$referal_type = $_REQUEST['referal_type'];

	$ref_name = $_REQUEST['get_ref_name'];
	$ref_name2 = $_REQUEST['get_ref_name2'];

	$consl_date = $_REQUEST['consl_date'];
	$pos = $_REQUEST['position'];
	$pos_get = explode(".", $pos);
	$position = $pos_get[0];
	$jdcode = $pos_get[1];
	//echo $jdcode=$_REQUEST['jdcode'];


	$first_name = $_REQUEST['first_name'];
	$last_name = $_REQUEST['last_name'];
	$full_name = $first_name . " " . $last_name;
	$gender = $_REQUEST['gender'];
	$phone = $_REQUEST['phone'];
	$whatsapp = $_REQUEST['whatsapp'];
	$mail = $_REQUEST['mail'];
	$adharnumber = $_REQUEST['adharnumber'];
	$degree = $_REQUEST['degree'];
	$university = $_REQUEST['university'];
	$year_of_pass = $_REQUEST['year_of_pass'];
	$percentage = $_REQUEST['percentage'];
	$EmployeeStatus = $_REQUEST['EmployeeStatus'];
	$companyname = $_REQUEST['companyname'];
	$no_of_year_exp = $_REQUEST['no_of_year'];
	$cer_status = $_REQUEST['cer_status'];
	$certificate = $_REQUEST['certificate'];
	$validity_to = $_REQUEST['validity'];
	$cer_from = $_REQUEST['cer_from'];

	$filesArr3 = $_FILES['file'];

	$status = 1;

	if ($referal_type == "Internal Referal") {
		$sql_asset = $ref_name;
	} else if ($referal_type == "External Referal") {
		$sql_asset = $ref_name2;
	} else {
		$sql_asset = NULL;
	}
	//Resume
	$uploadedFile = '';
	// File upload path  
	foreach ($filesArr3['name'] as $key => $val) {
		$fileName = basename($filesArr3['name'][$key]);
		$targetFilePath = $uploadDir . $fileName;

		// Check whether file type is valid  
		$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

		// Upload file to server  
		if (move_uploaded_file($filesArr3["tmp_name"][$key], $targetFilePath)) {
			$uploadedFile .= $fileName . ',';
		}
	}

	$candidate = $con->query("SELECT interview_round_level FROM jobdescription_form_details WHERE jdcode = '$jdcode'");
	$approve_round = $candidate->fetch();
	//$approve_level = $approve_round['approval_level'];
	$interview_round = $approve_round['interview_round_level'];




	if ($interview_round != '' || $interview_round != '0') //interview round not empty
	{
		$sql = $con->query("insert into resource_form_detail (source,jdid,client_org_name,location,consultant_name,referal_type,referal_name,date, position, first_name, last_name, gender, mobile, whatsapp,mail,aadhar_no, degree, university, year_of_pass, percentage, employement_status, company_name, year_experience,certification_status, certification, validity, certified_from,resume,status, created_by, created_on,interview_round,old_status)values('$source','$jdcode','$org_name','$location','$consl_name','$referal_type','$sql_asset','$consl_date','$position','$first_name','$last_name','$gender','$phone','$whatsapp','$mail','$adharnumber','$degree','$university','$year_of_pass','$percentage','$EmployeeStatus','$companyname','$no_of_year_exp','$cer_status','$certificate','$validity_to','$cer_from','$fileName',1,'$userid',now(),'$interview_round',0)");

		if ($sql) {

			$resources_id = $con->query("SELECT  id from resource_form_detail ORDER BY id DESC LIMIT 1");
			$res_id = $resources_id->fetch();
			$resourceID = $res_id['id'];

			if ($EmployeeStatus == "Fresher") {
				$year_of_pass = $_REQUEST['year_of_pass'];

				$inserts = $con->query("INSERT INTO candidate_form_details(`resource_id`,`position`,`first_name`,`client_org_name`,`location`,`last_name`, `gender`, `phone`,`alternative_phone`,`mail`, `adharnumber`, `educationalDetails`, `EmployeeStatus`, `year_of_pass`,`resume`, `status`, `created_by`, `created_on`, `interview_round_level`,`old_status`) VALUES ('$resourceID','$position','$first_name','$org_name','$location', '$last_name', '$gender', '$phone', '$whatsapp','$mail', '$adharnumber', '$degree', '$EmployeeStatus', '$year_of_pass','$fileName',1,'$userid',now(),'$interview_round',0)");
				//echo $inserts;
			} else {

				$inserts = $con->query("INSERT INTO candidate_form_details(resource_id, position,first_name,client_org_name,location,last_name,gender,phone,alternative_phone,mail,adharnumber,educationalDetails, EmployeeStatus,companyname,no_of_year,resume,status,created_by, created_on, interview_round_level,old_status)VALUES ('$resourceID','$position','$first_name','$org_name','$location','$last_name', '$gender','$phone','$whatsapp', '$mail', '$adharnumber', '$degree', '$EmployeeStatus','$companyname', '$no_of_year_exp','$fileName', 1 ,'$userid',now(),'$interview_round',0)");
			}

			$edit_id = $con->query("SELECT id FROM candidate_form_details order by id desc limit 1");
			$res = $edit_id->fetch();
			$candidate_id = $res['id'];

			if ($inserts) {
				$password = md5("Welcome@123");
				if ($gender == 'female') {
					$ingenter = 2;
				} else {
					$ingenter = 1;
				}
				$insert = $con->query("insert into z_user_master(candidate_id,user_name,password,full_name,status,email_id,user_group_code,mobile_no,gender,created_by,created_on)values('$candidate_id','','','$full_name','1','$mail','ROLE-006','$phone','$ingenter','$userid',now())");
			}
		}
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////

	else // interview round is an empty
	{
		$sql = $con->query("insert into resource_form_detail (source,jdid,client_org_name,location,consultant_name,referal_type,referal_name,date, position, first_name, last_name, gender, mobile, whatsapp,mail,aadhar_no, degree, university, year_of_pass, percentage, employement_status, company_name, year_experience,certification_status, certification, validity, certified_from,resume,status, created_by, created_on,interview_round,old_status)values('$source','$jdcode','$org_name','$location','$consl_name','$referal_type','$sql_asset','$consl_date','$position','$first_name','$last_name','$gender','$phone','$whatsapp','$mail','$adharnumber','$degree','$university','$year_of_pass','$percentage','$EmployeeStatus','$companyname','$no_of_year_exp','$cer_status','$certificate','$validity_to','$cer_from','$fileName',1,'$userid',now(),'2',0)");
		//  echo "insert into resource_form_detail (source,jdid,client_org_name,location,consultant_name,referal_type,referal_name,date, position, first_name, last_name, gender, mobile, whatsapp,mail,aadhar_no, degree, university, year_of_pass, percentage, employement_status, company_name, year_experience,certification_status, certification, validity, certified_from,resume,status, created_by, created_on,interview_round)values('$source','$jdcode','$org_name','$location','$consl_name','$referal_type','$sql_asset','$consl_date','$position','$first_name','$last_name','$gender','$phone','$whatsapp','$mail','$adharnumber','$degree','$university','$year_of_pass','$percentage','$EmployeeStatus','$companyname','$no_of_year_exp','$cer_status','$certificate','$validity_to','$cer_from','$fileName',1,'$userid',now(),'2')";
		if ($sql) {

			$resources_id = $con->query("SELECT  id from resource_form_detail ORDER BY id DESC LIMIT 1");
			$res_id = $resources_id->fetch();
			$resourceID = $res_id['id'];

			if ($EmployeeStatus == "Fresher") {
				//echo "vimalaif";
				$year_of_pass = $_REQUEST['year_of_pass'];

				$inserts = $con->query("INSERT INTO candidate_form_details(resource_id,position,first_name,client_org_name,location,last_name, gender, phone,alternative_phone, mail, adharnumber, educationalDetails, EmployeeStatus, year_of_pass, resume, status, created_by, created_on, interview_round_level,old_status) VALUES ('$resourceID','$position','$first_name','$org_name','$location', '$last_name', '$gender', '$phone', '$whatsapp','$mail', '$adharnumber', '$degree', '$EmployeeStatus', '$year_of_pass','$fileName',1,'$userid',now(),'2',0)");
				//echo $inserts;
			} else {
				//echo "priyaelse";
				$inserts = $con->query("INSERT INTO candidate_form_details(resource_id,position,first_name,client_org_name,location,last_name,gender,phone,alternative_phone,mail,adharnumber, educationalDetails, EmployeeStatus,  companyname, no_of_year, resume, status, created_by, created_on, interview_round_level,old_status)VALUES ('$resourceID','$position', '$first_name','$org_name','$location','$last_name', '$gender','$phone','$whatsapp', '$mail', '$adharnumber', '$degree', '$EmployeeStatus', '$companyname', '$no_of_year_exp','$fileName', 1 ,'$userid',now(),'2',0)");
				//echo $inserts;

			}

			$edit_id = $con->query("SELECT id FROM candidate_form_details order by id desc limit 1");
			$res = $edit_id->fetch();
			$candidate_id = $res['id'];

			if ($inserts) {
				$password = md5("Welcome@123");
				$insert = $con->query("insert into z_user_master(candidate_id,user_name,password,full_name,status,email_id,user_group_code,mobile_no,gender,created_by,created_on)values('$candidate_id','','','$full_name','1','$mail','ROLE-006','$phone','$gender','$userid',now())");
			}
		}
	}
	//echo $sql;


	// father_name , dob , address , paddress, alternative_phone,pannumber, voternumber, driving_license.

	if ($sql) {
		echo 1;
	} else {
		echo 0;
	}
	?>