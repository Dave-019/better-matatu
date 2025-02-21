
<?php
include "./db_connection.php";

$search = isset($_GET['q']) ? $conn->real_escape_string($_GET['q']) : '';

if ($search !== "") {
    $sql = "
        SELECT reg_num AS name, 'matatu' AS type FROM matatu WHERE reg_num LIKE '%$search%'
        UNION
        SELECT name, 'sacco' FROM sacco WHERE name LIKE '%$search%'
        UNION
        SELECT name, 'driver' FROM driver WHERE name LIKE '%$search%'
        LIMIT 10";

    $result = $conn->query($sql);

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data); 
} else {
    echo json_encode([]); 
}
?>