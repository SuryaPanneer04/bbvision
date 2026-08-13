<?php
require '../../connect.php';
include("../../user.php");
$userrole=$_SESSION['userrole'];
?>
<style>
	.card-primary:not(.card-outline)>.card-header {
		background-color: #f1cc61 !important;
		color: black !important;
	}
	.btn-dark {
		background-color: #ed5d00 !important;
		border-color: #ed5d00 !important;
	}
	.card-primary:not(.card-outline)>.card-header a {
		color: black !important;
	}	
</style>
<div class="container-fluid">
	<div class="card card-primary">
		<div class="card-header">
			<h3 class="card-title">
				<font size="5">ADD SECTION DETAILS</font>
			</h3>
			<a onclick="return back_ctc()" style="float: right; cursor: pointer;" class="btn btn-dark">BACK</a>
		</div>
		<form method="POST" action="qvision/assesment/section_submit.php">
<input type="hidden" name="userrole" id="userrole" value="<?php echo  $userrole; ?>">
<table class="table table-bordered">
<tr>
<td><center><img src="qvision/images/logo123.jpg" alt="quadsel" style="width:100px;height:50px;"></center></td>
<td colspan="5"><center><b>Quadsel Systems Private Limited</b></center></td>
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
<input type="submit" name="submit" value="Submit" class="btn btn-dark btn-md" style="float:right; position:relative; left:-5px;">
<br><br>
</form>
</div>
<script>
function back_ctc() {
    // Unga Section list page-ku thirumba porathukana function call
    section_master(); 
}
</script>
</div>
