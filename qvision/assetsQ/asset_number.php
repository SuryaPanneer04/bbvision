<?php 
require '../../connect.php';
$asset_id=$_REQUEST['id'];
$asset=$_REQUEST['asset'];
$asset_type=$_REQUEST['asset_type'];

// First get the prefix from master table
$asset_query=$con->query("select * from assets_master where id='$asset_id'");
$asfet=$asset_query->fetch();
$prefix=$asfet['prefix_code'];

// Now search using the 'prefix' column instead of asset_name ID, and order by the highest asset_no
$sql=$con->query("select * from assets_form_detail where prefix='$prefix' order by CAST(asset_no AS UNSIGNED) desc limit 1");
$cou=$sql->rowCount();

if($cou==0)
{	
    $no=$prefix."-".'0001';	
    echo $no;
}
else
{
    $sqlfet=$sql->fetch();
    $asset_no=$sqlfet['asset_no'];
    $num=$asset_no+1;
    $len=strlen($num);
    
    if($len==1)
    {
        echo $no=$prefix."-".'000'.$num;
    }
    elseif($len==2)
    {
        echo $no=$prefix."-".'00'.$num;
    }
    elseif($len==3)
    {
        echo $no=$prefix."-".'0'.$num;
    }
    elseif($len==4)
    {
        echo $no=$prefix."-".$num;
    }
}
?>