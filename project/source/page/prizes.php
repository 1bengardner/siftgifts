<div>
<?php
require_once '../util/utilities.php';
require_once '../action/authenticate.php';

$stmt = "CALL get_winning_ticket(?)";
$res = Database::run_statement(Database::get_connection(), $stmt, [$_SESSION['id']])->fetch_all(MYSQLI_NUM);
if (!$res) {
  echo "<p class='widget' style='display: inline-block; padding: 1em; margin: 0 0 1em 0; border-radius: 2em;'>Cannot view prizes. You are not enrolled in a lottery.</p>";
  exit;
}
?>
  <details class="widget" style="display: inline-block; padding: 1em; margin: 0 0 1em 0; border-radius: 2em;"><summary style="cursor: pointer;">Prizes 🆕</summary>
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
      <li><strong class="prize-identifier">1/7</strong>🔁 Free play</li>
      <li><strong class="prize-identifier">2/7</strong>🪛 Small duty</li>
      <li><strong class="prize-identifier">3/7</strong>👹 Shrek</li>
      <li><strong class="prize-identifier">4/7</strong>🎁 Present</li>
      <li><strong class="prize-identifier">5/7</strong>💵 $500</li>
      <li><strong class="prize-identifier">6/7</strong>💰 $5,000</li>
      <li><strong class="prize-identifier">7/7</strong>🛁 Bathroom renovation</li>
    </ul>
    </div>
  </details>
</div>