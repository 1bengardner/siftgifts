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
    <div class="back-navigation"><a title="Return to messages" href onclick="navigateToChooser(event)">◀️</a></div>
    <div class="conversation-partner"></div>
    <div class="message-content"><div class="center">Select a message to expand the conversation.</div></div>
    <form id="message-form" class="unbreakable" method="post"></form>
  </div>
</div>
<?php
}
?>