<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="./src/output.css" rel="stylesheet">
  <!-- Ensure the font 'lor' is available or use a fallback font -->
  

</head>
<body class="bg-base-100 text-base-content font-lor text-base">
 <?php include "includes/search_comp.php"; ?>
<div> 
  <?php include "includes/sacco_leaderboard.php"; ?>
  <?php include "includes/recent_reports.php"; ?>
  <!--price-->
  <div class="card w-full max-w-2xl md:w-1/2 bg-base-100 mx-auto rounded-box border border-base-success/20 overflow-x-auto">
    <table class="table-borderless table">
      <thead>
        <tr>
          <th class="border-b-1 border-info/20 pb-1">Service</th>
          <th class="border-b-2 border-info/20 pb-2">Price</th>
          <th class="">Duration</th>
        </tr>
      </thead>
      <tbody>
        <!-- Price 1 -->
        <tr>
          <td class="text-nowrap">Standard Ride</td>
          <td>KSh 150</td>
          <td>30 minutes</td>
        </tr>
  
        <!-- Price 2 -->
        <tr>
          <td class="text-nowrap">Express Ride</td>
          <td>KSh 300</td>
          <td>15 minutes</td>
        </tr>
  
        <!-- Price 3 -->
        <tr>
          <td class="text-nowrap">VIP Ride</td>
          <td>KSh 500</td>
          <td>45 minutes</td>
        </tr>
  
        <!-- Price 4 -->
        <tr>
          <td class="text-nowrap">Night Ride</td>
          <td>KSh 350</td>
          <td>1 hour</td>
        </tr>
  
        <!-- Price 5 -->
        <tr>
          <td class="text-nowrap">Student Discount Ride</td>
          <td>KSh 100</td>
          <td>30 minutes</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
  


<script src="./node_modules/flyonui/flyonui.js"></script>
</body>
</html>