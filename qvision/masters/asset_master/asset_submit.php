<?php
require '../../../connect.php';

$name = $_POST['name'];
$status = isset($_POST['status']) ? $_POST['status'] : 1;
$type = $_POST['type'];
$prefix_code = $_POST['prefix_code'];

if(isset($name) && $name != '') {
    $stmt = $con->prepare("INSERT INTO assets_master (name, type, prefix_code, status) VALUES (:name, :type, :prefix_code, :status)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':type', $type);
    $stmt->bindParam(':prefix_code', $prefix_code);
    $stmt->bindParam(':status', $status);
    
    $stmt->execute();
}
?>