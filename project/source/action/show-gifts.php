<?php
require_once '../util/utilities.php';
require_once '../data/gift.php';

// Get user gifts from db
$stmt = "SELECT * FROM gift WHERE user=? AND active=1 ORDER BY reserved ASC, id DESC";
$res = Database::run_statement(Database::get_connection(), $stmt, [$_GET['user']]);
$gifts = $res->fetch_all(MYSQLI_ASSOC);

foreach ($gifts as $gift_data) {
  $gift = new Gift($gift_data);

  // Display each gift - this is HTML
?>
<div class="widget restaurant-widget focused<?php if ($gift->reserved) echo ' reserved' ?>">
  <div class="grid">
    <div>
      <h2 class="restaurant-name">
        <?php
        if (empty($gift->url)) {
          echo $gift->name;
        } else {
        ?>
        <a class="link" href="<?php echo $gift->url ?>">
          <?php echo $gift->name; ?>
        </a>
        <?php } ?>
      </h2>
      <?php if (!empty($gift->notes)) { ?>
        <p class="subheading"><?php echo $gift->notes; ?></p>
      <?php } ?>
      <p class="lighter"><em><?php echo date('M j \'y', strtotime($gift->creation_time)); ?></em></p>
    </div>
    <div class="right no-wrap">
      <?php $var = $gift->id; ?>
      <input id="<?php echo $var; ?>" type="checkbox" onclick="reserve(this.id, '<?php echo $gift->name; ?>');" <?php if ($gift->reserved) echo 'checked disabled' ?> />
      <label for="<?php echo $var; ?>">Reserve<?php if ($gift->reserved) echo 'd' ?></label>
    </div>
  </div>
</div>
<?php
}
if (count($gifts) === 0) {
?>
<div class="widget focused center">
  <h2>No gifts added yet.</h2>
</div>
<?php
}
?>
