<?php

require '../auth/config.php';

$sql = "SELECT i.violation_type, i.location, i.status, i.timestamp, 
               m.reg_num AS vehicle_plate, 
               d.name AS driver_name,
               TIMESTAMPDIFF(MINUTE, i.timestamp, NOW()) AS minutes_ago 
        FROM incidents i
        LEFT JOIN matatus m ON i.matatu_id = m.id
        LEFT JOIN drivers d ON i.driver_id = d.id
        ORDER BY i.timestamp DESC
        LIMIT 5";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$incidents = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recent Incidents</title>
    
</head>
<body class="bg-base-100 p-6">
    <div class="card p-6 bg-base-100  rounded-box border border-base-success/20 max-w-3xl md:w-1/2"">
        <h2 class="text-2xl font-bold mb-4">Recent Reports</h2>
        <ol>
            <?php foreach ($incidents as $incident) { ?>
                <div>
                    <li class="flex justify-between py-2">
                        <?= htmlspecialchars($incident['violation_type']); ?>
                        <p class="text-xs">
                            <span class="badge <?= $incident['status'] == 'pending' ? 'badge-warning' : ($incident['status'] == 'reviewed' ? 'badge-info' : 'badge-success'); ?> rounded-md">
                                <?= ucfirst($incident['status']); ?>
                            </span>
                        </p>
                    </li>
                    <li class="border-b flex justify-between py-2">
                        <?= htmlspecialchars($incident['vehicle_plate']) . ' - ' . htmlspecialchars($incident['driver_name']) . ' - ' . htmlspecialchars($incident['location']); ?>
                        <div>
                            <?php 
                            if ($incident['minutes_ago'] < 60) {
                                echo $incident['minutes_ago'] . ' minutes ago';
                            } elseif ($incident['minutes_ago'] < 60 * 24) {
                                echo round($incident['minutes_ago'] / 60) . ' hours ago';
                            } else {
                                echo round($incident['minutes_ago'] / (60 * 24)) . ' days ago';
                            }
                            ?>
                        </div>
                    </li>
                </div>
            <?php } ?>
        </ol>
    </div>
</body>
</html>
