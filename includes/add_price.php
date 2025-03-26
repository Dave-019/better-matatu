<?php
require_once'../db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $route = $_POST['Route'];
    $S_price = $_POST['S_price'];
    $p_price = $_POST['p_price'];
    $Op_price = $_POST['Op_price'];

    $sql = "INSERT INTO fares (route_number, standard_fare, peak_fare, off_peak_fare, last_updated) VALUES (?, ?, ?, ?, NOW())";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("iiii", $route, $S_price, $p_price, $Op_price);
        header("location:../pages/sacco.php");
        $stmt->execute();
        $stmt->close();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add price</title>
    <link rel="stylesheet" href="../src/output.css">
<body class="flex items-center justify-center min-h-screen ">
<form action="../includes/add_price.php" method="post" class="space-y-4 p-4 bg-base-100 shadow-md rounded-box    mx-auto">

<div class="space-y-2">
    <label for="name" class="block text-base-content font-medium">Route</label>
    <input type="number" name="Route" id="name" placeholder="Route" class="input input-bordered w-full">
</div>
<div class="space-y-2">
    <label for="S_price" class="block text-base-content font-medium">Standard Price</label>
    <input type="number" name="S_price" id="S_price" placeholder="Standard Price" class="input input-bordered w-full">
</div>
<div class="space-y-2">
    <label for="p_price" class="block text-base-content font-medium">Peak Price</label>
    <input type="number" name="p_price" id="p_price" placeholder="Peak Price" class="input input-bordered w-full">
</div>
<div class="space-y-2">
    <label for="Op_price" class="block text-base-conetent font-medium">Off Peak Price</label>
    <input type="number" name="Op_price" id="Op_price" placeholder="Off Peak Price" class="input input-bordered w-full">
</div>
<button type="submit" class="btn btn-primary w-full">Submit</button>
</form>

</body>
</html>

