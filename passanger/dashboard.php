<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="../src/output.css" rel="stylesheet">

  <?php
  session_start();
  require '../db_connection.php';

  if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

  $firstName = $_SESSION['name'];
  $initial = strtoupper(substr($firstName, 0, 1));
  ?>

</head>
<body class="bg-base-100 text-base-content font-lor text-base">
 <?php include "search_comp.php"; ?>
<div> 
  <?php include "sacco_leaderboard.php"; ?>
  <?php include "recent_reports.php"; ?>
<?php include "pricing.php"; ?>
</div>
  


<script src="../node_modules/flyonui/flyonui.js"></script>
</body>
</html>
