<?php
require '../../../connect.php';

if(isset(['idd'])){
     = ['idd'];
     = ['scope_text'];
     = ['command_text'];

     = ->prepare("INSERT INTO bbvision.software_quotation_flow (call_id, scope_text, command_text) VALUES (?, ?, ?)");
    ->execute([, , ]);
    
    echo 1;
}
?>
