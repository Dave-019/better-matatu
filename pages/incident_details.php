<?php
require '../auth/config.php';
session_start();
try {
    if (!isset($_SESSION['user_id'])) {
        throw new Exception("Unauthorized access. Please log in.");
    }

    $admin_id = $_SESSION['user_id'];

    if (!isset($_GET['id'])) {
        throw new Exception("Incident ID is missing.");
    }

    $incident_id = $_GET['id'];

    
    $stmt = $pdo->prepare("SELECT * FROM incidents WHERE id = ?");
    $stmt->execute([$incident_id]);
    $incident = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$incident) {
        throw new Exception("Incident not found.");
    }

   
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['status'], $_POST['comment'])) {
            throw new Exception("Invalid request.");
        }

        $new_status = $_POST['status'];
        $comment = $_POST['comment'];

        $pdo->beginTransaction();

      
        $stmt = $pdo->prepare("UPDATE incidents SET status = ?, timestamp = NOW() WHERE id = ?");
        $stmt->execute([$new_status, $incident_id]);

      
        $stmt = $pdo->prepare("INSERT INTO incident_updates (incident_id, updated_by, status, comment) VALUES (?, ?, ?, ?)");
        $stmt->execute([$incident_id, $admin_id, $new_status, $comment]);

        $pdo->commit();

        header("location: sacco.php");
        exit;
    }

    // Fetch timeline updates
    $stmt = $pdo->prepare("SELECT iu.*, u.name FROM incident_updates iu JOIN users u ON iu.updated_by = u.id WHERE incident_id = ? ORDER BY created_at ASC");
    $stmt->execute([$incident_id]);
    $updates = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    $error_message = $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incident Details</title>
    <link rel="stylesheet" href="../src/output.css">
</head>
<body class="bg-base-100 ">

    <div class="container mx-auto w-full sm:w-[30rem] p-6">
        <h2 class="text-2xl font-bold mb-4">Incident Details</h2>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error_message) ?></div>
        <?php else: ?>

            <div class=" p-4 rounded-lg bg-base-200/50">
                <p><strong>ID:</strong> <?= $incident['id'] ?></p>
                <p><strong>Violation:</strong> <?= htmlspecialchars($incident['violation_type']) ?></p>
                <p><strong>Description:</strong> <?= htmlspecialchars($incident['description']) ?></p>
                <p><strong>Location:</strong> <?= htmlspecialchars($incident['location']) ?></p>
                <p>
                    <strong>Status:</strong>
                    <span class="badge 
                        <?= $incident['status'] == 'pending' ? 'badge-warning' :
                            ($incident['status'] == 'reviewed' ? 'badge-info' :
                            'badge-success') ?>">
                        <?= ucfirst($incident['status']) ?>
                    </span>
                </p>
            </div>

            <h3 class="text-xl font-semibold mt-6">Update Status</h3>
            <form method="POST" class="mt-4">
                <label class="block mb-2">New Status:</label>
                <select name="status" class="select select-bordered w-full" required>
                    <option value="pending" <?= $incident['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="reviewed" <?= $incident['status'] === 'reviewed' ? 'selected' : '' ?>>Reviewed</option>
                    <option value="resolved" <?= $incident['status'] === 'resolved' ? 'selected' : '' ?>>Resolved</option>
                </select>

                <label class="block mt-4 mb-2">Comment:</label>
                <textarea name="comment" class="textarea textarea-bordered w-full" placeholder="Add a comment" required></textarea>

                <button type="submit" class="btn btn-primary mt-4">Submit</button>
            </form>
             

        <?php endif; ?>
    </div>

</body>
</html>
