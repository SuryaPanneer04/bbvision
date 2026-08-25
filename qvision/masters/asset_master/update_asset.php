<?php
require '../../../connect.php';

$id = $_POST['id'];
$name = $_POST['name'];
$status = isset($_POST['status']) ? $_POST['status'] : 1;
$type = $_POST['type'];
$prefix_code = $_POST['prefix_code'];

if(isset($id) && $id != '') {
    $stmt = $con->prepare("UPDATE assets_master SET name=:name, type=:type, prefix_code=:prefix_code, status=:status WHERE id=:id");
    
    $stmt->bindParam(':name', $name);
    
    $stmt->bindParam(':type', $type);
    $stmt->bindParam(':prefix_code', $prefix_code);
    
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':id', $id);
    
    $stmt->execute();
}
?>