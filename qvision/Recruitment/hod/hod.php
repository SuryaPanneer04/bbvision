<?php
require '../../../connect.php';
include("../../../user.php");
$userrole = isset($_SESSION['userrole']) ? $_SESSION['userrole'] : '';
?>
<style>
#page-wrapper{
	margin-left: 117px !important;
}
.btn-warning{
	padding-top: 0px !important;
}

.btn-warning{
	background-color: #337ab7 !important;
    border-color: #337ab7 !important;
}
.btn-success{
	background-color: #5cb85c !important;
    border-color: #5cb85c !important;
}
.page-header{
	border-bottom: 3px solid #eee !important;
}
.btn-primary{
	background-color: #ed5d00;
    border-color: #ed5d00;
}
.card-primary:not(.card-outline)>.card-header{
	background-color: #f1cc61 !important;
}
.btn-danger{
	background-color: #ed5d00;
    border-color: #ed5d00;
}
.card-primary:not(.card-outline)>.card-header a {
	color: black;
}
</style>



  <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title" style="color:black !important;"><font size="5">HOD LIST</font></h3>
		<a onclick=" add_hod()" style="float: right;" data-toggle="modal" class="btn btn-danger">ADD</a>
              </div>
			  
			  <br>
			  
<div>
<div class="container-fluid">

   <div class="panel-body">
      <div class="table-responsive">
       <table class="dataTables-example table table-striped table-bordered table-hover"  id="example1">
		 
   
    <thead>
      <th>Id</th>
	  <th>Department</th>
	  <th>Employee Name</th>
	  <th>Mail Id</th>
	  <th>Assest</th>
      <th>Others</th>
	  <th>Action</th>
      </thead>
   <tbody>

      <!--th>Tools</th-->
      <?php
     // $emp_sql=$con->query("SELECT sm.dep_id,sm.emp_name,h.asset,h.mail_id,h.others,h.id AS hid FROM hod h join staff_master sm on h.emp_name=sm.id");
$emp_sql=$con->query("SELECT candidate_form_details.mail,assets_master.name,z_department_master.dept_name,sm.dep_id,sm.emp_name,h.asset,h.mail_id,h.others,h.id AS hid FROM hod h 
INNER join staff_master sm on h.emp_name=sm.candid_id
INNER JOIN  z_department_master ON sm.dep_id =  z_department_master.id
INNER JOIN  assets_master ON h.asset =  assets_master.id
INNER JOIN  candidate_form_details ON sm.candid_id =  candidate_form_details.id");
	  
	 //echo "SELECT sm.emp_name,s.stationaries,s.system_or_laptop,s.id_card,s.cug,s.access_card,s.erp_access,s.mail_id,s.id AS sid FROM staff_asset s join staff_master sm on s.emp_name=sm.id";
      $i=1;
      while($emp_res = $emp_sql->fetch(PDO::FETCH_ASSOC))
      {
		  $assid=$emp_res['asset'];
		  $dep_sql=$con->query("SELECT asset as assestname FROM staff_asset_master where id='$assid'");
		$dep_sql_res=$dep_sql->fetch(PDO::FETCH_ASSOC);
       ?>
      <tr>
      <td><?php echo $i; ?></td>
	  <td><?php echo $emp_res['dept_name']; ?></td>
      <td><?php echo $emp_res['emp_name']; ?></td>
	        
		    <td><?php echo $emp_res['mail']; ?></td>
			<td><?php echo $dep_sql_res ? $dep_sql_res['assestname'] : ''; ?></td>
	        <td><?php echo $emp_res['others']; ?></td>
      <td>
	  <button class="btn btn-success btn-sm edit btn-flat" data-id="<?php echo $emp_res['hid']; ?>" onclick="staff_asset_edit(<?php echo $emp_res['hid']; ?>)"><i class="fa fa-edit"></i> Edit</button>
	  </td>
      </tr>
      <?php
	  $i++;
      }
      ?>
      </tbody>
      </table>
	 
      </div>
<!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->

<!-- /.content -->
</div>
</div>
</div>
<script>
            $(document).ready(function() {
                $('.dataTables-example').DataTable({
                        responsive: true
                });
            });
        </script>
<script>
		function add_hod()
    {
    $.ajax({
    type:"POST",
    url:"qvision/Recruitment/hod/new_hod.php",
    success:function(data){
    $("#main_content").html(data);
    }
    })
  }
  function staff_asset_edit(v)
    {
    $.ajax({
    type:"POST",
    url:"qvision/Recruitment/hod/edit_hod.php?id="+v,
    success:function(data){
    $("#main_content").html(data);
    }
    })
  }
  
   
</script>