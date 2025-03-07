<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../src/output.css">
</head>
<body>
  <div class="w-full sm:w-1/2 mx-auto">
  <ul class="timeline timeline-snap-icon timeline-compact timeline-vertical w-full">
  <?php
  require '../auth/config.php';
  $incident_id = $_GET['id'];
  $query = "SELECT * FROM incident_updates WHERE incident_id = ? ORDER BY created_at DESC";
  $stmt = $pdo->prepare($query);
  $stmt->execute([$incident_id]);
  $updates = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
  if (empty($updates)) {
    // Default pending timeline item
    echo '<li>
      <hr />
      <div class="timeline-middle">
        <span class="bg-warning/20 flex size-4.5 items-center justify-center rounded-full">
          <span class="badge badge-warning size-3 rounded-full p-0"></span>
        </span>
      </div>
      <div class="timeline-end ms-2 m-3 w-full rounded-lg bg-base-200/50 mb-0 ms-1 w-5/6 sm:w-3/4 rounded-lg p-4 pt-1">
        <div class="text-base-content pt-0.5 mb-3 flex gap-2 font-medium max-sm:flex-col-reverse sm:items-center sm:justify-between">
          <span>Incident Pending</span>
          <span class="text-base-content/50 text-sm font-normal">Just now</span>
        </div>
        <p class="mb-2">The report is under review</p>
      </div>
      <hr /> 
    </li> <div class="flex justify-center item-center my-8 bg-base-300 ms-2 m-3 w-full rounded-lg mb-0 ms-1 w-5/6 sm:w-3/4 rounded-lg p-4 pt-1">
     The sacco team is doing the best to get resloved.😉
</div> ';
  } else {
    foreach ($updates as $update) {
      $statusClass = [
        'pending' => 'bg-warning/20 badge-warning',
        'reviewed' => 'bg-info/20 badge-info',
        'resolved' => 'bg-success/20 badge-success'
      ][$update['status']];
  ?>
  <li>
    <hr />
    <div class="timeline-middle">
      <span class="<?php echo $statusClass; ?> flex size-4.5 items-center justify-center rounded-full">
        <span class="badge <?php echo explode(' ', $statusClass)[1]; ?> size-3 rounded-full p-0"></span>
      </span>
    </div>
    <div class="timeline-end ms-2 m-3 w-full rounded-lg bg-base-200/50 mb-0 ms-1 w-5/6 sm:w-3/4 rounded-lg p-4 pt-1">
      <div class="text-base-content pt-0.5 mb-3 flex gap-2 font-medium max-sm:flex-col-reverse sm:items-center sm:justify-between">
        <span>Incident <?php echo ucfirst($update['status']); ?></span>
        <span class="text-base-content/50 text-sm font-normal">
          <?php echo date('M d, Y h:i A', strtotime($update['created_at'])); ?>
        </span>
      </div>
      <p class="mb-2  font-bold"><?php echo htmlspecialchars($update['comment'] ?? 'No comment'); ?></p>
      <div class="flex gap-2">
        <div class="avatar">
          <div class="size-8 rounded-full">
          </div>
        </div>
        <div class="text-sm">
          <p class="font-medium italic text-base-content/50">Updated by admin: <?php echo $update['updated_by']; ?></p>
        </div>
      </div>
    </div>
    <hr />
  </li>
  <?php }} ?>
</ul>


  </div>
</body>
</html>
