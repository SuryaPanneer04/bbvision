<?php
require '../../../connect.php';
include("../../../user.php");
$userrole = $_SESSION['userrole'];

$reqid = $_REQUEST['reqid'];
$cugsta = isset($_REQUEST['cugsta']) ? $_REQUEST['cugsta'] : '';
$simid = isset($_REQUEST['simid']) ? $_REQUEST['simid'] : '';
$assets = isset($_REQUEST['View']) ? $_REQUEST['View'] : [];

$staff_sql = $con->query("SELECT staff_id FROM staff_access_request WHERE id='$reqid'");
if($staff_sql) {
    $staff_row = $staff_sql->fetch(PDO::FETCH_ASSOC);
    $staffid = $staff_row['staff_id'];
    
    if(!empty($assets) && !empty($staffid)) {
        $count = count($assets);
        for($i=0; $i<$count; $i++) {
            $assetid = $assets[$i];
            
            $upd = $con->query("UPDATE staff_asset_list SET status=3 WHERE staff_id='$staffid' AND asset_id='$assetid'");
            
            $asset_form = $con->query("UPDATE assets_form_detail SET status=1 WHERE id='$assetid'");
        }
        
        $con->query("UPDATE staff_access_request SET status=4 WHERE id='$reqid'");
    }
}

if(isset($asset_form) && $asset_form)
{
	echo "<script>alert('Asset Collected Successfully!');</script>";
	header("location:../../../index.php");
}
?>