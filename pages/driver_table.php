<?php

require_once 'config.php';


$matatus = [];
$error = '';
$successMessage = '';

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    try {
        $stmt = $pdo->prepare("SELECT sacco_id FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && isset($user['sacco_id'])) {
            $saccoId = $user['sacco_id'];

            $stmt = $pdo->prepare("SELECT m.id, m.reg_num, m.route_number, m.seat_capacity, m.status, m.created_at, 
                                          d.name AS driver_name, s.name AS sacco_name
                                   FROM matatus m
                                   LEFT JOIN drivers d ON m.driver_id = d.id
                                   LEFT JOIN sacco_cooperatives s ON m.sacco_id = s.id
                                   WHERE m.sacco_id = ?");
            $stmt->execute([$saccoId]);
            $matatus = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $error = "Sacco not found for this user.";
        }
    } catch (PDOException $e) {
        $error = "Database error: " . $e->getMessage();
    }
}
if (isset($_GET['success']) && $_GET['success'] == 1) {
    $successMessage = "Matatu deleted successfully.";
} elseif (isset($_GET['error']) && $_GET['error'] == 1) {
    $error = "Failed to delete matatu.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../src/output.css" rel="stylesheet">
    <style>
        @media (min-width: 640px) {
            .table {
                width: 100%;
                overflow-x: auto;
            }

            .table tr {
                display: table-row;
            }

            .table th,
            .table td {
                display: table-cell;
            }
        }
    </style>
</head>

<body class="font-['cascadia','lora']">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl text-center font-semibold my-4">Registered Matatus</h1>
        <?php if (!empty($error)): ?>
            <div class="alert alert-error mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current flex-shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <span><?php echo htmlspecialchars($error); ?></span>
            </div>
        <?php endif; ?>

        <div class="overflow-x-auto sm:mx-auto sm:w-4/5">
            <table class="table w-full ">
                <thead>
                    <tr class="text-sm text-left">
                        <th class="whitespace-nowrap">Registration Number</th>
                        <th class="whitespace-nowrap">Driver</th>
                        <th class="whitespace-nowrap">Status</th>
                        <th class="whitespace-nowrap">Created At</th>
                        <th class="whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($matatus) && !empty($matatus)): ?>
                        <?php foreach ($matatus as $matatu): ?>
                            <tr class="bg-primary/10">
                                <td class="whitespace-nowrap"><?php echo htmlspecialchars($matatu['reg_num']); ?></td>
                                <td class="whitespace-nowrap"><?php echo htmlspecialchars($matatu['driver_name']); ?></td>
                                <td>
                                    <?php
                                    $statusClass = '';
                                    switch ($matatu['status']) {
                                        case 'active':
                                            $statusClass = 'badge-soft badge-success';
                                            break;
                                        case 'maintenance':
                                            $statusClass = 'badge-soft badge-warning';
                                            break;
                                        case 'suspended':
                                            $statusClass = 'badge-soft badge-error';
                                            break;
                                        default:
                                            $statusClass = 'badge-soft badge-info';
                                    }
                                    ?>
                                    <span class="badge <?php echo $statusClass; ?> text-xs"><?php echo htmlspecialchars($matatu['status']); ?></span>
                                </td>
                                <td class="whitespace-nowrap"><?php echo htmlspecialchars(date('F j, Y', strtotime($matatu['created_at']))); ?></td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <a href="../services/edit_matatu.php?id=<?php echo htmlspecialchars($matatu['id']); ?>" class="btn btn-circle btn-text btn-sm" aria-label="Edit matatu">
                                            <span class="icon-[tabler--pencil] size-5"></span>
                                        </a>
                                        <form action="../services/delete.php" method="post" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this matatu?')">
                                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($matatu['id']); ?>">
                                            <button type="submit" class="btn btn-circle btn-text btn-sm" aria-label="Delete matatu">
                                                <span class="icon-[tabler--trash] size-5"></span>
                                            </button>
                                        </form>
                                        <button class="btn btn-circle btn-text btn-sm" aria-label="More actions">
                                            <span class="icon-[tabler--dots-vertical] size-5"></span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-gray-500">No matatus registered.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

