<?php
require '../../connect.php';
 $id=$_REQUEST['id'];
$stmt = $con->prepare("select * from section_master where id='$id'");
$stmt->execute(); 
$row = $stmt->fetch();
$sta=$row['status'];
?>
<div class="container-fluid">
<div class="card mb-3">
<div class="card-header">
<i class="fa fa-table"></i> SECTION DETAILS EDIT
<a onclick="return back_ctc()" style="float: right;" data-toggle="modal" class="btn btn-primary">Back</a>
</div>
<div class="card-body" id="printableArea">
<form role="form" id="edit_section_form" method="post" enctype="multipart/type">

<table class="table table-bordered">
<tr>
<td><center><img src="qvision/images/logo123.jpg" alt="quadsel" style="width:100px;height:50px;"></center></td>
<td colspan="5"><center><b>Bluebase Software Services Private Limited</b></center></td>
</tr>
<tr>
<td>Section Name:</td>
<td colspan="5">
<input type="hidden" class="form-control" id="id" name="id" value="<?php echo  $id;?>"readonly>
<input type="text" class="form-control" id="name" name="name" value="<?php echo  $row['name'];?>">
</td>
</tr>
<tr>
<td>Status</td>
<td colspan="2">

<select class="form-control" name="status" id="status">
<?php

if($sta==0)
{
	?>
<option value="0">InActive</option>
<option value="1">Active</option>
<?php	
}
else{
	?>
	<option value="1">Active</option>
	<option value="0">InActive</option>
	<?php
}
?>

</select>
</td>
</tr>
</table>

<input type="button" name="submit" value="Update" class="btn btn-primary btn-md" style="float:right;" onclick="update_section()">
</form>
</div>
</div>
</div>
<script>
function back_ctc() {
    section_master();
}
function update_section() {
    var data = $('#edit_section_form').serialize();
    $.ajax({
        type: "POST",
        url: "qvision/assesment/update_section.php",
        data: data + "&submit=1",
        success: function(response){
            alert("Updated Successfully");
            section_master();
        }
    });
}
</script>
