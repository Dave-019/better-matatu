<?php

require_once '../auth/config.php'; 

if (!isset($_SESSION['user_id'])) {
    exit("User not logged in.");
}

$user_id = $_SESSION['user_id'];


$query = $pdo->prepare("SELECT sacco_id FROM users WHERE id = :user_id");
$query->execute([':user_id' => $user_id]);
$sacco = $query->fetch(PDO::FETCH_ASSOC);

if (!$sacco || !$sacco['sacco_id']) {
    exit("User does not have a SACCO associated with them.");
}

$sacco_id = $sacco['sacco_id'];


function getCount($pdo, $query, $params)
{
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    return (int) $stmt->fetchColumn(); 
}


$totalMatatus = getCount($pdo, "SELECT COUNT(*) FROM matatus WHERE sacco_id = :sacco_id", [':sacco_id' => $sacco_id]);
$totalDrivers = getCount($pdo, "SELECT COUNT(*) FROM drivers WHERE sacco_id = :sacco_id", [':sacco_id' => $sacco_id]);
$activeViolations = getCount($pdo, "
    SELECT COUNT(*) FROM incidents 
    WHERE matatu_id IN (SELECT id FROM matatus WHERE sacco_id = :sacco_id) 
    AND status = 'pending'
", [':sacco_id' => $sacco_id]);
$pendingApprovals = getCount($pdo, "
    SELECT COUNT(*) FROM sacco_cooperatives 
    WHERE penalty_points > 3 AND id = :sacco_id
", [':sacco_id' => $sacco_id]);
?>


<!-- Quick Stats -->
<div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="card p-4 bg-secondary/20 border border-base-success/20">
        <h3 class="text-lg font-semibold">Total Matatus</h3>
        <p class="text-2xl"><?php echo $totalMatatus; ?></p>
    </div>
    <div class="card p-4 bg-secondary/20 border border-base-success/20">
        <h3 class="text-lg font-semibold">Total Drivers</h3>
        <p class="text-2xl"><?php echo $totalDrivers; ?></p>
    </div>
    <div class="card p-4 bg-secondary/20 border border-base-success/20">
        <h3 class="text-lg font-semibold">Active Violations</h3>
        <p class="text-2xl"><?php echo $activeViolations; ?></p>
    </div>
    <div class="card p-4 bg-secondary/20 border border-base-success/20">
        <h3 class="text-lg font-semibold">Pending Approvals</h3>
        <p class="text-2xl"><?php echo $pendingApprovals; ?></p>
    </div>
</div>
