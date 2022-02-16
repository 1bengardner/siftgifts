<?php
require_once '../util/utilities.php';
require_once '../data/gift.php';

// Get user gifts from db
$stmt = "SELECT * FROM gift WHERE user=? AND active=1 ORDER BY id DESC";
$res = Database::run_statement(Database::get_connection(), $stmt, [$_GET['user']]);
$gifts = $res->fetch_all(MYSQLI_ASSOC);

foreach ($gifts as $gift_data) {
  $gift = new Gift($gift_data);

  // Display each gift - this is HTML
?>
<div class="widget restaurant-widget focused">
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
    </div>
    <p class="right no-wrap">
      <?php $var = $gift->id; ?>
      <span class="admin-reserve" display-when-toggled="inline-block">
        <input gift="<?php echo $var; ?>" id="reserve-<?php echo $var; ?>" type="checkbox" onclick="toggle(this);" <?php if ($gift->reserved) echo 'checked' ?> />
        <label for="reserve-<?php echo $var; ?>">Reserve<?php if ($gift->reserved) echo 'd' ?></label>
      </span>
      <button gift="<?php echo $var; ?>" id="remove-<?php echo $var; ?>" type="button" value="❌" onclick="remove(this.getAttribute('gift'), '<?php echo $gift->name; ?>');"></button>
      <label class="delete-button" for="remove-<?php echo $var; ?>">❌</label>
    </p>
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
