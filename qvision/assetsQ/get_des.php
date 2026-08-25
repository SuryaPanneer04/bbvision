<?php
require '../../connect.php';
include("../../user.php");
session_write_close();

// ID varutha nu check panna oru variable
$asset_name = isset($_REQUEST["id"]) ? $_REQUEST["id"] : '';

?>
<option value="">Select Description</option>

<?php
if($asset_name != '') {
    // Query run pandrom
    $sqlzz = $con->query("SELECT * FROM `products_description` where product_id='$asset_name'");
    
    // Query success ah run aagudha nu check pandrom
    if($sqlzz) {
        $rowCount = $sqlzz->rowCount();
        
        if($rowCount > 0) {
            while($row11 = $sqlzz->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <option value="<?php echo $row11["id"];?>"><?php echo $row11["description"];?></option>
                <?php
            }
        } else {
             // Data illana indha error dropdown la varum
             echo "<option value=''>No description found for Asset ID: $asset_name</option>";
        }
    } else {
        // SQL syntax error irundha idhu varum
        echo "<option value=''>SQL Error Occurred</option>";
    }
} else {
    echo "<option value=''>ID Empty ah varuthu!</option>";
}
?>