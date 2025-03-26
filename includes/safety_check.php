<?php
session_start();
require '../auth/config.php';

$matatu_id = isset($_GET['matatu_id']) ? intval($_GET['matatu_id']) : 0;
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $matatu_id = intval($_POST['matatu_id']);
    $inspection_date = date('Y-m-d');
    $brakes_status = $_POST['brakes_status'] ?? '';
    $tire_health = $_POST['tire_health'] ?? '';
    $lights_status = $_POST['lights_status'] ?? '';

    if ($matatu_id === 0) {
        $message = "<p class='text-red-500'>Please select a Matatu.</p>";
    } else {
        $stmt = $pdo->prepare("INSERT INTO safety_checks (matatu_id, inspection_date, brakes_status, tire_health, lights_status) 
                               VALUES (:matatu_id, :inspection_date, :brakes_status, :tire_health, :lights_status)");
        $stmt->execute([
            ':matatu_id' => $matatu_id,
            ':inspection_date' => $inspection_date,
            ':brakes_status' => $brakes_status,
            ':tire_health' => $tire_health,
            ':lights_status' => $lights_status
        ]);

        $message = "<p class='text-green-500'>Safety check recorded successfully!</p>";
    }
}

$matatus = $pdo->query("SELECT id, reg_num FROM matatus")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Safety Check</title>
    <link rel="stylesheet" href="../src/output.css">
</head>
<body class="p-6 bg-base-100 text-base-content">
    <div class="max-w-lg mx-auto bg-base-200 p-6 rounded-box shadow-md">
        <h2 class="text-xl font-semibold mb-4 text-primary-content">Safety Check</h2>

        <?= $message ?>

        <form method="POST" class="space-y-4">
            <label class="block">
                <span class="text-neutral-content">Matatu:</span>
                <select name="matatu_id" class="block w-full p-2 border rounded-btn bg-neutral text-red-500">
                    <option value="">Select Matatu</option>
                    <?php foreach ($matatus as $matatu): ?>
                        <option value="<?= $matatu['id'] ?>" <?= ($matatu_id == $matatu['id']) ? 'selected' : '' ?>>
                            <?= $matatu['reg_num'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>

            <label class="block">
                <span class="text-neutral-content">Brakes Status:</span>
                <select name="brakes_status" class="block w-full p-2 border rounded-btn bg-neutral text-red-500">
                    <option value="good">Good</option>
                    <option value="fair">Fair</option>
                    <option value="poor">Poor</option>
                </select>
            </label>

            <label class="block">
                <span class="text-neutral-content">Tire Health:</span>
                <select name="tire_health" class="block w-full p-2 border rounded-btn bg-neutral text-red-500">
                    <option value="good">Good</option>
                    <option value="fair">Fair</option>
                    <option value="poor">Poor</option>
                </select>
            </label>

            <label class="block">
                <span class="text-neutral-content">Lights Status:</span>
                <select name="lights_status" class="block w-full p-2 border rounded-btn bg-neutral text-red-500">
                    <option value="working">Working</option>
                    <option value="faulty">Faulty</option>
                </select>
            </label>

            <button type="submit" class="bg-warning px-4 py-2 rounded-btn hover:scale-btnFocus transition-transform">Submit Check</button>
        </form>
    </div>
</body>
</html>
