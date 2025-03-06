<?php
 require_once '../auth/config.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$type = isset($_GET['type']) ? $_GET['type'] : '';

if ($type === 'driver') {
   
    $driver = $pdo->prepare("SELECT * FROM drivers WHERE id = :id");
    $driver->execute([':id' => $id]);
    $driver = $driver->fetch();

    
    $matatu = $pdo->prepare("SELECT * FROM matatus WHERE driver_id = :driver_id");
    $matatu->execute([':driver_id' => $id]);
    $matatu = $matatu->fetch();

    $ratings = $pdo->prepare("SELECT * FROM ratings WHERE driver_id = :driver_id ORDER BY timestamp DESC LIMIT 3");
    $ratings->execute([':driver_id' => $id]);
    $ratings = $ratings->fetchAll();

    
    $violations = $pdo->prepare("SELECT * FROM incidents WHERE driver_id = :driver_id ORDER BY timestamp DESC LIMIT 3");
    $violations->execute([':driver_id' => $id]);
    $violations = $violations->fetchAll();
} elseif ($type === 'matatu') {
    
    $matatu = $pdo->prepare("SELECT * FROM matatus WHERE id = :id");
    $matatu->execute([':id' => $id]);
    $matatu = $matatu->fetch();

    $driver = $pdo->prepare("SELECT * FROM drivers WHERE id = :driver_id");
    $driver->execute([':driver_id' => $matatu['driver_id']]);
    $driver = $driver->fetch();

    
    $ratings = $pdo->prepare("SELECT * FROM ratings WHERE matatu_id = :matatu_id ORDER BY timestamp DESC LIMIT 3");
    $ratings->execute([':matatu_id' => $id]);
    $ratings = $ratings->fetchAll();


    $violations = $pdo->prepare("SELECT * FROM incidents WHERE matatu_id = :matatu_id ORDER BY timestamp DESC LIMIT 3");
    $violations->execute([':matatu_id' => $id]);
    $violations = $violations->fetchAll();
} else {
    die("Invalid type parameter.");
}
?>

<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="../src/output.css" rel="stylesheet">
</head>
<body style="font-family:'lor',cascadia" class="text-base-content p-6">
  <div class="max-w-xl mx-auto space-y-6">

    <!-- Profile Section -->
    
    <div class="bg-base-100 p-6 rounded-box border border-info/20">
    <h1 class="text-2xl font-bold text-warning">DRIVER</h1>
            
            <div class="flex-1">
                <h1 class="text-2xl font-bold"><?php echo htmlspecialchars($driver['name']); ?></h1>
                <p class="text-neutral-content"><?php echo htmlspecialchars($driver['sacco_id'] ? "Metro Sacco" : "N/A"); ?></p>
                <div class="flex gap-4 mt-2">
                    <span class="px-3 py-1 bg-success text-success-content rounded-box">
                        Safety Score: <?php echo htmlspecialchars($driver['safety_score']); ?>%
                    </span>
                    <span class="px-3 py-1 bg-error text-error-content rounded-box">
                        Violations: <?php echo htmlspecialchars($driver['violation_count']); ?>
                    </span>
                </div>
            </div>
        </div>
  

    <!-- Matatu Details -->
    <div class="bg-base-200 p-6 rounded-box border border-info/20">
        <h2 class="text-xl font-semibold mb-4">Assigned Matatu</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="flex items-center gap-2">
                <span class="text-info"> </span> <?php echo htmlspecialchars($matatu['reg_num']); ?>
            </div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 bg-success text-success-content rounded-box"><?php echo htmlspecialchars($matatu['status']); ?></span>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-accent"> </span> Route <?php echo htmlspecialchars($matatu['route_number']); ?>
            </div>
        </div>
    </div>

    <!-- Ratings Section -->
    <div class="bg-base-200 p-6 rounded-box border border-info/20">
        <h2 class="text-xl font-semibold mb-4">Recent Ratings & Feedback</h2>
        <div class="space-y-4">
            <?php foreach ($ratings as $rating): ?>
            <div class="border-b border-base-300 pb-4">
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-success"> </span> <span class="text-sm text-neutral-content"><?php echo htmlspecialchars(date('Y-m-d', strtotime($rating['timestamp']))); ?></span>
                </div>
                <p class="text-sm text-base-content"><?php echo htmlspecialchars($rating['comment']); ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Violations Section -->
    <div class="bg-base-200 p-6 rounded-box border border-info/20">
        <h2 class="text-xl font-semibold mb-4">Violation History</h2>
        <div class="space-y-4">
            <?php foreach ($violations as $violation): ?>
            <div class="flex flex-col md:flex-row md:items-center justify-between border-b border-base-300 pb-4">
                <div>
                    <p class="font-medium"><?php echo htmlspecialchars($violation['violation_type']); ?></p>
                    <p class="text-sm text-neutral-content"><?php echo htmlspecialchars(date('Y-m-d', strtotime($violation['timestamp']))); ?></p>
                </div>
                <div class="flex items-center gap-2 mt-2 md:mt-0">
                    <span class="px-3 py-1 bg-<?php echo htmlspecialchars($violation['status'] == 'pending' ? 'warning' : 'success'); ?> text-<?php echo htmlspecialchars($violation['status'] == 'pending' ? 'warning-content' : 'success-content'); ?> rounded-box"><?php echo htmlspecialchars(ucfirst($violation['status'])); ?></span>
                    <span class="text-sm text-neutral-content"><?php echo htmlspecialchars($violation['status'] == 'pending' ? 'Under review' : 'Warning issued'); ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

  </div>
  <script src="../node_modules/flyonui/flyonui.js"></script>
</body>
</html>