<?php
require_once '../action/authenticate.php';
require_once '../data/user.php';
$user = User::get_from_id($_SESSION['id']);
if (!in_array($user->id, [1, 2])) {
  $_SESSION["notifications"] = [new Notification(NotificationText::NoPermission, NotificationLevel::Error)];
  header("Location: /home");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<?php define('TITLE', 'Travel Fund'); ?>
<?php include '../page/head.php'; ?>

<style>
#jar-wrapper {
  width: 300px;
  height: 420px;
  margin: auto;
  position: relative;
}

#paper-layer {
  position: absolute;
  top: 0;
  left: 0;
}
</style>

<body>
<?php include '../page/header.php'; ?>
<div class="center">

  <h1>Travel Fund</h1>

  <div id="jar-wrapper">

    <!-- Jar SVG -->
    <svg width="300" height="420" viewBox="0 0 300 420">

      <!-- Clip path -->
      <defs>
        <clipPath id="jar-clip">
        <path d="
          M85 110
          Q85 85 115 85
          L185 85
          Q215 85 215 110
          L250 260
          Q250 340 170 360
          L130 360
          Q50 340 50 260
          Z
        "/>
        </clipPath>
      </defs>

      <!-- Body -->
      <path d="
        M85 110
        Q85 85 115 85
        L185 85
        Q215 85 215 110

        L250 260
        Q250 340 170 360
        L130 360
        Q50 340 50 260

        Z
      "
      fill="rgba(180,210,255,0.35)"
      stroke="#d9e6fa"
      stroke-width="4"/>

      <!-- Neck -->
      <rect x="115" y="50" width="70" height="35" rx="12"
          fill="rgba(180,210,255,0.35)"
          stroke="#d9e6fa"
          stroke-width="4"/>

      <!-- Opening -->
      <ellipse cx="150" cy="50" rx="45" ry="12"
           fill="rgba(200,220,255,0.6)"
           stroke="#d9e6fa"
           stroke-width="4"/>

    </svg>

    <!-- Papers -->
    <svg id="paper-layer" width="300" height="420"
       style="clip-path: url(#jar-clip);">

      <!-- Highlight -->
      <path d="
        M110 100
        Q120 90 130 100
        L130 300
        Q125 320 115 300
        Z"
      fill="rgba(255,255,255,0.25)"/></svg>

  </div>

  <div id="total">Total: $0.00</div>

  <form onsubmit="event.preventDefault();">
    <input id="contribution-source" type="text" placeholder="Source" required>
    <input id="contribution-amount" type="number" step="0.01" placeholder="Amount" required>
    <button id="submit" type="submit" class="clipboard-button">Add</button>
  </form>

  <div id="notification-container"></div>

</div>
<script src="travel-fund.js"></script>
</body>
</html>