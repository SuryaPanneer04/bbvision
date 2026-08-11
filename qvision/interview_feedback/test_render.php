<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$_SESSION['userrole'] = 'R003';
$_SESSION['candidateid'] = '7'; // Test with 7
ob_start();
include 'new.php';
$output = ob_get_clean();
echo $output;
?>
