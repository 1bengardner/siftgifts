<!DOCTYPE html>
<html>
  <?php define('TITLE', 'Send a message'); ?>
  <?php include 'head.php'; ?>
  <body>
    <?php include 'header.php'; ?>
    <?php $recipient = isset($_GET['to']) ? htmlentities($_GET['to']) : null; ?>
    <form id="message-form" enctype="multipart/form-data" onsubmit="send();">
      <h2>Send a message<?php if (isset($recipient)) echo " to ".$recipient; ?></h2>
      <div hidden id="notifications">
        <div class="success-box">
          <p>Message sent!</p>
        </div>
      </div>
      <div>
        <span>To:<input id="to" type="name" placeholder="Recipient" maxlength="255" <?php if (isset($recipient)) echo "value='".$recipient."'"; ?> required /></span>
      </div>
      <div>
        <?php require_once '../data/user.php'; ?>
        <span>From:<input id="from" type="name" placeholder="Your name" maxlength="255" <?php if (isset($_SESSION["id"]) && $_SESSION["id"]) echo "value='".ucwords(strtolower(User::get_from_id($_SESSION["id"])->username))."' disabled"; ?> /></span>
      </div>
      <?php if (!isset($_SESSION["id"]) || !$_SESSION["id"]) { ?>
        <div>
          <span class="subheading">(Leave your name blank to send anonymously)</span>
        </div>
      <?php } ?>
      <div>
        <textarea id="message" class="message" placeholder="Message" maxlength="5000" required></textarea>
      </div>
      <div>
        <input class="submit-button" type="submit" value="Send message"/>
      </div>
      <div class="links-section">
        <a class="link" href="/sg<?php if (isset($recipient)) echo '/'.strtolower($recipient); ?>">Return to <?php if (isset($recipient)) echo $recipient."'s"; ?> wishlist</a>
      </div>
    </form>
  </body>
  <script src="/page/js/send-message.js" type="text/javascript"></script>
  <script src="/page/js/extra-flavour.js" type="text/javascript"></script>
</html>