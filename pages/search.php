<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

require '../db_connection.php'; // Your DB connection file

if (isset($_GET['query'])) {
    $query = trim($_GET['query']);
    
    // Each SELECT returns 5 columns with matching names
    $stmt = $conn->prepare("
        SELECT 'driver' AS type, 
               license_number AS identifier, 
               phone AS info1, 
               safety_score AS info2, 
             violation_count AS info3
        FROM drivers
        WHERE license_number LIKE ?
        UNION
        SELECT 'sacco' AS type, 
               name AS identifier, 
               route_license AS info1, 
               penalty_points AS info2, 
               created_at AS info3
               
        FROM sacco_cooperatives
        WHERE name LIKE ?
        UNION
        SELECT 'matatu' AS type, 
               reg_num AS identifier, 
               route_number AS info1, 
               seat_capacity AS info2, 
               status AS info3   
        FROM matatus
        WHERE reg_num LIKE ?
    ");
    
    $searchTerm = "%$query%";
    $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    
    echo json_encode($data);
} else {
    echo json_encode(["error" => "No query provided"]);
}
?>
