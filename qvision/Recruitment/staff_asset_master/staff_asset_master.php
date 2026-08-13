<?php
require '../../../connect.php';
include("../../../user.php");
$userrole = $_SESSION['userrole'];
?>
<head>
    <link rel="stylesheet" href="Qvision\commonstyle.css">
    <style>
        /* .content class & DataTables default gap fix */
        .card-body.content {
            padding-left: 0px !important;
            padding-right: 80px !important;
        }
        .card-body.content .row {
            margin-left: 0px !important;
            margin-right: 10px !important;
        }
        .card-body.content [class*="col-"] {
            padding-left: 0px !important;
            padding-right: 0px !important;
        }
    </style>
</head>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><font size="5">STAFF ASSET MASTER</font></h3>
        <a onclick="add_staff_asset()" style="float: right;" data-toggle="modal" class="btn">ADD</a>
    </div>
    <!-- THIS CONTENT DIV IS IMPORTANT -->
    <div class="card-body content">
        <table class="table table-striped table-bordered table-hover display nowrap" id="example1" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Asset</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $emp_sql = $con->query("SELECT * FROM staff_asset_master");
                                    $i = 1;
                                    while ($emp_res = $emp_sql->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $emp_res['asset']; ?></td>
                                            <td>
                                                <button class="btn btn-success btn-sm btn-flat"
                                                    onclick="staff_asset_edit(<?php echo $emp_res['id']; ?>)">
                                                    <i class="fa fa-edit"></i> Edit
                                                </button>
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
        $('#example1').DataTable({
            "scrollX": true
        });
    });

    /* Add page load */
    function add_staff_asset() {
        $.ajax({
            type: "POST",
            url: "qvision/Recruitment/staff_asset_master/new_staff_asset_master.php",
            success: function(data) {
                $(".content").html(data);
            },
            error: function(xhr, status, error) {
                alert("Add page load error: " + error);
                console.log(xhr.responseText);
            }
        });
    }

    /* Edit page load */
    function staff_asset_edit(id) {
        $.ajax({
            type: "POST",
            url: "qvision/Recruitment/staff_asset_master/edit_staff_asset_master.php",
            data: {
                id: id
            },
            success: function(data) {
                $(".content").html(data);
            },
            error: function(xhr, status, error) {
                alert("Edit page load error: " + error);
                console.log(xhr.responseText);
            }
        });
    }

    /* Back button from edit page */
    $(document).off('click', '#btn_back_edit_staff_asset').on('click', '#btn_back_edit_staff_asset', function(e) {
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "qvision/Recruitment/staff_asset_master/staff_asset_master.php",
            success: function(data) {
                $(".content").html(data);
                // setTimeout(function() {
                //     if ($.fn.DataTable.isDataTable('#example1')) {
                //         $('#example1').DataTable().destroy();
                //     }
                //     $('#example1').DataTable({
                //         responsive: true
                //     });
                // }, 100);
            },
            error: function(xhr, status, error) {
                alert("Back Error: " + error);
                console.log(xhr.responseText);
            }
        });
    });


    /* Back button from Add page */
$(document).off('click', '#btn_back_new_staff_asset').on('click', '#btn_back_new_staff_asset', function(e) {

    e.preventDefault();

    $.ajax({
        type: "POST",
        url: "qvision/Recruitment/staff_asset_master/staff_asset_master.php",
        success: function(data) {
            $(".content").html(data);
        },
        error: function(xhr, status, error) {
            alert("Back Error : " + error);
            console.log(xhr.responseText);
        }
    });

});

    /* Update asset */
    $(document).off('click', '#btn_update_staff_asset').on('click', '#btn_update_staff_asset', function() {
        var data = $('#edit_staff_asset_form').serialize();

        $.ajax({
            type: "POST",
            url: "qvision/Recruitment/staff_asset_master/update_staff_asset_master.php",
            data: data,
            success: function(response) {
                alert(response);
            },
            error: function(xhr, status, error) {
                alert("Update Error: " + error);
                console.log(xhr.responseText);
            }
        });
    });
</script>