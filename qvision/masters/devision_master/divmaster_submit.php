<?php
require '../../../connect.php';

if(isset($_REQUEST['submit']))
{
	$department=$_REQUEST['department'];
	$div_name=$_REQUEST['div_name'];
	$status=$_REQUEST['status'];
	
    // Insert Query
	$sql=$con->query("insert into division_master(dep_id,div_name,status,created_by,created_on,modified_by,modified_on)values('$department','$div_name','$status','2',now(),'2',now())");
	
    // Query run aanathum Alert & Redirect
	if($sql)
	{
		echo "<script>
                alert('New Division added successfully!');
                window.location.href = '/bbvision/index.php'; 
              </script>";
	}
}
?>