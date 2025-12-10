<?php
require_once '../util/utilities.php';
require_once '../action/authenticate.php';

$stmt = "CALL get_conversations(?)";
$res = Database::run_statement(Database::get_connection(), $stmt, [$_SESSION['id']]);
$msgs = $res->fetch_all(MYSQLI_ASSOC);
if (count($msgs) === 0) {
?>
<div class="widget focused center">
  <h2>No messages.</h2>
</div>
<?php
} else {
?>
<div class="message-grid">
  <div class="message-chooser visible-on-mobile">
    <?php include 'show-message-previews.php' ?>
  </div>
  <div class="message-viewer">
    <span class="mobile-navigation"><a title="Return to messages" href onclick="
      document.querySelector('.message-viewer').classList.remove('visible-on-mobile');
      document.querySelector('.message-chooser').classList.add('visible-on-mobile');
      event.preventDefault();
    ">🔙</a></span>
    <span class="conversation-partner"></span>
    <div class="message-content"><div class="center">Select a sender on the left to open the conversation.</div></div>
    <form id="message-form" class="unbreakable" method="post"></form>
  </div>
</div>
<!-- <span class="mobile-navigation" style="position: sticky; bottom: 0; cursor: pointer;"><a title="Jump to top" onclick="window.scrollTo({ top: 0, behavior: 'smooth' });">🔝</a></span> -->
<?php
}
?>