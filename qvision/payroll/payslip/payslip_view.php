<!DOCTYPE html>
<html lang="en">
<head>
    
<!--	<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css'>
	<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js'>
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'> -->

<style>
.border{
	 border: 6px solid #df8459 !important;
	 padding: 30px !important;
	 padding-bottom: 58px !important;
	 
}
hr:not([size]){
	height: 6px !important;
}
hr{
	margin: 1rem 0px !important;
    color: inherit !important;
    background-color: #df8459 !important;
    opacity: 1.25 !important;
}
.button {
  
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}
</style>
</head>
<body>
<?php
	require '../../../connect.php';	
	error_reporting(0);
	//$work_days="";
	$payroll_id = $_REQUEST['payroll_id'];
	$department = $_REQUEST['department'];
	 $candid_id = $_REQUEST['employee'];
	//get payroll_master details
		
	$staff_payroll_sql=$con->query("select id,month,year,flag from payroll_master where id = $payroll_id");
	$staff_payroll_res=$staff_payroll_sql->fetch(PDO::FETCH_ASSOC);
	$m=$staff_payroll_res['month'];
	$y=$staff_payroll_res['year'];
	
	$dateObj   = DateTime::createFromFormat('!m', $m);
	$monthName = $dateObj->format('F'); 
	
    switch ($m) {
      case "1":
       $pay_period = "16th Jan".' '.$y." – 15th Feb".' '.$y;
      break;
	  
      case "2":
       $pay_period = "15th Feb".' '.$y." – 16th Mar".' '.$y;
      break;
	  
      case "3":
       $pay_period = "16th Mar".' '.$y." – 15th Apr".' '.$y;
      break;
	  
	  case "4":
       $pay_period = "16th Apr".' '.$y." – 15th May".' '.$y;
      break;
	  
	  case "5":
       $pay_period = "16th May".' '.$y." – 15th Jun".' '.$y;
      break;
	  
	  case "6":
       $pay_period = "16th Jun".' '.$y."- 15th Jul".' '.$y;
      break;
	  
	  case "7":
       $pay_period = "16th Jul".' '.$y." – 15th Aug".' '.$y;
      break;
	  
	  case "8":
       $pay_period = "16th Aug".' '.$y." – 15th Sep".' '.$y;
      break;
	  
	  case "9":
       $pay_period = "16th Sep".' '.$y." – 15th Oct".' '.$y;
      break;
	  
	  case "10":
       $pay_period = "16th Oct".' '.$y." – 15th Nov".' '.$y;
      break;
	  
	  case "11":
       $pay_period = "16th Nov".' '.$y." – 15th Dec".' '.$y;
      break;
	  
	  case "12":
       $pay_period = "16th Dec".' '.$y." – 15th Jan".' '.$y;
      break;
	  
     default:
       $pay_period = $monthName .' '. $y ;
    }

	
	if($department != 0  && $candid_id == 0 )
	{
		$staff_sql=$con->query("SELECT * FROM staff_master where dep_id='$department'");
		// echo "<pre>";
		// echo "1."."SELECT * FROM staff_master where dep_id='$department'";	
		// echo "</pre>";	
	}
	else if($department == 0  && $candid_id != 0 )
	{
		//get employee details
		$staff_sql=$con->query("SELECT * FROM staff_master where candid_id = '$candid_id'");
		// echo "<pre>";
		// echo "2."."SELECT * FROM staff_master where candid_id = '$candid_id'";	
		// echo "</pre>";
		
	}
	else if($department != 0  && $candid_id != 0 )
	{
		$staff_sql=$con->query("SELECT * FROM staff_master where dep_id='$department' and candid_id = '$candid_id'");
		// echo "<pre>";
		// echo "3."."SELECT * FROM staff_master where dep_id='$department' and candid_id = '$candid_id'";	
		// echo "</pre>";
	}
	
	
	while($staff_sql_res=$staff_sql->fetch(PDO::FETCH_ASSOC))
	{

		$employee_id = $staff_sql_res['id'];
		$employee_prefix = $staff_sql_res['prefix_code'];
		$employee_code = $staff_sql_res['emp_code'];
		$emp_name = $staff_sql_res['emp_name'];
		$department_id = $staff_sql_res['dep_id'];
		$designation = $staff_sql_res['design_id'];
		$emp_id = $employee_prefix.$employee_code;
		$pan_no = $staff_sql_res['pan_number'];
		$pf_no = $staff_sql_res['pf_number'];
		$esi_no = $staff_sql_res['esic_number'];
		$uan_no = $staff_sql_res['uan_number'];
		$acc_number = $staff_sql_res['account_no'];
		$bank = $staff_sql_res['bank'];
		$loc = $staff_sql_res['payslip_location'];
		
		
					//echo "SELECT * FROM `bb_attendance` where emp_code='$employee_code' and dep_id='$department_id'";		

		
		//Designation		
		$des_sql=$con->query("SELECT designation_name FROM designation_master WHERE id='$department_id'");
		// echo "SELECT designation_name FROM designation_master WHERE id='$department_id'";
		$des_sql_res=$des_sql->fetch(PDO::FETCH_ASSOC);
		$designation_name = $des_sql_res['designation_name'];
		
		//Department		
		$dep_sql=$con->query("SELECT dept_name FROM z_department_master WHERE id='$department_id'");
		$dep_sql_res=$dep_sql->fetch(PDO::FETCH_ASSOC);
		$dep_name = $dep_sql_res['dept_name'];
		
		//DOJ 
		$doj_sql=$con->query("SELECT joining_date from candidate_form_details WHERE id='$candid_id'");
		$doj_sql_res=$doj_sql->fetch(PDO::FETCH_ASSOC);		
		$doj = $doj_sql_res['joining_date'];
		
		//Account details
		$acc_sql=$con->query("SELECT acc_number,ifsc,acc_holder_name FROM emp_personal_details where emp_id='$candid_id'");
		$acc_sql_res=$acc_sql->fetch(PDO::FETCH_ASSOC);		
		//$ac_number = $acc_sql_res['acc_number'];
		
		//Days of working		
		// Days of working (Dynamically summing up the rows from bb_attendance)
		$days_sql = $con->query("SELECT SUM(total_days) as total_no_of_days, SUM(working_days) as days_worked FROM bb_attendance WHERE emp_code='$employee_id' AND MONTH(in_log_date)='$m' AND YEAR(in_log_date)='$y'");
		
		$row_check = $days_sql->fetch(PDO::FETCH_ASSOC);
		
		// If attendance is empty or null, fallback to the original payroll table
		if($row_check['total_no_of_days'] == null) {
			$days_sql = $con->query("SELECT total_no_of_days,days_worked FROM payroll_salary_deduction where employee_code='$employee_id' and payroll_month='$m' and payroll_year='$y' and total_no_of_days is not null limit 0,1");
		} else {
			// Re-run the query to reset the pointer for the while loop below
			$days_sql = $con->query("SELECT SUM(total_days) as total_no_of_days, SUM(working_days) as days_worked FROM bb_attendance WHERE emp_code='$employee_id' AND MONTH(in_log_date)='$m' AND YEAR(in_log_date)='$y'");
		}
    // echo "SELECT total_no_of_days,days_worked FROM payroll_salary_deduction where employee_code='$employee_id' and payroll_month='$m' and payroll_year='$y' and total_no_of_days is not null limit 0,1";
    // echo "</pre>";
		
	//	echo "SELECT total_no_of_days,days_worked FROM payroll_salary_deduction where employee_code='$employee_id' and payroll_month='$m' and payroll_year='$y' and total_no_of_days is not null limit 0,1";
		       // Split the string by '–' to separate start and end dates
$dates = explode("–", $pay_period);

// Trim whitespace and convert date strings to standard format
$start_date_str = trim($dates[0]);
$end_date_str = trim($dates[1]);

// Convert date strings to standard format
$start_date = date("Y-m-d", strtotime($start_date_str));
$end_date = date("Y-m-d", strtotime($end_date_str));

		
		//$days_sql = $con->query("SELECT * FROM `bb_attendance` where emp_code='$employee_code' and dep_id='$department_id' ");//AND log_day BETWEEN '$start_date' AND '$end_date'

if($days_sql) 
{
	 if($days_sql->rowCount() > 0) 
	 {

while($days_sql_res = $days_sql->fetch(PDO::FETCH_ASSOC))
{			//echo "jojojojojojjojojojojojojojojojoj";

	if ($days_sql_res !='') {
		
		// BUG FIX: Calculate exact calendar days for the month instead of relying on DB sum
		$month_days = cal_days_in_month(CAL_GREGORIAN, $m, $y); 
		
		$work_days = $days_sql_res['days_worked'];//working days
		
	
		
	
	} 
  else {
		echo "<script>alert('Payslip Generation is Pending')</script>";
        echo "<script> window.location.href ='/qvision/index.php' </script>";
	}

}
		//Earnings		
		$earning_sql=$con->query("SELECT earnings,amount FROM payroll_salary_earnings WHERE payroll_month='$m' and payroll_year='$y' and employee_code='$employee_id' order by id asc");
		
		$earnings=array();
		$amount=array();

		while($earning_sql_res=$earning_sql->fetch(PDO::FETCH_ASSOC))
		{		
			$earnings[] = $earning_sql_res['earnings'];
			$amount[] = $earning_sql_res['amount'];
		}
		//$gross_salary = array_sum($amount);
	
	//Earned salary START
			$earned_sql=$con->query("SELECT earnings,amount FROM payroll_earned_salary WHERE payroll_month='$m' and payroll_year='$y' and  employee_code='$employee_id' order by id asc");
			
			$earned_amount=array();
			
			while($earned_sql_res=$earned_sql->fetch(PDO::FETCH_ASSOC))
			{	
				$earned_name = $earned_sql_res['earnings'];
				$earned_amount[$earned_sql_res['earnings']] = $earned_sql_res['amount'];
			}			
		    $gross_salary = array_sum($earned_amount); 	
		//Earned salary END
		
		
		
		//deductions		
		$earning_sql=$con->query("SELECT * FROM payroll_salary_deduction WHERE payroll_month='$m' and payroll_year='$y' and employee_code='$employee_id' order by id asc");
	
		$deduction=array();
		$ded_amount=array();
		
		while($earning_sql_res=$earning_sql->fetch(PDO::FETCH_ASSOC))
		{		
			$deduction[] = $earning_sql_res['deduction'];
			$ded_amount[$earning_sql_res['deduction']] = $earning_sql_res['amount'];
		}
		$deduction_total = array_sum($ded_amount);
		$number=$gross_salary-$deduction_total;
		?>

   <?php 
   // FETCH SALARY STRUCTURE
   $salstrcutre=$con->query("SELECT * FROM `joining_detail_sal_structure` where candid_id='$candid_id'");
   $getdetails=$salstrcutre->fetch(PDO::FETCH_ASSOC);

   // 🚨 BUG FIX: PHP FATAL ERROR CRASH PREVENTION 🚨
   // Convert all NULL or Empty values from Database into 0 to prevent math calculation crash. 
   if (!is_array($getdetails)) {
       $getdetails = [];
   }
   $getdetails['basic_month'] = floatval($getdetails['basic_month'] ?? 0);
   $getdetails['HRA_month'] = floatval($getdetails['HRA_month'] ?? 0);
   $getdetails['otherallowances_permonth'] = floatval($getdetails['otherallowances_permonth'] ?? 0);
   $getdetails['employee_PF_month'] = floatval($getdetails['employee_PF_month'] ?? 0);
   $getdetails['employee_ESIC_month'] = floatval($getdetails['employee_ESIC_month'] ?? 0);
   $getdetails['professionaltax_permonth'] = floatval($getdetails['professionaltax_permonth'] ?? 0);

   // PREVENT DIVISION BY ZERO ERROR
   if(empty($month_days) || $month_days <= 0) {
       $month_days = 1;
   }

   // DATE FORMAT FOR ARREAR PAY
   if($m<10) {
    $mmm='0'.$m;
    $arrmy=$y.'-'.$mmm;
   } else {
    $arrmy=$y.'-'.$m;
   }

   // ARREAR PAY FETCH
   $arrerpay=$con->query("SELECT remark,sum(amount) as arrearamt FROM `arrear_pay` WHERE emp_id='$candid_id' and payroll_month='$arrmy'");
   $arrdetails=$arrerpay->fetch(PDO::FETCH_ASSOC);
   
   // FIX: Prevent undefined variable crashes later in the table
   $reamrkofarrear = '';
   $arrearamt_get = 0;
   
   if($arrdetails) {
       $reamrkofarrear = $arrdetails['remark'] ?? '';
       $arrearamt_get = floatval($arrdetails['arrearamt'] ?? 0);
   }
   ?>
		<div class="col-md-12" style="text-align: end;">
	    <input class="button btn-danger" type="button" value="PRINT" onclick="printDiv()"> 
		</div>
		<div class="border container" id="main">
		<table class="logo_border" style="width: 100%;">
		<tr class="logo_border">
		<th class="logo_border" ><img src="/qvision/images/quadsel1.png" alt="Image"  style="width: 450px;height: 125px;"></th>
		<!-- <th class="logo_border" style="text-transform:uppercase;font-weight:800;font-size:18px;text-align: center;">SS Information Systems Pvt Ltd</th> -->
		</tr>
		</table>
		<hr style="width: 100%;">
		<div class="row">
		<div class="col-md-12">
		<h6 style="text-align:center;font-size: 18px;">Quadsel Tower Old No 80, New No 118 Anna Salai, Manickam Ln, Guindy, Chennai, Tamil Nadu 600032]</h6>
		
		<h6 style="text-align:center;font-weight:700;font-size: 18px;">Payroll for the Month of   <?php echo $pay_period; ?></h6>
		</div>
		
		</div>
		
	<br>
				<table class="remove_border" style="width:100%">
  <tr class="remove_border">
    <td class="left remove_border" style="font-weight:bold;"> Employee Name </td>
    <td class="left remove_border">:  <?php echo $emp_name;?></td>
    <td class="left remove_border" style="font-weight:bold;"> Date of Joined </td>
    <td class="left remove_border">:  <?php echo date('d/m/Y',strtotime($doj));?></td>
  </tr>
  
   <tr>
    <td class="left remove_border" style="font-weight:bold;"> Employee ID </td>
    <td class="left remove_border">:  <?php echo $emp_id;?></td>
    <td class="left remove_border" style="font-weight:bold;"> PAN Number </td>
    <td class="left remove_border">:  <?php echo $pan_no;?></td>
  </tr>
  
  <tr>
    <td class="left remove_border" style="font-weight:bold;"> Designation </td>
    <td class="left remove_border">:  <?php echo $designation_name;?></td>
    <td class="left remove_border" style="font-weight:bold;"> UAN Number </td>
    <td class="left remove_border">:  <?php echo $uan_no;?></td>
  </tr>
  
  <tr>
    <td class="left remove_border" style="font-weight:bold;"> Department </td>
    <td class="left remove_border">:  <?php echo $dep_name;?></td>
    <td class="left remove_border" style="font-weight:bold;"> ESIC Number </td>
    <td class="left remove_border">:  <?php echo $esi_no;?></td>
  </tr>
  
   <tr>
    <td class="left remove_border" style="font-weight:bold;"> Bank </td>
    <td class="left remove_border">:  <?php echo $bank;?></td>
    <td class="left remove_border" style="font-weight:bold;"> Bank Account Number </td>
    <td class="left remove_border">:  <?php echo $acc_number;?></td>
  </tr>
  
  <tr>
    <td class="left remove_border" style="font-weight:bold;"> PF Number </td>
    <td class="left remove_border">:  <?php echo $pf_no;?></td>
    <td class="left remove_border" style="font-weight:bold;"> Location </td>
    <td class="left remove_border">:  <?php echo $loc;?></td>
  </tr>
  
   <tr>
    <td class="left remove_border" style="font-weight:bold;"> Days Worked </td>
    <td class="left remove_border">:  <?php echo $work_days;?></td>
    <td class="left remove_border" style="font-weight:bold;"> Total Number of Days </td>
    <td class="left remove_border">:  <?php echo $month_days;?></td>
  </tr>
  
</table>
	<br>				
<style>
.logo_border{
	border: 0px solid black !important;
}
.remove_border{
	border: 0px solid black !important;
}
.left{
	text-align: start !important;
}
.right{
	text-align: end !important;
}
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  padding: 5px;
  text-align: center;    
}
</style>
 <table style="width:100%">
  <tr>
    <th colspan="2">Earnings</th>
    <th colspan="2">Deductions</th>
    <th colspan="2">Arrear_pay</th>
  </tr>
<?php 
if($month_days>$work_days)
{
?>
  <tr>
    <td class="left">Basic & DA </td>
    <td class="right">
	<?php
	   $salacalc=$getdetails['basic_month']/$month_days;
	   $basicdasal=$salacalc*$work_days;
		echo round($basicdasal,2);
		
		?></td> 
<?php
}
else
{
?>
 <tr>
    <td class="left">Basic & DA </td>
    <td class="right">
	<?php
	$basicdasal=$getdetails['basic_month'];
		echo round($basicdasal,2);
		
		?></td> 
<?php
}
?>

    <td class="left">PF Employee </td>
    <td class="right"><?php 
	if ($month_days > $work_days) {
    $salacalc = $getdetails['basic_month'] / $month_days;
    $basicdasal = $salacalc * $work_days;
    $finalbasic = round($basicdasal, 2); // basic+DA

    $oacalc = $getdetails['otherallowances_permonth'] / $month_days;
    $otherallowance = $oacalc * $work_days;
    $finaloa = round($otherallowance, 2); // Other allowance
} else {
    $basicdasal = $getdetails['basic_month'];
    $finalbasic = round($basicdasal, 2); // basic+DA

    $otherallowance = $getdetails['otherallowances_permonth'];
    $finaloa = round($otherallowance, 2); // Other allowance
}

$pfcalc = $finalbasic + $finaloa;
$defaultpf = 1800;
if ($pfcalc > 15000) {
    $pfamount = $defaultpf;
} else {
    //$work_days1 = 12;
    if ($work_days < 15) {
        $pfcal = $defaultpf / $month_days;
        $pfemp = $pfcal * $work_days;
        $pfamount = round($pfemp, 2);
    } else {
        $pfamount = $getdetails['employee_PF_month'];
    }
}

// Output the calculated $pfamount
echo $pfamount;


	?></td>
  <?php
  if($reamrkofarrear)
  {
    ?>
  <td><?php echo $reamrkofarrear;?></td>
  <td><?php echo $arrearamt_get;?></td>
  <?php
  }
  else{
    ?>
    <td><?php echo 'NULL';?></td>
  <td><?php echo 0;?></td>
    <?php
    }?>
  </tr>
  

   <tr>
   <?php
   if($month_days>$work_days)
   {
	   ?>
    <td class="left">HRA</td>
    <td class="right">
	<?php 
	  $hraamountcalc=$getdetails['HRA_month']/$month_days;
	  $HRA=$hraamountcalc*$work_days;
	
	     echo round($HRA,2);

 		 
		 ?></td>
		 <?php
   }
   else 
   {
  ?>
  <td class="left">HRA</td>
    <td class="right">
	<?php 
	       $HRA=$getdetails['HRA_month'];
	     echo round($HRA,2);

		 ?></td>
  <?php 
   }
  ?>
    <td class="left">ESIC Employee</td>
    <td class="right"><?php	
	
	 $gross_salary=$basicdasal+$HRA+$otherallowance;
	// echo$basicdasal.'kokookiiiiiiiiiiiii'.$HRA.''.$otherallowance; 
  $gross_salary = $basicdasal + $HRA + $otherallowance;
$esicamount = 0; // Initialize esicamount to 0 by default.

if ($gross_salary <= 21000) {
    $esicamount = $getdetails['employee_ESIC_month'];
}

// Output the calculated $esicamount
echo $esicamount;
	
	?></td>
  </tr>

   <tr>
     <?php
if($month_days>$work_days)
{
?>
    <td class="left">Other Allowance</td>
    <td class="right">
	<?php 
	$oacalc=$getdetails['otherallowances_permonth']/$month_days;
	$otherallowance=$oacalc*$work_days;
     echo round($otherallowance,2); 	
	
		?> 
		</td>
<?php 		
}
else
{
?>
 <td class="left">Other Allowance</td>
    <td class="right">
	<?php 
	$otherallowance=$getdetails['otherallowances_permonth'];
     echo round($otherallowance,2); 	
	
		?> 
		</td>
<?php
}
?>
		<td class="left">Professional Tax</td>
    <td class="right">
	<?php 
     echo round($getdetails['professionaltax_permonth'],2); 	
	
		?> 
		</td>
   
  </tr>

  
  
  

  <tr>
    <td class="left" style="font-weight:bold;">Total Earning</td>
	<?php 
	
	$gross_salary=$basicdasal+$HRA+$otherallowance;
	?>
    <td class="right" style="font-weight:bold;"><?php echo number_format($gross_salary,2) ;?></td>
	
	<?php 
		$deduction_total=$pfamount+$esicamount+$getdetails['professionaltax_permonth'];

	?>
    <td class="left" style="font-weight:bold;">Total Deduction</td>
    <td class="right" style="font-weight:bold;"><?php echo number_format($deduction_total,2);?></td>

    <td>Arrear_total</td>
    <td><?php 
    if($arrearamt_get){
    
    echo $arrearamt_get;
    }
    else
    {
      echo 0;
    }?></td>
  </tr>
  
   <tr>
    <td colspan='3' style="font-weight:bold;"  class="left">NET Salary</td>
	<?php 
	$number=$gross_salary-$deduction_total + $arrearamt_get;
	?>
    <td colspan='1' style="font-weight:bold;" class="right"><?php echo number_format($number,2) ;?></td>
  </tr>

 
</table>           
<br> 
				<?php /* number to string conversion Starts */

	
   $no = round($number);
   
   $point = round($number - $no, 2) * 100;
   $hundred = null;
   $digits_1 = strlen($no);
   $i = 0;
   $str = array();
   $words = array('0' => 'zero', '1' => 'one', '2' => 'two',
    '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
    '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
    '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
    '13' => 'Thirteen', '14' => 'Fourteen',
    '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
    '18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
    '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
    '60' => 'Sixty', '70' => 'Seventy',
    '80' => 'Eighty', '90' => 'Ninety');
   $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
   while ($i < $digits_1) {
     $divider = ($i == 2) ? 10 : 100;
     $number = floor($no % $divider);
     $no = floor($no / $divider);
     $i += ($divider == 10) ? 1 : 2;
     if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
        $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
     } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);
 $sal_point = abs($point);
    $points = ($sal_point) ? " " . $words[intval($sal_point / 10) * 10] . " " . $words[$sal_point % 10] : '';
    
  $string_amount='';

  $pointValue = ($points) ? $points."  Paise  " : " ";
   $string_amount=$result . "Rupees  " . $pointValue . "only";
   
		/* number to string conversion Ends*/
		
		?>
				<div class="row">
                <div class="col-md-12">
				<span class="fw-bold" style="font-weight:bold;"><?php echo $string_amount ?></span> 
				<br>
				<span>This is a computer generated statement and does not require any signature.</span> 
				</div>
            </div>
</div>
<?php
	 }
	 else
	 {
		?>
		<label style="font-size:25px;text-align:center;font-weight:500;color:red;">You Not Upload Attendace For This Candidate!...</label>
<?php		
	 }
}
	}
?>
  <script>
        function printDiv() {
            var divContents = document.getElementById("main").innerHTML;
            var a = window.open('', '', 'height=1000, width=1500');
            a.document.write('<html>');
            //a.document.write('<body > <h1>Div contents are <br>');
            a.document.write(divContents);
            a.document.write('</body></html>');
            a.document.close();
            a.print();
			a.close();
        }
		
		
	// <!-- $(document).ready(function(){ -->
	// 	<!-- let lop = <?php if(array_key_exists("Loss Of Pay",$ded_amount)) ?> -->
	// <!-- }) -->
    </script>
</body>
</html>