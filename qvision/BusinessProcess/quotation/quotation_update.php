<?php
require '../../../connect.php';
require '../../../user.php';
$user_id =$_SESSION['userid'];
echo $quote_no_old =$_REQUEST['quote_no'];
/*  $max_quote ="SELECT * FROM quotation_entry ORDER BY id DESC";
 $query = $con->query($max_quote);
 $number = $query->fetch_assoc();


 if (!empty($number['quote_no'])) {
	
    print_r($splite_val = explode("-",$number['quote_no'])); 	
	echo $no   =  $splite_val [0];
	echo $char =  $splite_val [1];
	
  // $result = preg_split('/[-_]/', $number);
  $find_f = substr($number['quote_no'], 0, 7);
  $find_fs = substr($number['quote_no'], 0, 4);
  // echo "<pre>";  print_r($find_f);  exit;
  if($find_f=="QUAD626"){
    $last_bill_no = substr($number['Case_Number'], -8);
    
  }
  
  
   $quote1= ++$no;
   $quote2= ++$char;
   
   $case_number=$quote1 .$quote1;
      }else{
			$d = '1001-Z';
			for ($n=0; $n<26; $n++) {
			echo ++$d . PHP_EOL;
			}

      }
 */

/* $d = '1001-Z';
for ($n=0; $n<26; $n++) {
    echo ++$d . PHP_EOL;
} */
//Quote No Generated  Here
$row_query = "SELECT * FROM quotation_entry ";

 $query = $con->query($row_query);
 $query->execute();
 $count = $query->rowCount();

 $row_val = $query->fetch();
 
	 
$row_query = "SELECT * FROM quotation_entry where quote_no='$quote_no_old' and status='1' and flag='1'";
//echo $row_query;
 $query2 = $con->query($row_query);
 $query2->execute();
 $count = $query2->rowCount();
 $row = $query2->fetch();
 //echo $row['quote_no'];
	 if (!empty($row['quote_no'])) {
		
		$splite_val = explode("/",$row['quote_no']); 	
		 $no   =  $splite_val [0];
		 $char =  $splite_val [1];
	     $quote2= ++$char;
	  // $result = preg_split('/[-_]/', $number);
	  $find_f = substr($row['quote_no'], 0, 7);
	 $find_fs = substr($row['quote_no'], 7, 5);
	  
	 // echo  $a = sprintf("%05d", $find_fs);echo "<br/>";
	  $final_quote_no = str_pad($find_fs + 1, 5, 0, STR_PAD_LEFT);echo "<br/>";
	  //echo $last_quote_no = $find_fs;echo "<br/>";
	 //echo  $final_quote_no = ++$final_no;echo "<br/>";
     echo $QUOTE_NO = $no.'/'.$quote2;
	 } 


$specification = $_REQUEST['item'];
 $row_count   = count($specification);
$qty         = $_REQUEST['qty'];
$unit        = $_REQUEST['unit'];
$unit_rate   = $_REQUEST['cost'];
$total       = $_REQUEST['price'];
$gst         = $_REQUEST['gst'];

$client_id      = $_REQUEST['client_id'];
$company_id     = $_REQUEST['company_id'];
$enquiry_id     = $_REQUEST['enquiry_id'];
$revise_date_str     = $_REQUEST['revise_date'];

 $revise_date = date('Y-m-d', strtotime($revise_date_str));


$quote_type    = $_REQUEST['quote_type'];
$business_id   = $_REQUEST['mapping_id'];
$candid_id     = $_REQUEST['candid_id'];
$vendor_id     = $_REQUEST['vendor_id'];

 for($i=0;$i<$row_count;$i++)
{
	
 $specifications = $specification[$i];
 $qtys           = $qty[$i];
 $units          = $unit[$i];
 $unit_rates     = $unit_rate[$i];
 $totals         = $total[$i];

  $insert_query=$con->query("insert into  quotation_entry(quote_no,specification,qty,unit,unit_rate,amount,gst_percentage,enquiry_id,company_id,client_id,quote_type,business_id,vendor_id,candid_id,revise_date,status,modified_by,modified_on) values('$QUOTE_NO','$specifications','$qtys','$units','$unit_rates','$totals','$gst','$enquiry_id','$company_id','$client_id','$quote_type','$business_id','$vendor_id','$candid_id','$revise_date','1','$user_id',NOW())");  
  
  $update_query =$con->query("update quotation_entry set status ='2',flag ='2' where quote_no= '$quote_no_old'");
 
}





?>






