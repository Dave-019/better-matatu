
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
   <div class="flex justify-center  my-12">
    <nav class="tabs tabs-bordered" aria-label="Tabs" role="tablist" aria-orientation="horizontal">
        <button type="button" class="tab active-tab:tab-active active" id="tabs-default-item-1" data-tab="#tabs-default-1" aria-controls="tabs-default-1" role="tab" aria-selected="true">
            Matatus
        </button>
        <button type="button" class="tab active-tab:tab-active" id="tabs-default-item-2" data-tab="#tabs-default-2" aria-controls="tabs-default-2" role="tab" aria-selected="false">
            Overview
        </button>
        <button type="button" class="tab active-tab:tab-active" id="tabs-default-item-3" data-tab="#tabs-default-3" aria-controls="tabs-default-3" role="tab" aria-selected="false">
          Violations
        </button>
      </nav>
   </div>
      
      <div class="mt-4">
        <div id="tabs-default-1" role="tabpanel" aria-labelledby="tabs-default-item-1">
            <div class="flex justify-center flex-col items-center ">
            <!--form-->
      
        <?php include 'matatu_reg.php';?>
          <?php include "driver_table.php"; ?>

       
           </div>
        </div>
        <div id="tabs-default-2" class="hidden" role="tabpanel" aria-labelledby="tabs-default-item-2">
            <div class="container mx-auto space-y-6 flex items-center justify-center flex-col">
              
                 
            <!-- Quick Stats -->
            <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="card p-4  bg-secondary/20  border border-base-success/20">
                    <h3 class="text-lg font-semibold">Total Matatus</h3>
                    <p class="text-2xl">45</p>
                </div>
                <div class="card p-4 bg-secondary/20 border border-base-success/20">
                    <h3 class="text-lg font-semibold">Total Drivers</h3>
                    <p class="text-2xl">52</p>
                </div>
                <div class="card p-4 bg-secondary/20 border border-base-success/20">
                    <h3 class="text-lg font-semibold">Active Violations</h3>
                    <p class="text-2xl">8</p>
                </div>
                <div class="card p-4 bg-secondary/20 border border-base-success/20">
                    <h3 class="text-lg font-semibold">Pending Approvals</h3>
                    <p class="text-2xl">3</p>
                </div>
            </div>
                        <!-- Top Performing Drivers -->
                        
            <div class="card w-full max-w-3xl md:w-1/2 bg-base-100 rounded-box p-6 border border-base-success/20 overflow-x-auto mx-auto mt-10 my-4">
                <h2 class="text-xl font-semibold mb-4"> SACCOs Leaderboard</h2>
                <table class="table-striped table">
                  <thead>
                    <tr>
                      <th>Rank</th>
                      <th>Driver Name</th>
                      <th>Rating  </th>
                      <th>Performance</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    <!-- Rank 1 -->
                    <tr>
                      <td class="text-nowrap font-bold"> 1</td>
                      <td>Super Metro</td>
                      <td> 4.9</td>
                      <td><span class="badge  badge-success text-xs">Excellent</span></td>
               
                    </tr>
                    
                    <!-- Rank 2 -->
                    <tr>
                      <td class="text-nowrap font-bold">2</td>
                      <td>Embassava</td>
                      <td> 4.7</td>
                      <td><span class="badge badge-soft badge-primary text-xs">Very Good</span></td>
              
                    </tr>
                    
                    <!-- Rank 3 -->
                    <tr>
                      <td class="text-nowrap font-bold"> 3</td>
                      <td>City Hoppa</td>
                      <td> 4.5</td>
                      <td><span class="badge badge-soft badge-info text-xs">Good</span></td>
                   
                    </tr>
                    
                  
              
                  </tbody>
                </table>
              </div>
                        
                <!-- Recent Reports -->
                <div class="card p-6 bg-base-100  rounded-box border border-base-success/20 max-w-3xl md:w-1/2">
                <h2 class="text-xl font-semibold mb-4">Recent Reports</h2>
                <ol>
                    <div>
                        <li class="flex justify-between py-2">
                            Reckless Driving
                            <p class="text-xs"><span class="badge badge-warning rounded-md">Pending</span></p>
                            
                       </li>
                       <li class="border-b flex justify-between py-2">
                             KBZ 123X - John Doe - Westlands 
                             <div> 2 hours ago</div>
                       </li>
                    </div>
                    <div>
                        <li class="flex justify-between py-2">
                            Reckless Driving
                            <p class="text-xs"><span class="badge badge-warning rounded-md">Pending</span></p>
                            
                       </li>
                       <li class="border-b flex justify-between py-2">
                             KBZ 123X - John Doe - Westlands 
                             <div> 2 hours ago</div>
                       </li>
                    </div>
                    <div>
                        <li class="flex justify-between py-2">
                            Reckless Driving
                            <p class="text-xs"><span class="badge badge-warning rounded-md">Pending</span></p>
                            
                       </li>
                       <li class="border-b flex justify-between py-2">
                             KBZ 123X - John Doe - Westlands 
                             <div> 2 hours ago</div>
                       </li>
                    </div>
                </ol>
            </div>
            </div>
        </div>
        <div id="tabs-default-3" class="hidden" role="tabpanel" aria-labelledby="tabs-default-item-3">
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





