<!--
initial status = 0 is before OD approve;
After approve status= 1;
till view done to do approve for OD
-->

<?php
require '../../connect.php';
include '../../user.php';
  $userrole=$_SESSION['userrole'];
 $candid_id=$_SESSION['candidateid'];
//echo $userrole;
?>
<head>
    <!-- <link rel="stylesheet" href="Qvision\commonstyle.css"> -->
    </head>
<?php 

?>
		   <div  class="card card-primary">
              <div class="card-header" style="background-color:#ff8b3d;">
                <h3 class="card-title"><font size="5">CLAIM REQUEST</font></h3>
			
                <a onclick="return add_od()"  style="float: right;    background-color: #ff8b3d;" data-toggle="modal" class="btn btn-primary"><i class="fa fa-plus"></i>ADD</a>
              </div>
              <div class="card-body">
       <table class="table table-bordered display nowrap"  id="example1" style="width:100%">

   
    <thead>
      <th>S.No</th>
      <th>Emp Code</th>
      <th>Emp Name</th>
      <th>Date </th>
      <th>Customer Name</th>
      <th>Location</th>
      <th>Purpose</th>
	  <th>Status</th>
	   
      <th>Action</th> 
      <th>View</th>
      </thead>
      <tbody>
      <?php
	  if($userrole == 'R016') {
	  
	    $holiday = $con->query("SELECT a.candidate_id as candidate_id,b.emp_code as emp_code,b.emp_name as emp_name,a.date as date,a.customer_name as customer_name,a.location as c_loc,a.purpose as purpose,a.id as mid,a.location as c_loc,a.status as status FROM claim_request a JOIN z_user_master b on a.candidate_id=b.candidate_id where a.status='2' or a.status=1");
		
	
        $cnt = 1;
		
     while ($holiday_masterr = $holiday->fetch(PDO::FETCH_ASSOC)) {
			$status = $holiday_masterr['status'];
			
				
      ?>
	  
       <tr>
        <td><?php echo $cnt; ?></td>
        <td><?php echo $holiday_masterr['emp_code']; ?></td>
        <td><?php echo $holiday_masterr['emp_name']; ?></td>
        <td><?php echo $holiday_masterr['date']; ?></td>
        <td><?php echo $holiday_masterr['customer_name'];?></td>
        <td><?php echo $holiday_masterr['c_loc']; ?></td>
        <td><?php echo $holiday_masterr['purpose']; ?></td>
	<td>	<?php 
	  if($holiday_masterr['status'] == '1')
	  {
		  
	  echo '<span style="color:red;text-align:center;"><b>Request Pending</b></span>';
	  ?>
	  <?php }
	   elseif($holiday_masterr['status'] == '2')
	  {
		  
	  echo '<span style="color:brown;text-align:center;"><b>Request Approved by HOD and Waiting for Purchase Approval</b></span>';
	  ?>
	   <?php } elseif($holiday_masterr['status'] == '3')
	  {
		  
	  echo '<span style="color:green;text-align:center;"><b>Request Approved by HOD and Purchase Head</b></span>';
	  ?>
	   <?php }elseif($holiday_masterr['status'] == '4')
	  {
		  
	  echo '<span style="color:green;text-align:center;"><b>Request Rejected</b></span>';
	  }?></td>
        <td><?php 
	  if($holiday_masterr['candidate_id'] ==210)
	  { ?>	
         <button class="btn btn-success btn-sm edit btn-flat" data-id="<?php echo $holiday_masterr['mid']; ?>"  onclick="od_edit(<?php echo $holiday_masterr['mid']; ?>)"><i class="fa fa-edit"></i> Edit</button>
	  <?php } else{
	   ?>
        </td><td>				
         <button class="btn btn-success btn-sm view btn-flat" data-id="<?php echo $holiday_masterr['mid']; ?>"  onclick="od_view(<?php echo $holiday_masterr['mid']; ?>)"><i class="fa fa-eye"></i> View</button>
		 
        </td>
    </tr>
	
		<?php }
            $cnt = $cnt + 1;
			
	  
}
  }else{

	    $holiday = $con->query("SELECT * FROM `claim_request`  where candidate_id='$candid_id' ORDER BY `id` DESC");
		
	
        $cnt = 1;
		
     while ($holiday_masterr = $holiday->fetch(PDO::FETCH_ASSOC)) {
			$status = $holiday_masterr['status'];
			
			$getempdcoe=$con->query("SELECT * FROM `z_user_master` where candidate_id='$candid_id'");
			//echo "SELECT * FROM `z_user_master` where candidate_id='$candid_id'";
			$employiecode = $getempdcoe->fetch(PDO::FETCH_ASSOC);
			
			$iddd=$employiecode['user_id'];
			$showempcode=$con->query("SELECT * FROM `staff_master` where candid_id='$iddd'");
			//echo "SELECT * FROM `staff_master` where candid_id='$iddd'";
			$showemmmpcode = $showempcode->fetch(PDO::FETCH_ASSOC);
      ?>
	  
       <tr>
        <td><?php echo $cnt; ?></td>
        <td><?php echo $showemmmpcode['emp_code']; ?></td>
        <td><?php echo $employiecode['full_name']; ?></td>
        <td><?php echo $holiday_masterr['date']; ?></td>
        <td><?php echo $holiday_masterr['customer_name'];?></td>
        <td><?php echo $holiday_masterr['location']; ?></td>
        <td><?php echo $holiday_masterr['purpose']; ?></td>
	<td>	<?php 
	  if($holiday_masterr['status'] == '1')
	  {
		  
	  echo '<span style="color:red;text-align:center;"><b>Request Pending</b></span>';
	  ?>
	  <?php }
	   elseif($holiday_masterr['status'] == '2')
	  {
		  
	  echo '<span style="color:green;text-align:center;"><b>Request Approved by  Finance Department</b></span>';
	  ?>
	   <?php } elseif($holiday_masterr['status'] == '3')
	  {
		  
	  echo '<span style="color:green;text-align:center;"><b>Request Approved by HOD and Finance Head</b></span>';
	  ?>
	   <?php }elseif($holiday_masterr['status'] == '4')
	  {
		  
	  echo '<span style="color:red;text-align:center;"><b>Request Rejected</b></span>';
	  }?></td>
        <td><?php 
	
	 
		 
		  if($holiday_masterr['status']==1){
		  ?>	
         <button class="btn btn-success btn-sm edit btn-flat" data-id="<?php echo $holiday_masterr['id']; ?>"  onclick="od_edit(<?php echo $holiday_masterr['id']; ?>)"><i class="fa fa-edit"></i> Edit</button>
		  <?php 
		  }			  
	   ?>
        </td>
		<?php
		
			
			?>
    </tr>
	
		<?php 
            $cnt = $cnt + 1;
			
	  
}
  }  
	  

      ?>
      </tbody>
      </table>
	 
</div>
</div>


<script>
$(document).ready(function() {
    $('#example1').DataTable( {
        "scrollX": true
    } );
} );
</script>

<script>
        function add_od()
        {
            $.ajax({
                type: "POST",
                url:  "qvision/claim/od_add.php",
                success: function (data) {
                    $("#main_content").html(data);
                }
            })
        }
        function od_edit(v) {
            $.ajax({
                type: "POST",
                url: "qvision/claim/od_edit.php?id="+v,
                success: function (data)
                {
                    $("#main_content").html(data);
                }
            })
        }
		  function od_view(v) {
			  
			  
			  $.ajax({
                type: "POST",
                url: "qvision/claim/od_view.php?id="+v,
                success: function (data)
                {
                    $("#main_content").html(data);
                }
            })
           
        }
    </script>