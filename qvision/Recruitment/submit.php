<?php 
require '../../connect.php';
require "../../user.php";
$uploadDir = 'uploads/'; 
$allowTypes = array('pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg'); 
$response = array(); 

$valid = 1; 

// Safely assign variables using isset() to prevent Undefined Index errors breaking the code
$id                    = isset($_POST['id']) ? $_POST['id'] : '';
$candidateid           = isset($_POST['cid']) ? $_POST['cid'] : '';
$position              = isset($_POST['position']) ? $_POST['position'] : ''; 
$name                  = isset($_POST['name']) ? $_POST['name'] : ''; 
$fathers_name          = isset($_POST['fathers_name']) ? $_POST['fathers_name'] : ''; 
$DOB                   = isset($_POST['DOB']) ? $_POST['DOB'] : ''; 
$communication_address = isset($_POST['communication_address']) ? $_POST['communication_address'] : ''; 
$permanent_address     = isset($_POST['permanent_address']) ? $_POST['permanent_address'] : ''; 
$mobile_num            = isset($_POST['mobile_num']) ? $_POST['mobile_num'] : ''; 
$email_id              = isset($_POST['email_id']) ? $_POST['email_id'] : ''; 
$adharnumber           = isset($_POST['adharnumber']) ? $_POST['adharnumber'] : '';
$pannumber             = isset($_POST['pannumber']) ? $_POST['pannumber'] : '';
$voternumber           = isset($_POST['voternumber']) ? $_POST['voternumber'] : '';
$contact_name          = isset($_POST['cpn']) ? $_POST['cpn'] : '';
$contact_relation      = isset($_POST['cpr']) ? $_POST['cpr'] : '';
$contact_no            = isset($_POST['cpm']) ? $_POST['cpm'] : '';
$emp_status            = isset($_POST['emp_status']) ? $_POST['emp_status'] : '';

$filesArr              = isset($_FILES["files"]) ? $_FILES["files"] : array();
$filesArr1             = isset($_FILES["files1"]) ? $_FILES["files1"] : array();
$filesArr2             = isset($_FILES["files2"]) ? $_FILES["files2"] : array();

$aadarcard_attach      = isset($_POST['aadharattach']) ? $_POST['aadharattach'] : ''; 
$pancard_attach        = isset($_POST['panattach']) ? $_POST['panattach'] : ''; 
$votercard_attach      = isset($_POST['voterattach']) ? $_POST['voterattach'] : '';

$status=1;

// Proceed only if candidate ID is present
if($candidateid != ''){ 

    // Aadhar Upload
    $uploadedFile = ''; 
    if(!empty($filesArr['name']) && is_array($filesArr['name'])){  
        $fileNames = array_filter($filesArr['name']); 
        if(!empty($fileNames)){  
            foreach($filesArr['name'] as $key=>$val){  
                $fileName = basename($filesArr['name'][$key]);  
                $targetFilePath = $uploadDir . $fileName;  
                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);  
                if(in_array($fileType, $allowTypes)){  
                    if(move_uploaded_file($filesArr["tmp_name"][$key], $targetFilePath)){  
                        $uploadedFile .= $fileName.','; 
                    } 
                }
            }  
        } 
    }
    $uploadedFileStr = trim($uploadedFile, ','); 

    // PAN Upload
    $uploadedFile = ''; 
    if(!empty($filesArr1['name']) && is_array($filesArr1['name'])){  
        $fileNames = array_filter($filesArr1['name']);  
        if(!empty($fileNames)){  
            foreach($filesArr1['name'] as $key=>$val){  
                $fileName = basename($filesArr1['name'][$key]);  
                $targetFilePath = $uploadDir . $fileName;  
                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);  
                if(in_array($fileType, $allowTypes)){  
                    if(move_uploaded_file($filesArr1["tmp_name"][$key], $targetFilePath)){  
                        $uploadedFile .= $fileName.','; 
                    } 
                }
            }  
        } 
    }
    $uploadedFileStr1 = trim($uploadedFile, ','); 

    // Voter Upload
    $uploadedFile = ''; 
    if(!empty($filesArr2['name']) && is_array($filesArr2['name'])){  
        $fileNames = array_filter($filesArr2['name']); 
        if(!empty($fileNames)){  
            foreach($filesArr2['name'] as $key=>$val){  
                $fileName = basename($filesArr2['name'][$key]);  
                $targetFilePath = $uploadDir . $fileName;  
                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);  
                if(in_array($fileType, $allowTypes)){  
                    if(move_uploaded_file($filesArr2["tmp_name"][$key], $targetFilePath)){  
                        $uploadedFile .= $fileName.','; 
                    } 
                }
            }  
        } 
    }
    $uploadedFileStr2 = trim($uploadedFile, ','); 

    // Attachments checking
    $aadhar_attach = ($uploadedFileStr != '') ? $uploadedFileStr : $aadarcard_attach;
    $pan_attach    = ($uploadedFileStr1 != '') ? $uploadedFileStr1 : $pancard_attach;
    $voter_attach  = ($uploadedFileStr2 != '') ? $uploadedFileStr2 : $votercard_attach;
        
    // Execute SQL Queries using Prepared Statements (Company logic mathama, syntax mattum correct pannirukken)
    if($id != ''){
        $stmt = $con->prepare("UPDATE `emp_personal_details` SET emp_id=?, position=?, name=?, fathers_name=?, DOB=?, communication_address=?, permanent_address=?, mobile_num=?, emergency_contact_relationship=?, contact_person=?, emergency_num=?, email_id=?, adharcard_number=?, pan_number=?, Voter_no=?, aadhar_num=?, pan_num=?, voter_id=?, status=1, modified_by=?, modified_on=now() WHERE id=?");
        $query_status = $stmt->execute([$candidateid, $position, $name, $fathers_name, $DOB, $communication_address, $permanent_address, $mobile_num, $contact_relation, $contact_name, $contact_no, $email_id, $aadhar_attach, $pan_attach, $voternumber, $adharnumber, $pannumber, $voter_attach, $candidateid, $id]);
    } else {	
        $stmt = $con->prepare("INSERT INTO emp_personal_details (emp_id, position, name, fathers_name, DOB, communication_address, permanent_address, mobile_num, emergency_contact_relationship, contact_person, emergency_num, email_id, adharcard_number, pan_number, Voter_no, aadhar_num, pan_num, voter_id, status, created_by, created_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now())");
        $query_status = $stmt->execute([$candidateid, $position, $name, $fathers_name, $DOB, $communication_address, $permanent_address, $mobile_num, $contact_relation, $contact_name, $contact_no, $email_id, $uploadedFileStr, $uploadedFileStr1, $voternumber, $adharnumber, $pannumber, $uploadedFileStr2, $status, $candidateid]);
    }

    $sql2 = $con->query("update candidate_form_details set status='20' where id='$candidateid'");

    // Output status back to JS
    if($query_status){
        echo 1;
    } else {
        $errorInfo = $stmt->errorInfo();
        echo "DB Error: " . $errorInfo[2]; 
    }

} else {
    echo "DB Error: Candidate ID is empty!";
}
?>