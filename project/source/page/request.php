<!DOCTYPE html>
<html>
  <?php define('TITLE', 'Add a new gift'); ?>
  <?php include 'head.php'; ?>
  <body>
    <?php include 'header.php'; ?>
    <?php require_once '../action/authenticate.php'; ?>
    <form id="request-form" enctype="multipart/form-data" onsubmit="request()">
      <h2>Add to your wishlist</h2>
      <div hidden id="message">
        <div class="success-box">
          <p>Added!</p>
        </div>
      </div>
      <div>
        <input id="name" type="name" placeholder="Gift name" maxlength="255" required />
      </div>
      <div>
        <input id="url" type="url" placeholder="URL link" maxlength="255" />
      </div>
      <div>
        <textarea id="comments" class="comments" placeholder="Additional comments?" maxlength="255"></textarea>
      </div>
      <div>
        <input class="submit-button" type="submit" value="Add gift"/>
      </div>
      <div class="links-section">
        <a class="link" href="wishlist">Return to wishlist</a>
      </div>
    </form>
  </body>
  <script src="/page/js/request.js" type="text/javascript"></script>
  <script src="/page/js/extra-flavour.js" type="text/javascript"></script>
</html>