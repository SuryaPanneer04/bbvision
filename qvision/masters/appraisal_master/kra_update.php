<?php
require '../../../connect.php';
	
$lineid=$_REQUEST['id'];
$count=$_REQUEST['count'];
$count_name_count= count($count);

 $sql=$con->query("update appraisal_master set status= 1 where id='$lineid'");
  echo "update appraisal_master set status= 1 where id='$lineid'";

for($i=0;$i<$count_name_count;$i++)
{ 
 $get_id=$_REQUEST['get_id'.$i];

 $sql=$con->query("update appraisal_question set status=1 where id='$get_id'");
  echo "update appraisal_question set status=1 where id='$get_id'";
}

?>