<?php
require '../../connect.php';
?>
<head>
    <link rel="stylesheet" href="Qvision\commonstyle.css">
</head>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><font size="5">EMPLOYEE LIST</font></h3>
        <a onclick="return add_employee()" style="float: right;" data-toggle="modal" class="btn">ADD</a>
    </div>
    <div class="card-body">
    <table class="table table-striped table-bordered table-hover display nowrap" id="example1" style="width:100%">
    <thead>
      <th>S.No</th>
      <th>Question Name</th>
      <th>Company Name</th>
      <th>Department</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>DOB</th>
     <th>Address </th>
	<!--th>Status</th-->
	<th>Action</th>
      </thead>
      <tbody>
      <?php
      $questions=$con->query("SELECT *,e.id as eid,e.status as estatus FROM `emp_assessment_login_detail` e join company_master c on e.company_name=c.id join z_department_master d on e.department=d.id left join question_name_master q on e.qn_name_id=q.id");
     $cnt=1;

  
      while($answer_keys = $questions->fetch(PDO::FETCH_ASSOC))
    //        print_r($answer_keys);
    //  die();

      {
     
      ?>
      <tr>
	  <td><?php echo $cnt;?>.</td>
      <td><?php echo $answer_keys['name']; ?></td>
      <td><?php echo $answer_keys['companyname']; ?></td>
      <td><?php echo $answer_keys['dept_name']; ?></td>
      <td><?php echo $answer_keys['first_name']; ?></td>
      <td><?php echo $answer_keys['last_name']; ?></td>
      <td><?php echo $answer_keys['dob']; ?></td>
      <td><?php echo $answer_keys['address']; ?></td>
	  
	 <!--td>
	  <!?php 
	  if($answer_keys['estatus'] ==1)
	  {
		  
	  echo '<span style="color:green;text-align:center;"><b>Active</b></span>';
	  ?>
	  <!?php }else {
		  
		 echo '<span style="color:red;text-align:center;"><b>INActive</b></span>';
		 ?>
      <!?php }?>
	 
	  
     </td-->
     <td>				
		<button class="btn btn-success btn-sm edit btn-flat" data-id="<?php echo $answer_keys['eid']; ?>" onclick="ctc_edit(<?php echo $answer_keys['eid']; ?>)"><i class="fa fa-edit"></i> Edit</button>
	</td>
      </tr>
      <?php
	  $cnt=$cnt+1;
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
	 function add_employee()
    {
    $.ajax({
    type:"POST",
    url:"qvision/assessment_candidate/candidate_form.php",
    success:function(data){
    // $(".content").html(data);
     $("#main_content").html(data);
    }
    })
  }
  function ctc_edit(v){
	$.ajax({
	type:"POST",
	url:"qvision/assessment_candidate/candidate_edit.php?id="+v,
	success:function(data)
	{
		// $(".content").html(data);
     $("#main_content").html(data);
	}
	})
}
</script>