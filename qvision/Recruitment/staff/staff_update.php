<?php 
require '../../../connect.php';
require '../../../user.php';
$user=$_SESSION['userid'];
 $candidid=$_REQUEST['cid'];
  $cname=$_REQUEST['cname'];
  $ccode=$_REQUEST['ccode'];
  $exploeepcode=explode('**',$ccode);
  $prefix_code=$exploeepcode[0];
  $emp_code=$exploeepcode[1];
  $deprt=$_REQUEST['deprt'];
  $div=$_REQUEST['div'];
  $desig=$_REQUEST['desig'];
  $reporting=$_REQUEST['reporting'];
  //$site=$_REQUEST['site'];
  //$location=$_REQUEST['location'];
  $head_status=$_REQUEST['head_status'];
  $status=$_REQUEST['status'];
  $date=date('Y-m-d');
  //$update=$con->query("update staff_master set emp_name='$cname', dep_id='$deprt', div_id='$div', design_id='$desig',reporting_person='$reporting',site='$site',location='$location',head_status='$head_status',status='$status',modified_by='$user',modified_on='$date' where candid_id='$candidid'");
  ////ate=$con->query("update staff_master set emp_name='$cname', dep_id='$deprt', div_id='$div', design_id='$desig',reporting_person='$reporting',head_status='$head_status',status='$status',modified_by='$user',modified_on='$date' where candid_id='$candidid'");
  /////////pdate staff_master set prefix_code='$prefix_code',emp_code='$emp_code',emp_name='$cname', dep_id='$deprt', div_id='$div', design_id='$desig',reporting_person='$reporting',head_status='$head_status',status='$status',modified_by='$user',modified_on='$date' where candid_id='$candidid'";
  /////$pdate;
  /* echo "update staff_master set emp_name='$cname', dep_id='$deprt', div_id='$div', design_id='$desig',reporting_person='$reporting',site='$site',location='$location',head_status='$head_status',status='$status',modified_by='$user',modified_on='$date' where candid_id='$candidid'"; */
  /* echo "update staff_master set emp_name='$cname', dep_id='$deprt', div_id='$div', design_id='$desig',reporting_person='$reporting',head_status='$head_status',modified_by='$user',modified_on='$date' where candid_id='$candidid'"; */
  /* echo "update staff_master set emp_name='$cname', dep_id='$deprt', div_id='$div', design_id='$desig' where candid_id='$candidid',modified_by='$user',modified_on='$date'"; */
  $update=$con->query("update staff_master set prefix_code='$prefix_code',emp_code='$emp_code',emp_name='$cname', dep_id='$deprt', div_id='$div', design_id='$desig',reporting_person='$reporting',head_status='$head_status',status='$status',modified_by='$user',modified_on='$date' where id='$candidid'");
  if($update)
  {
	  echo 0;
  }
?>