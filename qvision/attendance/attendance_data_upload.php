	<?php
	require '../../connect.php';
	date_default_timezone_set("Asia/Kolkata");
	$curdate=date("d-m-y");
	
	/* echo $from_dat = '2022-01-01';
	echo $to_dat = '2022-01-31';
	
	$from_date = date("Y-m-d",strtotime($from_dat));
	$to_date = date("Y-m-d",strtotime($to_dat)); */
	
	$year = date("y");
    $month = date("m");
    $day = '30';

    $current_date = new DateTime(date('Y-m-d'), new DateTimeZone('Asia/Kolkata'));
	//print_r ($current_date);exit;
    $end_date = new DateTime("$year-$month-$day", new DateTimeZone('Asia/Kolkata'));
	//print_r ($end_date);
    $interval = $current_date->diff($end_date);
    //echo $interval->format('%a day(s)');
	
	?>
<style>
table th {
	padding:8px;
	
}
.att-status > p{
	font-weight: bold;
	font-size: 14px;
}
</style>

	<div class="col-12">
	<!-- Default box -->
	<div class="card">
	<div class="card-header">
	<h3 class="card-title">Attendance Upload</h3>
	</div>
	<div class="card-body">
	<a href="qvision/attendance/qvision_attendance.csv">Download Template</a>
	
	
	<form id="uploadcsvform" name="uploadfile" action="qvision/attendance/attendance_data_insert.php" method="post" enctype="multipart/form-data">
  
 <div class="row">
   <div class="col-sm">
	<div class="form-group">
	 <label for="exampleInputFile">File Upload</label>
	 <input type="file" name="file" id="file" size="150">
	 <p class="help-block">Only CSV File Import.</p>	 
	</div>
    <button type="submit" class="btn btn-default" id="Upload"  name="Upload" value="Upload">Upload</button>
   </div>
  
    <div class="col-sm att-status">
	   <p>0 = Absent  = LOP </p> 
	   <p>1 = Present = Full Salary</p> 
	</div>
	<div class="col-sm att-status">
	   <p>2 = Casual Leave Present = Full Salary</p> 
	   <p>3 = Sick Leave Present   = Full Salary</p> 	    
	</div>
	<div class="col-sm att-status">
	   <p>4 = Earned Leave Present = Full Salary</p>
       <p>5 = Half a day Absent    = ½ day LOP</p>
       <p>6 = Half a day Present   = ½ Present Half Salary</p>	   
	</div>
 </div>
	</form>
	</div>
	
	<form role="form" name="area"  method="post" >
	<!-- action="/qvision/attendance/attendance_data_delete.php" -->
	<table class="table table-striped table-bordered" style="font-family:'Times New Roman', Times, serif">

	<tr> 
		<th colspan='11'> 
			<!-- <input type="submit" class="btn btn-primary" value="Delete Attendance" name="submit"> </th> -->
			<input type="button" class="btn btn-primary" value="Delete Attendance" name="submit" onclick="attendance_delete()"> </th>
	</tr>

		<tr>
		<th><input type="checkbox" checked id="classaall"></th>
		<th>Employee Code</th>
		<th>Emp_Name</th>
		<th>In_Log_Date</th>
		<th>Log_Day</th>
		<!--th>Out_Log_Date</th-->
		<th>Punch_In_Time</th>	
		<th>Punch_Out_Time</th>		
		<th>Work Hours</th>	
		<th>Status</th>		
		<th>Total_Days</th>		
		<th>Working_Days</th>		
		</tr>
		<?php
		
		$attendance_sql=$con->query("SELECT a.id as att_id,a.emp_code,a.emp_name,a.in_log_date,a.log_day,a.out_log_date,a.punch_in_time,a.punch_out_time,a.work_hours,a.status,a.total_days,a.working_days,b.id as sid,b.prefix_code,b.emp_code as ecode FROM bb_attendance a left join staff_master b on(a.emp_code=b.id) order by a.id ASC");

        /* echo "SELECT a.id,a.emp_code,a.emp_name,a.in_log_date,a.log_day,a.out_log_date,a.punch_in_time,a.punch_out_time,a.work_hours,b.id,b.prefix_code,b.emp_code as ecode FROM bb_attendance_view a left join staff_master b on(a.emp_code=b.id) where a.status=1"; */		
	
		//$voucher_comp_list = $con->query($attendance_sql);
		$i=1;
		$total=0;
		while($attendance_data = $attendance_sql->fetch(PDO::FETCH_ASSOC))
		{ 
			?>					
			<tr>
			<td>
			<input type="checkbox" name="attendance_id[]" class="classacheck" checked value="<?php echo $attendance_data['att_id'] ; ?>" >
			</td>
			<td><?php echo $attendance_data['prefix_code'] ; ?><?php echo $attendance_data['ecode'] ; ?></td>
			<td><?php echo $attendance_data['emp_name'] ; ?></td>
			<td><?php echo $attendance_data['in_log_date'] ; ?></td>
			<td><?php echo $attendance_data['log_day'] ; ?></td>
			<!-- td>< ?php echo $attendance_data['out_log_date'] ; ?></td -->
			<td><?php echo $attendance_data['punch_in_time'] ; ?></td>
			<td><?php echo $attendance_data['punch_out_time'] ; ?></td>
			<td><?php echo $attendance_data['work_hours'] ; ?></td>
			<td><?php echo $attendance_data['status'] ; ?></td>
			<td><?php echo $attendance_data['total_days'] ; ?></td>
			<td><?php echo $attendance_data['working_days'] ; ?></td>
			</tr>
			<?php
		}
		?>
		</table>
		<div>
		
		</div>
	</form>
	<!-- /.card-body -->
	</div>
	<!-- /.card -->
	</div>
	<script>
		$('#uploadcsvform').submit(function(e) {
    e.preventDefault();
    
    if(confirm('Are you sure you want to submit this form?')) {
        let formData = new FormData(this);
        formData.append('Upload', 'Upload'); 

        $.ajax({
            url: 'qvision/attendance/attendance_data_insert.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                let res = response.trim();
                if(res.includes("SUCCESS")) {
                    alert("Data Inserted Successfully!");
                    attendance_upload(); 
                } else if(res.includes("Already Existed")) {
                    alert("Data Already Existed for these dates.");
                    attendance_upload(); 
                } else {
                    // Ippo ungaluku error exact ah alert la varum!
                    alert(res); 
                }
            },
            error: function() {
                alert('Upload Failed. Please try again.');
            }
        });
    }
});
// Ungaloda existing attendance_delete() function kela irukum...
		$(document).ready(function ()
		{
			$("#classaall").click(function () {
			$(".classacheck").prop('checked', $(this).prop('checked'));
			});
		});

		function attendance_delete()
    {
		let data = $('form').serialize()
        $.ajax({
            type: 'POST',
			data: data,
            url: 'qvision/attendance/attendance_data_delete.php',
            success: function (data)
            {
				if(data == 1){
					alert('Successfully Deleted')
					attendance_upload()
				}
				else{
					alert('Failed')
					attendance_upload()
				}
            }
        })
    }
	
	</script>
