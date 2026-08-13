<?php
require '../../../connect.php';

    $department=$_REQUEST['department'];
    $division=$_REQUEST['division']; // BUG FIX: Front-end la irundhu division id-ah inga vangukirom
    $designation_name=$_REQUEST['designation_name'];
    $status=$_REQUEST['status'];
    $userrole=$_REQUEST['userrole'];
    
    // BUG FIX: INSERT query-la 'div_id' column-ayum, '$division' value-ayum add pannirukom
    $sql=$con->query("insert into designation_master(dep_id, div_id, designation_name, status, created_by, created_on, modified_by, modified_on)values('$department', '$division', '$designation_name', '$status', '2', now(), '2', now())");
    
    // Neenga sonna mariye intha 2nd query-la entha changes-um pannala, apdiye vachiruken
    $sql1=$con->query("insert into jobdescription_master(`id`, `tittle`, `status`, `created_by`, `created_on`, `modified_by`, `modified_on`)values(NULL,'$designation_name','$status','2',now(),now(),NULL)");
	
    //echo "insert into jobdescription_master(`id`, `tittle`, `status`, `created_by`, `created_on`, `modified_by`, `modified_on`)values(NULL,'$designation_name','$status','2',now(),now(),NULL)";
	/* echo "insert into designation_master(dep_id, div_id, designation_name, status, created_by, created_on, modified_by, modified_on)values('$department', '$division', '$designation_name', '$status', '2', now(), '2', now())"; */
    
if($sql!='' && $sql1!='')
{
	echo "1";
}

?>