<?php
require_once '../auth/config.php';

$matatuId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$matatuId) {
    die("Invalid request.");
}

$matatu = [];
$message = '';

try {
    $stmt = $pdo->prepare("SELECT * FROM matatus WHERE id = ?");
    $stmt->execute([$matatuId]);
    $matatu = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$matatu) {
        die("Matatu not found.");
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $regNum = htmlspecialchars($_POST['reg_num'] ?? '');
    $routeNumber = htmlspecialchars($_POST['route_number'] ?? '');
    $seatCapacity = filter_input(INPUT_POST, 'seat_capacity', FILTER_VALIDATE_INT);
    $status = htmlspecialchars($_POST['status'] ?? '');
    $driverId = filter_input(INPUT_POST, 'driver_id', FILTER_VALIDATE_INT);

    if ($regNum && $routeNumber && $seatCapacity && $status && $driverId) {
        try {
            $stmt = $pdo->prepare("UPDATE matatus SET reg_num = ?, route_number = ?, seat_capacity = ?, status = ?, driver_id = ? WHERE id = ?");
            $stmt->execute([$regNum, $routeNumber, $seatCapacity, $status, $driverId, $matatuId]);
            $message = "Matatu updated successfully.";
        } catch (PDOException $e) {
            $message = "Database error: " . $e->getMessage();
        }
    } else {
        $message = "Please fill in all fields correctly.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Edit Matatu</title>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">
  <div class="w-full max-w-lg bg-white rounded-lg shadow-lg p-6">
    <h1 class="text-3xl font-bold text-center text-gray-800">Edit Matatu</h1>
    
    <?php if ($message): ?>
      <p class="text-center mt-4 <?php echo strpos($message, 'successfully') !== false ? 'text-green-500' : 'text-red-500';
        header("Location: ../auth/update_success.php");
      ?>">
        <?php echo $message; ?>
      </p>
    <?php endif; ?>

    <form method="POST" class="mt-6 space-y-4">
      <div>
        <label class="block text-gray-700 font-medium" for="reg_num">Registration Number:</label>
        <input class="input-field" type="text" name="reg_num" value="<?php echo htmlspecialchars($matatu['reg_num']); ?>" required>
      </div>
      <div>
        <label class="block text-gray-700 font-medium" for="route_number">Route Number:</label>
        <input class="input-field" type="text" name="route_number" value="<?php echo htmlspecialchars($matatu['route_number']); ?>" required>
      </div>
      <div>
        <label class="block text-gray-700 font-medium" for="seat_capacity">Seat Capacity:</label>
        <input class="input-field" type="number" name="seat_capacity" value="<?php echo htmlspecialchars($matatu['seat_capacity']); ?>" required>
      </div>
      <div>
        <label class="block text-gray-700 font-medium" for="status">Status:</label>
        <select class="input-field" name="status">
          <option value="active" <?php echo ($matatu['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
          <option value="maintenance" <?php echo ($matatu['status'] == 'maintenance') ? 'selected' : ''; ?>>Maintenance</option>
          <option value="suspended" <?php echo ($matatu['status'] == 'suspended') ? 'selected' : ''; ?>>Suspended</option>
        </select>
      </div>
      <div>
        <label class="block text-gray-700 font-medium" for="driver_id">Driver ID:</label>
        <input class="input-field" type="number" name="driver_id" value="<?php echo htmlspecialchars($matatu['driver_id']); ?>" required>
      </div>
      <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition">Update</button>
    </form>
    
    <div class="text-center mt-4">
      <a class="text-gray-500 hover:text-gray-700" href="../pages/sacco.php">Back to List</a>
    </div>
  </div>

  <style>
    .input-field {
      @apply block w-full bg-gray-100 text-gray-700 border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-white;
    }
  </style>
</body>
</html>
