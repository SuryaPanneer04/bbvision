<?php
require '../../connect.php';
include("../../user.php");
$userrole=$_SESSION['userrole'];
?>
<head>
    <link rel="stylesheet" href="Qvision\commonstyle.css">
</head>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><font size="5">QUESTION NAME LIST</font></h3>
        <a onclick="add_question()" style="float: right;" data-toggle="modal" class="btn">ADD</a>
    </div>
    <div class="card-body">
    <table class="table table-striped table-bordered table-hover display nowrap" id="example1" style="width:100%">
    <thead>
      <th>#</th>
      <th>Name</th>
      <th>Status</th>
      <th>Tools</th>
      </thead>
      <tbody>
      <?php
      $emp_sql=$con->query("SELECT * FROM question_name_master ");
      $i=1;
      while($emp_res = $emp_sql->fetch(PDO::FETCH_ASSOC))
      {
       ?>
      <tr>
      <td><?php echo $emp_res['id']; ?></td>
      <td><?php echo $emp_res['name']; ?></td>
	  <td>
	  <?php
	  if($emp_res['status']==1)
	  {
		  echo '<span style="color:green;text-align:center;"><b>Active</b></span>';
	  }
	  else
	  {
		  echo '<span style="color:red;text-align:center;"><b>Inactive</b></span>';
	  }
	  ?>
	  </td>
      <td>
	  <button class="btn btn-success btn-sm edit btn-flat" data-id="<?php echo $emp_res['id']; ?>" onclick="question_edit(<?php echo $emp_res['id']; ?>)"><i class="fa fa-edit"></i> Edit</button>
	  </td>
      </tr>
      <?php
	  $i++;
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
		function add_question()
    {
    $.ajax({
    type:"POST",
    url:"qvision/assesment/new_department.php",
    success:function(data){
    $("#main_content").html(data);
    }
    })
  }
  function question_edit(v)
    {
    // console.log("/qvision/assesment/edit_department.php?id=" + v);
    $.ajax({
      type: "POST",
      url: "qvision/assesment/edit_department.php",
      data: { id: v },
      success: function(data){
          $("#main_content").html(data);
      },
      error: function(xhr){
          console.log(xhr.status);
          console.log(xhr.responseText);
          alert("Error: " + xhr.status);
      }
    });
  }
  
   
</script>