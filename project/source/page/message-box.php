<?php
require_once '../action/start-session.php';

$message_box_css_classes = [
    MessageLevel::Success => "success-box",
    MessageLevel::Error => "error-box",
];
if (isset($_SESSION["notifications"])) {
?>
<div class="center">
  <div class="<?php echo $message_box_css_classes[$_SESSION["notifications"][0]->message_level]; ?>">
    <?php
    // For now, I am assuming all notifications are in the same message level
    foreach ($_SESSION["notifications"] as $notification) {
    ?>
    <p>
      <?php echo $notification->message_text; ?>
    </p>
    <?php
    }
    unset($_SESSION["notifications"]);
    ?>
  </div>
</div>
<?php
}
?>