<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require '../../connect.php';

$payroll_id = isset($_POST['payroll_id']) ? $_POST['payroll_id'] : 0;
$action = isset($_POST['action']) ? $_POST['action'] : '';
$role = isset($_SESSION['userrole']) ? $_SESSION['userrole'] : '';

if($payroll_id != 0 && $action != '') {
    $status = 0;
    $valid = false;
    
    if((strpos(strtoupper($role), 'R003') !== false || strtoupper($role) == 'R001' || strtoupper($role) == 'ADMIN') && $action == 'accept_r003') {
        $status = 1;
        $valid = true;
    } elseif(strpos(strtoupper($role), 'R008') !== false || strtoupper($role) == 'R001' || strtoupper($role) == 'ADMIN') {
        if($action == 'accept_finance') {
            $status = 2;
            $valid = true;
        } elseif($action == 'reject_finance') {
            $status = 3;
            $valid = true;
        }
    }

    if($valid) {
        $update = $con->prepare("UPDATE payroll_master SET approval_status = :status WHERE id = :id");
        $update->bindParam(':status', $status, PDO::PARAM_INT);
        $update->bindParam(':id', $payroll_id, PDO::PARAM_INT);
        if($update->execute()) {
            echo 1;
        } else {
            echo 0;
        }
    } else {
        echo 0;
    }
} else {
    echo 0;
}
?>
