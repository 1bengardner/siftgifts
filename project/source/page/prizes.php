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
// Special case for NYE draw
if (array_shift($res[0]) == 6) {
?>
  <details class="widget" style="display: inline-block; padding: 1em; margin: 0 0 1em 0; border-radius: 2em;"><summary style="cursor: pointer;">Prizes 🎊</summary>
    <div>
      <p>Seven numbers will be drawn.</p><p class="subheading">If one or more of yours match, you win!</p>
    </div>
    <div style="display: inline-block;">
    <ul style="margin: 0; text-align: left;">
      <li><strong>1/7</strong>: Free play</li>
      <li><strong>2/7</strong>: Good luck throughout 2025</li>
      <li><strong>3/7</strong>: Anything from your wishlist</li>
      <li><strong>4/7</strong>: $100</li>
      <li><strong>5/7</strong>: $500</li>
      <li><strong>6/7</strong>: $9,000</li>
      <li><strong>7/7</strong>: A guppy</li>
    </ul>
    </div>
  </details>
<?php
} else {
?>
  <details class="widget" style="display: inline-block; padding: 1em; margin: 0 0 1em 0; border-radius: 2em;"><summary style="cursor: pointer;">Prizes 🆕</summary>
    <div>
      <p>Seven numbers will be drawn.</p><p class="subheading">If one or more of yours match, you win!</p>
    </div>
    <div style="display: inline-block;">
    <ul style="margin: 0; text-align: left;">
      <li><strong>1/7</strong>: Free play</li>
      <li><strong>2/7</strong>: A Lotto Max ticket</li>
      <li><strong>3/7</strong>: Dinner</li>
      <li><strong>4/7</strong>: Anything from your wishlist</li>
      <li><strong>5/7</strong>: $500</li>
      <li><strong>6/7</strong>: $5,000</li>
      <li><strong>7/7</strong>: A tiny dog</li>
    </ul>
    </div>
  </details>
<?php
}
?>
</div>