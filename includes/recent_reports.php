<?php
include './db_connection.php';

// Fetch recent incidents
$sql = "SELECT 
        i.id AS incident_id, 
        i.violation_type, 
        i.status, 
        i.description, 
        i.details, 
        i.timestamp, 
        i.image_path, 
        i.location,
        m.reg_num AS matatu_route 
        FROM incidents i 
        LEFT JOIN matatus m ON i.matatu_id = m.id 
        ORDER BY i.timestamp DESC 
        LIMIT 4";

$result = $conn->query($sql);

$incidents = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $incidents[] = $row;
    }
}

$conn->close();
?>
 
<div class="mt-10 flex flex-col items-center">
    <div class="text-xl mb-4 cursor-pointer text-base-content">
        Recent reports
    </div>
    <div class="min-h-screen flex">
        <div class="flex flex-wrap justify-center gap-4 max-w-4xl p-6">
            <?php foreach ($incidents as $incident): ?>
                <div class="card sm:max-w-sm bg-base-100 rounded-box border border-info/20 ">
                    <div class="card-body">
                        <div class="flex justify-between gap-4">
                            <h5 class="card-title text-info text-xl font-semibold mb-2.5"><?php echo htmlspecialchars($incident['violation_type']); ?></h5>
                            <p class="text-xs">
                                <span class="badge 
                                    <?php 
                                    switch ($incident['status']) {
                                        case 'pending': echo 'badge-warning'; break;
                                        case 'penalized': echo 'badge-error'; break;
                                        case 'reviewed': echo 'badge-info'; break;
                                        case 'resolved': echo 'badge-success'; break;
                                        default: echo ''; break;
                                    }
                                    ?> rounded-md">
                                    <?php echo htmlspecialchars(ucfirst($incident['status'])); ?>
                                </span>
                            </p>
                        </div>
                        <p class="text-sm  text-base-content/70"><span class="icon-[tabler--car] text-base-content/50 mr-1"></span> <?php echo htmlspecialchars(strtoupper($incident['matatu_route'])); ?></p>
                        <p class="text-xs text-base-content/50"><span class="icon-[tabler--map-pin] text-base-content/50 mr-1"></span><?php echo htmlspecialchars($incident['location']); ?></p>
                        <p class="text-xs text-base-content/50"><span class="icon-[tabler--calendar] text-base-content/50 mr-1"></span> <?php echo htmlspecialchars(date('Y-m-d', strtotime($incident['timestamp']))); ?></p>
                        <p class="text-secondary-content"><?php echo htmlspecialchars($incident['description']); ?></p>
                        <p class="text-xs text-base-content/50  "><?php echo htmlspecialchars($incident['details']); ?></p>
                    </div>
                    <?php if ($incident['image_path']): ?>
                        <figure class="p-4">
                            <img src="<?php echo htmlspecialchars($incident['image_path']); ?>" 
                                 alt="Incident Image" 
                                 class="object-cover w-full h-48 rounded-md" />
                        </figure>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>