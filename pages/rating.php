<?php
session_start();
$passenger_id = $_SESSION['user_id'] ?? null;

if (!$passenger_id) {
    die("<p class='text-red-500'>You must be logged in to rate.</p>");
}

require '../db_connection.php';

$type = $_GET['type'] ?? ''; 
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$matatu_id = 0;
$driver_id = 0;

if ($type === "driver") {
    $driver_id = $id;
    $stmt = $pdo->prepare("SELECT id FROM matatus WHERE driver_id = :driver_id LIMIT 1");
    $stmt->execute([':driver_id' => $driver_id]);
    $result = $stmt->fetch();
    $matatu_id = $result['id'] ?? 0;
} elseif ($type === "matatu") {
    $matatu_id = $id;
    $stmt = $pdo->prepare("SELECT driver_id FROM matatus WHERE id = :matatu_id LIMIT 1");
    $stmt->execute([':matatu_id' => $matatu_id]);
    $result = $stmt->fetch();
    $driver_id = $result['driver_id'] ?? 0;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
    $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';
    $timestamp = date('Y-m-d H:i:s');

    if ($rating < 1 || $rating > 5) {
        echo "<p class='text-red-500'>Invalid rating. Please select a rating between 1 and 5.</p>";
    } elseif ($matatu_id === 0 && $driver_id === 0) {
        echo "<p class='text-red-500 text-center'>Invalid request. No driver or matatu found.</p>";
    } else {
        $stmt = $pdo->prepare("INSERT INTO ratings (passenger_id, matatu_id, driver_id, rating, timestamp, comment) 
                               VALUES (:passenger_id, :matatu_id, :driver_id, :rating, :timestamp, :comment)");
        $stmt->execute([
            ':passenger_id' => $passenger_id,
            ':matatu_id' => $matatu_id,
            ':driver_id' => $driver_id,
            ':rating' => $rating,
            ':timestamp' => $timestamp,
            ':comment' => $comment
        ]);

        echo "<p class='text-green-500 text-center'>Rating submitted successfully!</p>";
    }
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Rate</title>
</head>
<body >

    <div class="max-w-md mx-auto ">
        <h1 class="text-3xl   mb-4">Rate </h1>

        <form method="POST" action="">
            <label class="block font-semibold">Rating (1-5):</label>
            <select name="rating" required class="select select-bordered w-full">
                <option value="">Select Rating</option>
                <option value="1">1 - Poor</option>
                <option value="2">2 - Fair</option>
                <option value="3">3 - Good</option>
                <option value="4">4 - Very Good</option>
                <option value="5">5 - Excellent</option>
            </select>

            <label class="block font-semibold mt-4">Comment (optional):</label>
            <textarea name="comment" class="textarea textarea-bordered w-full h-24"></textarea>

            <input type="hidden" name="matatu_id" value="<?php echo $matatu_id; ?>">
            <input type="hidden" name="driver_id" value="<?php echo $driver_id; ?>">

            <button type="submit" class="btn btn-soft btn-warning mt-4">Submit Rating</button>
        </form>
    </div>

</body>
</html>

