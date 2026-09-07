<!DOCTYPE html>
<html>
  <?php define('TITLE', "Private wishlists"); ?>
  <?php include 'head.php'; ?>
  <body>
    <?php include 'header.php'; ?>
    <?php include 'notification-box.php'; ?>
    <div class="center wishlist-background">
      <h1 class="center">Your Private Wishlists</h1>
      <div class="center">
      <?php
      require_once '../util/utilities.php';
      require_once '../action/authenticate.php';

      $stmt = "SELECT * FROM wishlist WHERE owner=?";
      $res = Database::run_statement(Database::get_connection(), $stmt, [$_SESSION['id']]);
      $wishlists = $res->fetch_all(MYSQLI_ASSOC);
      if (count($wishlists) > 0) {
      ?>
      <nav><ul>
      <?php
        require_once '../data/wishlist.php';
        foreach ($wishlists as $wishlist_data) {
          $wishlist = new Wishlist($wishlist_data);
      ?>
        <li style="display: block;"><h2><a href="private-wishlist/<?php echo $wishlist->short_name; ?>"><?php echo mb_strimwidth($wishlist->name, 0, 20, "…"); ?></a></h2></li>
      <?php
        }
      ?>
      </ul></nav>
      <?php
      } else {
      ?>
      <div class="widget focused center">
        <h2>No private wishlists.</h2>
      </div>
      <?php
      }
      ?>
      </div>
    </div>
  </body>
</html>