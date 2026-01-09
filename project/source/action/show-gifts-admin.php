<?php
require_once '../util/utilities.php';
require_once '../data/gift.php';
require_once 'authenticate.php';

// Get user gifts from db
$stmt = "SELECT * FROM gift WHERE user=? AND active=1 ORDER BY id DESC";
$res = Database::run_statement(Database::get_connection(), $stmt, [$_SESSION['id']]);
$gifts = $res->fetch_all(MYSQLI_ASSOC);

foreach ($gifts as $gift_data) {
  $gift = new Gift($gift_data);
  include '../page/gift-template-admin.php';
}
if (count($gifts) === 0) {
?>
<div class="widget focused center">
  <h2>No gifts added yet.</h2>
</div>
<?php
}
?>
<script src="/page/js/show-gifts.js" type="module"></script>
