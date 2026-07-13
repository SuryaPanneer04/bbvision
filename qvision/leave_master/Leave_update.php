<?php

require '../../connect.php';
$ids=$_REQUEST['ids'];
$Leave=$_REQUEST['Leave'];
$no_of_days=$_REQUEST['no_of_days'];
$status="0";
 

$statement = $con->query("UPDATE master_leave set status=0 WHERE id='$ids'");




if($statement)
{
	0;
}
else
{
	1;
}

?>