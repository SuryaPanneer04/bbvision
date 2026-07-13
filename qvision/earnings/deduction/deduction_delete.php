<?php
require '../../../connect.php';

$id=$_REQUEST['deduct_id'];
$deduct_id = implode(',',$id); 

$deduction_delete_sql = "DELETE FROM salary_monthly_deduction WHERE id in ($deduct_id)";
$deduction_delete = $con->query($deduction_delete_sql);


?>