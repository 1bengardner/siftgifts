<div>
<?php
require_once '../action/xmas-authenticate.php';
require_once '../util/utilities.php';

$stmt = "SELECT * FROM xmas_prize WHERE id=1;";
$prizes = Database::run_statement_no_params(Database::get_connection(), $stmt)->fetch_all(MYSQLI_ASSOC);
if ($prizes) {
  $prizes = $prizes[0];
} else {
  echo "<p class='widget' style='display: inline-block; padding: 1em; margin: 0 0 1em 0; border-radius: 2em;'>There are no prizes set up yet.</p></div>";
  return;
}
?>
  <details class="widget" style="display: inline-block; padding: 1em; margin: 0 0 1em 0; border-radius: 2em;"><summary style="cursor: pointer;">Prizes</summary>
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