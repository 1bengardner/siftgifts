<div style="margin: 1em;">
<?php
require_once '../util/utilities.php';
require_once '../action/authenticate.php';
require_once '../data/user.php';

// TODO: Remove ID validation once prize retrieval is based on ID
$user = User::get_from_id($_SESSION['id']);
if (!in_array($user->id, [1, 2])) {
  $_SESSION["notifications"] = [new Notification(NotificationText::NoPermission, NotificationLevel::Error)];
  header("Location: /home");
  exit;
}

$stmt = "CALL get_prizes(?)";
$prizes = Database::run_statement(Database::get_connection(), $stmt, [$_SESSION['id']])->fetch_all(MYSQLI_ASSOC);
if ($prizes) {
  $prizes = $prizes[0];
} else {
  echo "<p class='widget' style='display: inline-block; padding: 1em; margin: 0 0 1em 0; border-radius: 2em;'>Cannot view prizes. You are not enrolled in a lottery.</p></div>";
  return;
}
?>
  <details class="widget" style="display: inline-block; padding: 1em; margin: 0 0 1em 0; border-radius: 2em;"><summary style="cursor: pointer;">Prizes 🏆</summary>
    <div>
      <p>Seven numbers will be drawn.</p><p class="subheading">If one or more of yours match, you win!</p>
    </div>
    <div style="display: inline-block;">
    <ul style="margin: 0; text-align: left;">
      <style>
        .prize-identifier {
          display: inline-block;
          width: 2em;
        }
      </style>
<?php
  for ($i = 1; $i <= 7; $i++) {
    echo "<li><strong class='prize-identifier'>{$i}/7</strong>{$prizes[$i]}</li>";
  }
?>
    </ul>
    </div>
  </details>
</div>