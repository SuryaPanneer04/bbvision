<?php
require '../../connect.php';
date_default_timezone_set("Asia/Kolkata");
$curdate = date("d-m-y");

$id = $_REQUEST['attendance_id'];

$attendance_id = implode(',',$id); 

$attendance_delete_sql = "DELETE FROM bb_attendance WHERE id in ($attendance_id)";
$attendance_delete = $con->query($attendance_delete_sql);

if ($attendance_delete) {
	//echo "<script>window.location.href='../../index.php';</script>";
  echo 1;
} else{
	echo 0;
}

	
	


