<?php
require '../../connect.php';
$target_dir = 'attendance_files/'; 
date_default_timezone_set("Asia/Kolkata");

if (isset($_POST['Upload'])) {
	    $insert = false;
	//Check upload file is empty or not
	if ((!empty($_FILES["file"])) && ($_FILES['file']['error'] == 0)) {

		//Excell File properties 
		$file_name = $_FILES['file']['name'];
		$tmp = explode('.', $file_name);
		$file_ext = end($tmp);
		$extensions = array("csv");

		//check upload file type csv or not
		if (in_array($file_ext, $extensions) === false) {
			echo "extension not allowed, please choose a csv file.";
		} else {
			$curdate = date("d-m-y");
			$file = $_FILES['file']['tmp_name'];
			$handle = fopen($file, "r");
			$heading = true;

			//$f = fopen($file, "r");
			// $data = fgetcsv($f, 1000, ",");
			while (($filesop = fgetcsv($handle)) !== FALSE) {
				if ($heading) {
					// unset the heading flag
					$heading = false;
					// skip the loop
					continue;
				}
			     $emp_code = trim($filesop[1]);
				

				$code = substr($emp_code, 0, 5);

				$emp_no = substr($emp_code, 5);
				//echo $emp_no.'***'.$code;

				// Modified excel file by Ilaya:

				$emp_name_sql = "SELECT id,emp_name,emp_code,prefix_code,dep_id,div_id,design_id FROM staff_master WHERE emp_code = '$emp_code' ";
//echo "SELECT id,emp_name,emp_code,prefix_code,dep_id,div_id,design_id FROM staff_master WHERE emp_code = '$emp_code' ";
				$emp_name_list = $con->query($emp_name_sql);
				$emp_name_data = $emp_name_list->fetch(PDO::FETCH_ASSOC);
				if($emp_name_data)
				{
			
			//	echo $emp_name."empname";
			$emp_name = $emp_name_data['emp_name'];
				$emp_id = $emp_name_data['id'];
				$emp_code=$emp_name_data['emp_code'];
				$dep_id = $emp_name_data['dep_id'];
				$div_id = $emp_name_data['div_id'];
				$design_id = $emp_name_data['design_id'];
                }
				else 
				{
				$emp_name ="Nill";
			//	echo $emp_name."empname";
				$emp_id ="Nill";
				$dep_id ="Nill";
				$div_id ="Nill";
				$design_id ="Nill";
				}
				
				$filesop[2] = date('Y-m-d', strtotime($filesop[2]));	
				//echo $filesop[2]."jjijijijij";
				$datecheck = $con->query("
SELECT date FROM daily_attendance 
WHERE emp_code ='$emp_code' AND date ='$filesop[2]'
");
				$check_row = $datecheck->rowCount();
				if ($check_row == 0) {

					// Day find out:
					$nameOfDay = date('l', strtotime($filesop[2]));

					// Working Hours Calculation:					
					if ($filesop[3] == '' && $filesop[4] == '') {
						$workingHours = 0;
					} else if ($filesop[4] == '') {
						$workingHours = 9;
					} else if ($filesop[3] == '') {
						$workingHours = 9;
					} else if($filesop[3] == '9:00:00' && $filesop[4] == '6:00:00') {
						
						$workingHours = 9;

					}
					else 
					{
						
						$in = strtotime($filesop[3]);
$out = strtotime($filesop[4]);
$workingHours = ($out - $in) / 3600;
					}

                           // echo $workingHours."kokokok";
					$filesop[2] = date('Y-m-d', strtotime($filesop[2]));

					$month = date('m', strtotime($filesop[2])); // To find month in the Date. 
					$year  = date('Y', strtotime($filesop[2])); // To find Year in the Date. 

					// Using status for working days count;
					if ($filesop[5] == 0) {
						$worked_days = 0; //Absent LOP
					} elseif ($filesop[5] == 1) {
						$worked_days = 1; //Present
					} elseif ($filesop[5] == 2) {
						$worked_days = 1; //Casual Leave Present
					} elseif ($filesop[5] == 3) {
						$worked_days = 1; //Sick Leave Present
					} elseif ($filesop[5] == 4) {
						$worked_days = 1; //Earned Leave Present
					} elseif ($filesop[5] == 5) {
						$worked_days = 0.5; //Half a day Absent
					} elseif ($filesop[5] == 6) {
						$worked_days = 0.5; //Half a day Present
					}

					if ($emp_id != "Nill") {

						/* echo "INSERT INTO daily_attendance(emp_code,emp_name,dep_id,div_id,design_id,date,log_day,out_log_date,punch_in_time,punch_out_time,work_hours,status) VALUES ('$emp_id','$emp_name','$dep_id','$div_id','$design_id','$filesop[2]','$nameOfDay','$filesop[3]','$filesop[4]','$filesop[5]','$workingHours','$filesop[6]')"; exit; */

						//mysql table insert		   
						$candid = $emp_id; // VERY IMPORTANT


$insert = $con->query("
INSERT INTO daily_attendance(
    candid_id,
    emp_code,
    emp_name,
    date,
    status,
    month,
    year,
    halfday
) VALUES (
    '$candid',
    '$emp_code',
    '$emp_name',
    '$filesop[2]',
    '$filesop[5]',
    '$month',
    '$year',
    0
)");
					//echo "INSERT INTO daily_attendance(emp_code,emp_name,dep_id,div_id,design_id,date,log_day,punch_in_time,punch_out_time,work_hours,status,total_days,working_days) VALUES ('$emp_code','$emp_name','$dep_id','$div_id','$design_id','$filesop[2]','$nameOfDay','$filesop[3]','$filesop[4]','$workingHours','$filesop[5]','$filesop[6]','$worked_days')";
					}
				} else {
					header("Refresh:5; url=../../index.php");
					echo "Already Existed.";
				}
			}

			if (!$insert) {
    echo "<pre>";
    print_r($con->errorInfo());
    echo "</pre>";
} else {
				echo "<script>alert('Data Inserted Successfully')</script>";
				echo "<script>window.location.href='../../index.php';</script>";

				///////////////  Upload Attedance Files //////////////////////
	                $attendanceName = basename($_FILES["file"]["name"]);
					$target_file = $target_dir . basename($_FILES["file"]["name"]);
					$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
					move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
				
				///////////////  Upload Attedance Files  END //////////////////////
				 $month;//Month From date.
                 $year; //Year From date.

				$findAttFile = $con->query("select id from attendance_files where month = '$month' && year = '$year' ");
				$fileRow = $findAttFile->rowCount();
				if($fileRow == 0){
					$insertFile = $con->query("INSERT INTO attendance_files (`month`, `year`, `file_name`) VALUES('$month','$year','$attendanceName')");
				}
				else{
				   $findAtt = $findAttFile -> fetch();
                   $id = $findAtt['id'];
				   
				   $updateFile = $con->query("UPDATE attendance_files SET file_name = '$attendanceName'  WHERE id = '$id'");
				}
			
			}
		}

		//fclose($handle);
	} else {
		echo "CSV Column name are not matching";
	}
}
?>