<?php
require '../../../connect.php';
include("../../../user.php");
$userrole = $_SESSION['userrole'];

// URL la irunthu action enna nu edukkurom (Default ah 'list' view)
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'list';

// ============================================================================
// 0. BACKEND INSERT LOGIC (DB Kooda connect pandra edam)
// ============================================================================
if ($action == 'insert') {
    $staff_id = $_POST['staff_id'];
    
    // Manual ah type pandra text ah apdiye eduthukrom
    $assets_needed = $_POST['assets_needed'];
    
    // Database la theliva Insert pandrom
    $ins_sql = "INSERT INTO staff_access_request (staff_id, asset_master_id, cug_status, status) VALUES ('$staff_id', '$assets_needed', 'No', 1)";
    $con->query($ins_sql);
    $assets_request_id = $con->lastInsertId(); // Get the last inserted ID


    
    echo "success";
    exit; // Stop execution here so it only returns the AJAX response
}

?>
<style>
.card-body { max-width: 131% !important; }
</style>
<head>
  <link rel="stylesheet" href="Qvision\commonstyle.css">
</head>

<?php
// ============================================================================
// 1. ADD REQUEST FORM VIEW
// ============================================================================
if ($action == 'add') {
?>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"><font size="5">Create New Asset Request</font></h3>
            <a onclick="staff_asset_req_list()" style="float: right; cursor: pointer;" class="btn btn-danger btn-sm">Back</a>
        </div>
        <div class="row content">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="card-body">
                        <form role="form" id="new_req_form" onsubmit="submit_request(event)">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <td style="width: 30%; font-weight: bold;">Select Employee:</td>
                                    <td>
                                        <select class="form-control" name="staff_id" required>
                                            <option value="">-- Select Employee --</option>
                                            <?php
                                            $st_sql = $con->query("SELECT * FROM staff_master WHERE emp_name IS NOT NULL AND TRIM(emp_name) != '' ORDER BY emp_name ASC");
                                            while($st = $st_sql->fetch()){
                                                echo "<option value='".$st['id']."'>".$st['emp_name']."</option>";
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;">Select Assets Needed:</td>
                                    <td>
                                         <select class="form-control" name="assets_needed" required>
                                            <option value="">-- Select Assets --</option>
                                            <?php
                                            $ast_sql = $con->query("SELECT * FROM assets_master WHERE name IS NOT NULL AND TRIM(name) != '' ORDER BY name ASC");
                                            while($ast = $ast_sql->fetch()){
                                                echo "<option value='".$ast['id']."'>".$ast['name']."</option>";
                                            }
                                            ?>
                                        </select>
                                    
                                      </td>
                                </tr>
                            </table>
                            <button type="submit" class="btn btn-primary" style="float:right;">Submit Request</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
// ============================================================================
// 2. VIEW DETAILS VIEW
// ============================================================================
} elseif ($action == 'view') {
    $id = $_REQUEST['id'];
    $view_sql = $con->query("SELECT sm.emp_name, a.asset_master_id, a.status FROM staff_access_request a JOIN staff_master sm ON a.staff_id=sm.id WHERE a.id='$id'");
    $res = $view_sql->fetch(PDO::FETCH_ASSOC);
?>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"><font size="5">View Asset Request Details</font></h3>
            <a onclick="staff_asset_req_list()" style="float: right; cursor:pointer;" class="btn btn-danger btn-sm">Back</a>
        </div>
        <div class="row content">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th style="width: 30%;">Employee Name</th>
                                <td><?php echo $res['emp_name']; ?></td>
                            </tr>
                            <tr>
                                <th>Requested Assets</th>
                                <td>
                                    <?php echo $res['asset_master_id']; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td><?php echo ($res['status'] == 1) ? '<span style="color:orange; font-weight:bold;">Pending Allocation</span>' : '<span style="color:green; font-weight:bold;">Allocated</span>'; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
// ============================================================================
// 3. MAIN LIST VIEW (Default)
// ============================================================================
} else {
?>
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title"><font size="5">Staff Asset Request List</font></h3>
        <a onclick="add_staff_asset_request()" style="float: right; cursor: pointer;" class="btn btn-primary">ADD REQUEST</a>
      </div>

      <div class="row content">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="card-body">
              <table class="dataTables-example table table-striped table-bordered table-hover" id="example1">
                <thead>
                  <th>ID</th>
                  <th>Employee Name</th>
                  <th>Status</th>
                  <th>Action</th>
                </thead>
                <tbody>
                  <?php
                  $emp_sql = $con->query("SELECT sm.emp_name, a.id AS sid, a.status FROM staff_access_request a JOIN staff_master sm ON a.staff_id=sm.id WHERE a.status = 1");
                  $i = 1;
                  while ($emp_res = $emp_sql->fetch(PDO::FETCH_ASSOC)) {
                  ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $emp_res['emp_name']; ?></td>
                      <td><?php if ($emp_res['status'] == 1) { echo "Pending"; } ?></td>
                      <td>
                        <button class="btn btn-info btn-sm edit btn-flat" onclick="view_request(<?php echo $emp_res['sid']; ?>)">View</button>
                      </td>
                    </tr>
                  <?php $i++; } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php
} // End of Main List View
?>

<script>
  $(document).ready(function() {
    if ($.fn.DataTable.isDataTable('#example1')) {
        $('#example1').DataTable().destroy();
    }
    $('#example1').DataTable({ responsive: true });
  });

  function staff_asset_req_list() {
    $.ajax({
      type: "POST",
      url: "qvision/Recruitment/staff_asset/staff_asset_request.php", 
      success: function(data) {
        $("#main_content").html(data);
      }
    });
  }

  function add_staff_asset_request() {
    $.ajax({
      type: "POST",
      url: "qvision/Recruitment/staff_asset/staff_asset_request.php?action=add",
      success: function(data) {
        $("#main_content").html(data);
      }
    });
  }

  function view_request(v) {
    $.ajax({
      type: "POST",
      url: "qvision/Recruitment/staff_asset/staff_asset_request.php?action=view&id=" + v,
      success: function(data) {
        $("#main_content").html(data);
      }
    });
  }

  // Proper Database Backend Insert Submit
  function submit_request(e) {
    e.preventDefault();
    var formData = $('#new_req_form').serialize();
    
    $.ajax({
        type: "POST",
        url: "qvision/Recruitment/staff_asset/staff_asset_request.php?action=insert",
        data: formData,
        success: function(response) {
            // Standard Professional Alert
            alert("Asset Request Submitted Successfully!");
            staff_asset_req_list(); // Flow padi thirumba list ku poyidum
        },
        error: function() {
            alert("Error in saving data!");
        }
    });
  }
</script>