<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

require '../db_connection.php'; // Include your DB connection

if (isset($_GET['query'])) {
    $query = trim($_GET['query']);
    
    $stmt = $conn->prepare("SELECT 'matatu' AS type, reg_num AS name FROM matatus WHERE reg_num LIKE ? 
                            UNION 
                            SELECT 'driver' AS type, name AS driver_name FROM drivers WHERE name LIKE ? 
                            UNION 
                            SELECT 'sacco' AS type, name AS sacco_name FROM sacco_cooperatives WHERE name LIKE ?");
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
