<?php
require_once "../auth/config.php";
$stmt = $pdo->prepare("SELECT route_number, standard_fare, peak_fare, off_peak_fare FROM fares ");
$stmt->execute();
$fares = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../src/output.css">
</head>
<body>
<div class="glow card w-full max-w-2xl md:w-1/2 bg-base-100 mx-auto rounded-box border border-base-success/20 overflow-x-auto">
    <table class="table-borderless table">
        <thead>
            <tr>
                <th class="border-b-2 border-info/20 pb-2">Service</th>
                <th class="border-b-2 border-info/20 pb-2">Price</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($fares)): ?>
                <?php foreach ($fares as $fare): ?>
                    <tr>
                        <td class="text-nowrap">Route <?= htmlspecialchars($fare['route_number']) ?> Standard Ride</td>
                        <td>KSh <?= number_format($fare['standard_fare'], 0) ?></td>
                    </tr>
                    <tr>
                        <td class="text-nowrap">Route <?= htmlspecialchars($fare['route_number']) ?> Peak Ride</td>
                        <td>KSh <?= number_format($fare['peak_fare'], 0) ?></td>
                    </tr>
                    <tr>
                        <td class="text-nowrap">Route <?= htmlspecialchars($fare['route_number']) ?> Off-Peak Ride</td>
                        <td>KSh <?= number_format($fare['off_peak_fare'], 0) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2" class="text-center">No fare data available.</td>
                </tr>
            <?php endif; ?>

            <tr>

                <td class="text-nowrap">Student Discount Ride</td>
                <td>KSh 100</td>
            </tr>
            
        </tbody>

    </table>

</div>
</body>
</html>