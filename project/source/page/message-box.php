<?php
require_once '../action/start-session.php';

$message_box_css_classes = [
    NotificationLevel::Success => "success-box",
    NotificationLevel::Error => "error-box",
    NotificationLevel::Info => "info-box",
];
if (isset($_SESSION["notifications"])) {
?>
<div class="center">
  <div class="<?php echo $message_box_css_classes[$_SESSION["notifications"][0]->level]; ?>">
    <?php
    // For now, I am assuming all notifications are in the same level
    foreach ($_SESSION["notifications"] as $notification) {
    ?>
    <p>
      <?php echo $notification->text; ?>
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