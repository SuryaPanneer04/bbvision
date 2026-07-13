<?php
require '../../connect.php';
include("../../user.php");
$userrole=$_SESSION['userrole'];
?>
<div class="container-fluid">
<div class="card mb-3">

<form id="new_section_form" method="POST">
<div class="card-header">
<a onclick="return back_ctc()" style="float: right;" data-toggle="modal" class="btn btn-primary">Back</a>
</div>
<input type="hidden" name="userrole" id="userrole" value="<?php echo  $userrole; ?>">
<table class="table table-bordered">
<tr>
<td><center><img src="../../qvision/image/userlog/quadsel.png" alt="quadsel" style="width:100px;height:50px;"></center></td>
<td colspan="5"><center><b>Bluebase Software Services Private Limited</b></center></td>
</tr>
<tr>
<td>Section Name:</td>
<td colspan="2"><input type="text" class="form-control" id="section" name="section" ></td>
</tr>

<tr>
<td>Status</td>
<td colspan="2">
<select class="form-control" name="status" id="status">
<option value="">Select Status</option>
<option value="1">Active</option>
<option value="0">InActive</option>
</select>
</td>
</tr>
</table>
<input type="button" name="submit" value="Submit" class="btn btn-primary btn-md" style="float:right;" onclick="submit_section()">
</form>
</div>
</div>
<script>
function back_ctc() {
    section_master();
}
function submit_section() {
    var data = $('#new_section_form').serialize();
    $.ajax({
        type: "POST",
        url: "qvision/assesment/section_submit.php",
        data: data + "&submit=1",
        success: function(response){
            alert("Inserted Successfully");
            section_master();
        }
    });
}
</script>
