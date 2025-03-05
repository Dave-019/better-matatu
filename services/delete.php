<?php
session_start();
require_once '../auth/config.php';

$matatuId = isset($_POST['id']) ? intval($_POST['id']) : 0;
$error = '';
$success = false;

if ($matatuId > 0) {
    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("SELECT driver_id FROM matatus WHERE id = ?");
        $stmt->execute([$matatuId]);
        $driverId = $stmt->fetchColumn();

        $stmt = $pdo->prepare("DELETE FROM matatus WHERE id = ?");
        $stmt->execute([$matatuId]);

        if ($driverId) {
            $stmt = $pdo->prepare("DELETE FROM drivers WHERE id = ?");
            $stmt->execute([$driverId]);
        }

        $pdo->commit();
        $success = true;
    } catch (PDOException $e) {
        
        $pdo->rollBack();
        $error = "Database error: " . $e->getMessage();
    }
} else {
    $error = "Invalid matatu ID.";
}

header("Location: ../auth/delete.php?" . ($success ? "success=1" : "error=1"));
exit;
?>
