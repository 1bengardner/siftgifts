<?php
if (!isset($gift)) {
  echo "how did u find me";
  exit;
}
?>
<div class="widget gift-widget focused<?php if ($gift->reserved) echo ' reserved' ?>">
  <div>
    <div class="right no-wrap">
      <?php $var = $gift->id; ?>
      <input id="<?php echo $var; ?>" type="button" onclick="reserve(this.id, '<?php echo htmlentities($gift->name); ?>');" <?php if ($gift->reserved) echo 'disabled' ?> value="Reserve<?php if ($gift->reserved) echo 'd' ?>" />
    </div>
    <div>
      <h2 class="gift-name">
        <?php
        if (empty($gift->url)) {
          echo htmlentities($gift->name);
        } else {
        ?>
        <a class="link" href="<?php echo $gift->url ?>">
          <?php echo htmlentities($gift->name); ?>
        </a>
        <?php } ?>
      </h2>
      <?php if (!empty($gift->notes)) { ?>
        <p class="subheading gift-notes"><?php echo nl2br(htmlentities($gift->notes)); ?></p>
      <?php }
      if ($gift->reserved && $gift->reserved_time != NULL) {
      ?>
      <p class="lighter smaller"><em><?php echo 'Reserved on '.date('M j \'y', strtotime($gift->reserved_time)); ?></em></p>
      <?php
      } else if ($gift->creation_time != NULL) {
      ?>
      <p class="lighter smaller"><em><?php echo 'Added on '.date('M j \'y', strtotime($gift->creation_time)); ?></em></p>
      <?php
      }
      ?>
    </div>
  </div>
</div>
