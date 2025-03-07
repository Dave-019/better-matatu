<?php
require '../auth/config.php';

try {
    if (!isset($_SESSION['user_id'])) {
        throw new Exception("Unauthorized access. Please log in.");
    }

    $admin_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("SELECT sacco_id FROM users WHERE id = ? AND role = 'sacco_admin'");
    $stmt->execute([$admin_id]);
    $sacco_id = $stmt->fetchColumn();

    if (!$sacco_id) {
        throw new Exception("Sacco admin not found or unauthorized.");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['incident_id'], $_POST['status'])) {
            throw new Exception("Invalid request. Missing data.");
        }

        $incident_id = $_POST['incident_id'];
        $new_status = $_POST['status'];

        $stmt = $pdo->prepare("UPDATE incidents SET status = ?, timestamp = NOW() WHERE id = ?");
        $stmt->execute([$new_status, $incident_id]);

        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    $stmt = $pdo->prepare("
        SELECT i.*
        FROM incidents i
        JOIN matatus m ON i.matatu_id = m.id
        WHERE m.sacco_id = ?
        ORDER BY i.status ASC, i.timestamp DESC
    ");
    $stmt->execute([$sacco_id]);
    $incidents = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    $error_message = $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incident Management</title>
    
    <link rel="stylesheet" href="../src/output.css">
</head>
<body class="bg-base-100">

    <div class="container mx-auto p-6 w-full sm:w-3/4">
        <h2 class="text-2xl font-bold mb-4">Incident Management Panel</h2>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-error mb-4"><?= htmlspecialchars($error_message) ?></div>
        <?php else: ?>
            <p class="mb-4">Showing incidents:</p>

            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th>ID</th>
                                                        
                            <th>Status</th>
                            <th>Description</th>
                            <th>Violation</th>
                            <th>Location</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php if (empty($incidents)): ?>
        <tr>
            <td colspan="6" class="text-center">No incidents found.</td>
        </tr>
    <?php else: ?>
        <?php foreach ($incidents as $incident): ?>
            <a href="incident_details.php?id=<?= $incident['id'] ?>" >
                    <tr>
                <td>
                    <a href="../pages/incident_details.php?id=<?= $incident['id'] ?>" class="text-blue-500 hover:underline">
                        <?= $incident['id'] ?>
                    </a>
                </td>
                <td>
                    <span class="badge 
                        <?= $incident['status'] == 'pending' ? 'badge-warning' :
                            ($incident['status'] == 'reviewed' ? 'badge-info' :
                            'badge-success') ?>">
                        <?= ucfirst($incident['status']) ?>
                    </span>
                </td>
                <td><?= htmlspecialchars($incident['description']) ?></td>
                <td><?= htmlspecialchars($incident['violation_type']) ?></td>
                
             
                <td><?= htmlspecialchars($incident['location']) ?></td>
                <td>
                    <a href="incident_details.php?id=<?= $incident['id'] ?>" class=" btn-primary">
                    <span class="icon-[tabler--pencil] size-5"></span>
                    </a>
                </td>
            </tr>  
                    </a>
        <?php endforeach; ?>
    <?php endif; ?>
</tbody>

                </table>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>
