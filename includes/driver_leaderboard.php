<?php
require '../auth/config.php';
$sql = "SELECT id, name, safety_score, violation_count, 
               ROUND((safety_score / 20) - (violation_count * 0.2), 1) AS rating
        FROM drivers 
        ORDER BY rating DESC
         limit 7"
       
        ;

$stmt = $pdo->prepare($sql);
$stmt->execute();
$drivers = $stmt->fetchAll();

function getPerformanceBadge($rating) {
    if ($rating >= 4.5) {
        return '<span class="badge badge-success text-xs">Excellent</span>';
    } elseif ($rating >= 4.0) {
        return '<span class="badge badge-primary text-xs">Very Good</span>';
    } elseif ($rating >= 3.0) {
        return '<span class="badge badge-info text-xs">Good</span>';
    } else {
        return '<span class="badge badge-warning text-xs">Needs Improvement</span>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

</head>
<body class="bg-base-100">
    <h2 class="text-2xl font-bold mb-4">Drivers Leaderboard</h2>
    <table class="table w-full">
        <thead class="bg-base-300">
            <tr>
                <th class="px-4 py-2">Rank</th>
                <th class="px-4 py-2">Driver Name</th>
                <th class="px-4 py-2">Rating</th>
                <th class="px-4 py-2">Performance</th>
                <th class="px-4 py-2">Safety Score</th>
                <th class="px-4 py-2">Violations</th>
               
            </tr>
        </thead>
        <tbody>
            <?php 
            $rank = 1;
            foreach ($drivers as $driver) { ?>
                <tr class="border-b">
                    <td class="px-4 py-2 font-bold"><?= $rank++; ?></td>
                    <td class="px-4 py-2"><?= htmlspecialchars($driver['name']); ?></td>
                    <td class="px-4 py-2"><?= $driver['rating']; ?></td>
                    <td class="px-4 py-2"><?= getPerformanceBadge($driver['rating']); ?></td>
                    <td class="px-4 py-2"><?= $driver['safety_score']; ?></td>
                    <td class="px-4 py-2"><?= $driver['violation_count']; ?></td>

                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
