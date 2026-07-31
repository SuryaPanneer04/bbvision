<?php
require '../../connect.php';


$qn_name=$_REQUEST['qn_name'];
$section=$_REQUEST['section'];
$Questions=addslashes($_REQUEST['Questions']);

 $Option_A=addslashes($_REQUEST['Option_A']);
$Option_B=addslashes($_REQUEST['Option_B']);
$Option_C=addslashes($_REQUEST['Option_C']);
$Option_D=addslashes($_REQUEST['Option_D']);
$answer_key=addslashes($_REQUEST['answer_key']);





$sql=$con->query("insert into question_master(qn_name,section,Questions,Option_A,Option_B,Option_C,Option_D,answer_key) values('$qn_name','$section','$Questions','$Option_A','$Option_B','$Option_C','$Option_D','$answer_key')");

//echo "insert into question_master(qn_name,section,Questions,Option_A,Option_B,Option_C,Option_D,answer_key) values('$qn_name','$section','$Questions','$Option_A','$Option_B','$Option_C','$Option_D','$answer_key')";


?>