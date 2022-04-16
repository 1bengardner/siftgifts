<!DOCTYPE html>
<html>
  <?php define('TITLE', 'Send a message'); ?>
  <?php include 'head.php'; ?>
  <body>
    <?php include 'header.php'; ?>
    <form id="message-form" enctype="multipart/form-data" onsubmit="send()">
    <?php $recipient = isset($_GET['to']) ? htmlentities($_GET['to']) : null; ?>
      <h2>Send a message<?php if (isset($recipient)) echo " to ".$recipient; ?></h2>
      <div hidden id="notifications">
        <div class="success-box">
          <p>Sent!</p>
        </div>
      </div>
      <div>
        <input id="to" type="name" placeholder="Recipient" maxlength="255" <?php if (isset($recipient)) echo "value='".$recipient."'"; ?> required />
      </div>
      <div>
        <input id="from" type="name" placeholder="Your name" maxlength="255" />
      </div>
      <div>
        <span class="subheading">(Leave your name blank to send anonymously)</span>
      </div>
      <div>
        <textarea id="message" class="message" placeholder="Message" maxlength="5000" required></textarea>
      </div>
      <div>
        <input class="submit-button" type="submit" value="Send message"/>
      </div>
      <div class="links-section">
        <a class="link" href="/wishlist<?php  if (isset($recipient)) echo '/'.$recipient; ?>">Return to <?php  if (isset($recipient)) echo $recipient."'s"; ?> wishlist</a>
      </div>
    </form>
  </body>
  <script src="/page/js/send-message.js" type="text/javascript"></script>
  <script src="/page/js/extra-flavour.js" type="text/javascript"></script>
</html>