<?php
if (!isset($id)) {
  echo "how did u find me";
  exit;
}
?>
<!DOCTYPE html>
<html>
  <?php
  require_once '../data/user.php';

  $username = User::get_from_id($id)->username;
  ?>
  <?php define('TITLE', ucwords(strtolower($username))."'s wishlist"); ?>
  <?php include 'head.php'; ?>
  <body>
    <?php include 'header.php' ?>
    <div class="center">
      <h1 class="wishlist-header"><?php echo ucwords(strtolower($username)) ?>'s Wishlist</h1>
      <a title="Send a message to <?php echo ucwords(strtolower($username)) ?>" href="/send-message?to=<?php echo ucwords(strtolower($username)); ?>">📮</a>
    </div>
    <form>
      <span class="unbreakable"><input id="search" type="search" name="q" placeholder="Search for a gift&hellip;" />🔍</span>
    </form>
    <div class="center">
      <?php
        require_once '../action/start-session.php';
        if (isset($_SESSION["id"]) && $_SESSION['id'] === $id) {
          echo '<p><strong>HEY!</strong> No peeking! <a href="/wishlist">Manage your wishlist</a> instead.</p>';
        } else {
          $_GET['user']=$id;
          include '../action/show-gifts-for-user.php';
        }
      ?>
    </div>
  </body>
  <script src="/page/js/search.js" type="text/javascript"></script>
  <script src="/page/js/reserve.js?v=2" type="text/javascript"></script>
  <script type="text/javascript">
    /*
      Show which gifts the device user reserved and enable unreserve
    */
    const reservedGifts = memory.get();
    for (const id of reservedGifts) {
      // Gift was unreserved by someone else
      if (!document.getElementById(id).closest(".reserved")) {
        continue;
      }
      document.getElementById(id).value = "Unreserve?";
      document.getElementById(id).disabled = false;
      document.getElementById(id).onclick = () => unreserve(id);
    }
  </script>
</html>