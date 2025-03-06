<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

require '../db_connection.php'; 

if (isset($_GET['query'])) {
    $query = trim($_GET['query']);
    
    
    $stmt = $conn->prepare("
        SELECT 'driver' AS type, 
                id as id,
               name AS identifier, 
               phone AS info1, 
               safety_score AS info2, 
             violation_count AS info3
        FROM drivers
        
        WHERE name LIKE ?
        UNION
        SELECT 'sacco' AS type, 
                id as id,
               name AS identifier, 
               route_license AS info1, 
               penalty_points AS info2, 
               created_at AS info3
               
        FROM sacco_cooperatives
        WHERE name LIKE ?
        UNION
        SELECT 'matatu' AS type, 
               id as id,
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
