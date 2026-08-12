<?php

session_start();
error_reporting(E_ERROR | E_PARSE);
ini_set('display_errors', 0);
header('Content-Type: application/json');

require('../../connect.php');

//update the status variable
$employeeId =  $_GET['employeeId'] ?? $_POST['employeeId'] ?? '';
$taskId =  $_GET['taskId'] ?? $_POST['taskId'] ?? '';

try {
    if ($taskId != "") {
        $res = $con->prepare("UPDATE y_project_tasks SET status = 1 WHERE task_id =:task_id");
        $res->bindParam(':task_id', $taskId, PDO::PARAM_INT);

        if ($res->execute()) {
            echo json_encode([
                'status' => true,
                'message' => "Task status updated successfully"
            ]);
            exit();
        } else {
            echo json_encode([
                'status' => false,
                'message' => "Some went wrong"
            ]);
            exit();
        }
    }

    if (!$employeeId) {
        echo json_encode([
            "status" => false,
            "message" => "Invalid JSON"
        ]);
        exit;
    }


    $stmt = $con->prepare("SELECT * FROM `y_project_tasks`pt 
            LEFT JOIN y_project_details pd ON pd.project_id = pt.project_id 
            WHERE pt.employee_id =:employeeId ");
    $stmt->bindValue(':employeeId', $employeeId, PDO::PARAM_STR);


    if ($stmt->execute()) {
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'status' => 'success',
            'data'   => $rows,
        ]);
        exit();
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'No data found'
        ]);
        exit();
    }
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
    exit();
}
