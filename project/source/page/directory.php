<!DOCTYPE html>
<html>
  <?php require '../action/find-wishlist.php'; ?>
  <?php define('TITLE', "Wishlist search"); ?>
  <?php include 'head.php'; ?>
  <body>
    <?php include 'header.php'; ?>
    <div class="center">
      <?php include 'message-box.php'; ?>
      <h1 class="center">Select a Wishlist</h1>
      <form id="wishlist-select">
        <span class="unbreakable">
          <input id="search" list="users" name="u" placeholder="Search for someone&hellip;" value="<?php if (isset($_GET['u'])) echo $_GET['u'] ?>" />
          <button class="search-button" type="submit" title="Find wishlist">🔍</button>
        </span>
        <datalist id="users">
          <?php
          require_once '../util/utilities.php';
          if (isset($_SESSION['id'])) {
            $stmt = "SELECT * FROM user WHERE id != ? ORDER BY username ASC";
            $res = Database::run_statement(Database::get_connection(), $stmt, [$_SESSION['id']]);            
          } else {
            $stmt = "SELECT * FROM user ORDER BY username ASC";
            $res = Database::run_statement_no_params(Database::get_connection(), $stmt);
          }
          $users = $res->fetch_all(MYSQLI_ASSOC);

          foreach ($users as $user_data) {
            $user = new User($user_data);
            echo '<option user-id="'.$user->id.'" value="'.$user->username.'">';
          }
          ?>
        </datalist>
      </form>
    </div>
  </body>
</html>