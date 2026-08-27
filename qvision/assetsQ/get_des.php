<?php
require '../../connect.php';
include("../../user.php");
session_write_close();

$asset_name = isset($_REQUEST["id"]) ? $_REQUEST["id"] : '';

?>
<option value="">Select Description</option>

<?php
if($asset_name != '') {
    $sqlzz = $con->query("SELECT * FROM `products_description` where product_id='$asset_name'");
    
    if($sqlzz) {
        $rowCount = $sqlzz->rowCount();
        
        if($rowCount > 0) {
            while($row11 = $sqlzz->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <option value="<?php echo $row11["id"];?>"><?php echo $row11["description"];?></option>
                <?php
            }
        } else {
             echo "<option value=''>No description found for Asset ID: $asset_name</option>";
        }
    } else {
        echo "<option value=''>SQL Error Occurred</option>";
    }
} else {
    echo "<option value=''>ID Empty ah varuthu!</option>";
}
?>