<?php
session_start();
  if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}
?>
<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="../src/output.css" rel="stylesheet">
  <link rel="stylesheet" href="../node_modules/notyf/notyf.min.css">
</head>
<body style="font-family:'lor',cascadia" class="text-base-content p-10 ">
    <h1 class="text-3xl font-bold text-center">Better Matatu Dashboard</h1>
    <div class='flex justify-between'>
      <div></div> 
      <div class="flex items-center gap-4">
<div class="dropdown relative inline-flex [--auto-close:inside] [--offset:8] [--placement:bottom-end]">
        <button id="dropdown-scrollable" type="button" class="dropdown-toggle flex items-center" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
          <div class="avatar">
            <div class="">
              <span class="icon-[tabler--menu-2] size-8"></span>
            </div>
          </div>
        </button>
        <ul class="dropdown-menu dropdown-open:opacity-100 hidden min-w-60" role="menu" aria-orientation="vertical" aria-labelledby="dropdown-avatar">
        <li>
            <a class="dropdown-item" href="../includes/add_price.php">
                <span class="icon-[tabler--user] text-error"></span>
                add price
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="../includes/safety_check.php">
                <span class="icon-[tabler--user] text-error"></span>
                safty checks
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="../auth/out.php">
                <span class="icon-[tabler--login] text-error"></span>
                Sign-out
            </a>
        </li>
       
        </ul>
      </div>
  
</div>
</div>

    </div>
   <div class="flex justify-center  my-12">
    <nav class="tabs tabs-bordered" aria-label="Tabs" role="tablist" aria-orientation="horizontal">
        <button type="button" class="tab active-tab:tab-active " id="tabs-default-item-1" data-tab="#tabs-default-1" aria-controls="tabs-default-1" role="tab" aria-selected="false">
            Matatus
        </button>
        <button type="button" class="tab active-tab:tab-active active" id="tabs-default-item-2" data-tab="#tabs-default-2" aria-controls="tabs-default-2" role="tab" aria-selected="true">
            Overview
        </button>
        <button type="button" class="tab active-tab:tab-active" id="tabs-default-item-3" data-tab="#tabs-default-3" aria-controls="tabs-default-3" role="tab" aria-selected="false">
          Violations
        </button>
      </nav>
   </div>
      
      <div class="mt-4">
        <div id="tabs-default-1" class="hidden"  role="tabpanel" aria-labelledby="tabs-default-item-1">
            <div class="flex justify-center flex-col items-center ">
       
      
          <?php include 'matatu_reg.php';?>
           <?php include "driver_table.php"; ?>

           </div>
        </div>
        <div id="tabs-default-2" role="tabpanel" aria-labelledby="tabs-default-item-2">
            <div class="container mx-auto space-y-6 flex items-center justify-center flex-col">
                <div>
                    <?php include '../includes/overview.php'; ?>
                </div>
               
                <div class="card w-full max-w-4xl md:w-1/2 bg-base-100 rounded-box p-6 border border-base-success/20 overflow-x-auto mx-auto mt-10 my-4">
                    <?php include '../includes/driver_leaderboard.php'; ?>
                </div>
                <?php include '../includes/recent-sacco.php'; ?>
            </div>
        </div>
        </div>
        <div id="tabs-default-3" class="hidden" role="tabpanel" aria-labelledby="tabs-default-item-3">
          <div><?php include '../includes/vioations.php'?></div>
        </div>
      </div>

      <script>
        window.addEventListener('load', function () {
          
          flatpickr('.jsPickr', {
            allowInput: true,
            monthSelectorType: 'static'
          })
        })
      </script>
      <script src="../node_modules/datatables.net/js/dataTables.min.js"></script>
  <script src="../node_modules/flyonui/flyonui.js"></script>
  <script src="../node_modules/notyf/notyf.js"></script>


  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const notyf = new Notyf();

      <?php if ($error): ?>
        notyf.error('<?php echo htmlspecialchars($error); ?>');
      <?php endif; ?>

      <?php if ($success): ?>
        notyf.success('<?php echo htmlspecialchars($success); ?>');
      <?php endif; ?>
    });
  </script>
</body>
</html>






