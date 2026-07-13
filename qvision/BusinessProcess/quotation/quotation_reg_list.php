<?php
require '../../../connect.php';
require '../../../user.php';
$candidateid=$_SESSION['candidateid'];
$userrole=$_SESSION['userrole'];
?>

<head>
    <link rel="stylesheet" href="Qvision\commonstyle.css">
    </head>
	<style>
	.card-primary:not(.card-outline)>.card-header{
		background-color: #f1cc61 !important;
	}
	</style>
	<div  class="card card-primary">
              <div class="card-header">
                <h3 style="float: left;">QUOTE RE-GENETATED LIST</h3>
		  		  <!--<a onclick="return back()" style="float: right;" data-toggle="modal" class="btn btn-dark"><i class="fa fa-plus"></i>Back</a>-->
		      </div>
           
     <div class="card-body">
              <table class="table table-striped table-bordered table-hover display nowrap"  id="example1" style="width:100%">

	
      <thead>
	  <th>#</th>
	  <th>Cost sheet No </th>
	  <th>Quote No </th>
      <th>Product / Service </th>
      <th>Quote Type</th> 
	  <th>Client Name</th>
      <th>Employee Name</th>
	  <th>Status</th>
	  <th>Action</th>
      </thead>
      <tbody>
	
      <?php
		 $datas=$con->query("SELECT a.id as costsheet_id,a.*,b.*,e.*,f.*,h.* from cost_sheet_entry a 
		        inner join client_master b on(b.id = a.client_id) 
		        inner join product_services f on (f.id = a.business_id)
		        inner join staff_master e ON e.candid_id=a.candid_id  
				inner join quote_generate h on(h.cost_sheet_id=a.id)
				where a.status ='4' and a.created_by='$candidateid' and h.status ='2' group by a.cost_sheet_no  order by a.id desc");
				
/*          echo "SELECT a.id as costsheet_id,a.*,b.*,e.*,f.*,h.* from cost_sheet_entry a 
		        inner join client_master b on(b.id = a.client_id) 
		        inner join `product/services` f on (f.id = a.business_id)
		        inner join staff_master e ON e.candid_id=a.candid_id  
				inner join quote_generate h on(h.cost_sheet_id=a.id)
				where a.status ='4' and a.created_by='$candidateid' and h.status ='2' group by a.cost_sheet_no  order by a.id desc" ; */
	   
     $cnt=1;
      while($data =$datas->fetch(PDO::FETCH_ASSOC))
	  {
	  ?>
      <tr>
		  <td><?php echo $cnt;?>.</td>
		  <td><?php echo $data['cost_sheet_no']; ?></td>
		  <td><?php echo $data['quote_no']; ?></td>
		  <td><?php 
		  if($data['business_id'] =='1'){ echo "Product"; 
		  }elseif($data['business_id'] =='2'){ echo "Service";
		  }elseif($data['business_id'] =='3'){ echo "Solution";
		  }
		  ?></td>
		  <td><?php if($data['quote_type']=='1'){ echo "INR"; }else{ echo "Doller";}?></td>
		 
		  <td><?php echo $data['client_name']; ?></td>
		  <td><?php echo $data['emp_name']; ?></td>
		  <td><?php echo $data['remark']; ?></td>
		  <td>  
		      <input type ="hidden" name="cost_sheet_no" id ="cost_sheet_no" value="<?php echo $data['cost_sheet_no']; ?>">
			  <input type ="hidden" name="quote_no" id ="quote_no" value="<?php echo $data['quote_no']; ?>">
			<!-- <button class="btn btn-info" data-id="<?php echo $data['cost_sheet_no']; ?>" onclick="quote_proposal_view(<?php echo $data['cost_sheet_no']; ?>)">
			 <i class="fa fa-eye"></i> Re-Generated </button>-->
			 <input type="button" class="btn btn-success" id="save" name="save" onclick="quote_reg()"  value="Re-Generated">
		  </td>
      </tr>
      <?php
	  $cnt=$cnt+1;
      //}
	 }
      ?>
      </tbody>
      </table>
 </div>
</div>
<script>
function back()

	{
		url:"qvision/BusinessProcess/quotation/quotation_reg_list.php?id=",
		

	}
$(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });




function quote_proposal_view(v){
	  //alert(v);
	$.ajax({
	type:"POST",
	url:"qvision/BusinessProcess/quotation/quotation_reg_update.php?id="+v,
	success:function(data)
	{
		//$("#main_content").html(data);
		alert("Quote Re-Generated Successfully");
		quotation_regenerate()
	}
	})
}

function quote_reg()
{
	
 	var cost_sheet_no    = document.getElementById("cost_sheet_no").value;
	var quote_no         = document.getElementById("quote_no").value;
    alert(cost_sheet_no);
	alert(quote_no);
	$.ajax({
	type:'GET',
	data:"quote_no="+quote_no+'&cost_sheet_no='+cost_sheet_no, 
	url:"qvision/BusinessProcess/quotation/quotation_reg_update.php",
	success:function(data)
	{      
		alert("Quote Re-Generated Successfully");
		Quotation_send()
				  
	}       
	}); 
}

</script>