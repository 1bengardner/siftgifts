<?php
if (!isset($gift)) {
  echo "how did u find me";
  exit;
}
?>
<div class="widget gift-widget focused<?php if ($gift->mode === 'external registry') { echo ' external-registry'; } else if ($gift->reserved) { echo ' reserved'; } ?>">
  <div class="notification-box"></div>
  <div>
    <?php if ($gift->mode !== 'external registry') { ?>
    <div class="right no-wrap">
      <?php $var = $gift->id; ?>
      <input id="<?php echo $var; ?>" type="button" onclick="reserve(this.id, '<?php echo addslashes(htmlentities($gift->name)); ?>');" <?php if ($gift->reserved) echo 'disabled' ?> value="Reserve<?php if ($gift->reserved) echo 'd' ?>" />
    </div>
    <?php } ?>
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
      <?php
      if (!empty($gift->url)) {
        echo '<span class="gift-domain lighter smaller">'.htmlentities(parse_url($gift->url, PHP_URL_HOST)).'</span>';
      }
      ?>
      <?php if (!empty($gift->notes)) { ?>
        <p class="gift-notes"><?php echo nl2br(htmlentities($gift->notes)); ?></p>
      <?php } ?>
      <p class="gift-footer">
      <?php
      if ($gift->price !== NULL) {
      ?>
      <span class="lighter gift-price"><?php echo '~$'.$gift->price; ?></span>
      <?php
      }
      if ($gift->reserved && $gift->reserved_time != NULL) {
      ?>
      <span class="lighter smaller gift-date"><?php echo 'Reserved on '.date('M j \'y', strtotime($gift->reserved_time)); ?></span>
      <?php
      } else if ($gift->creation_time != NULL) {
      ?>
      <span class="lighter smaller gift-date"><?php echo 'Added on '.date('M j \'y', strtotime($gift->creation_time)); ?></span>
      <?php
      }
      ?>
      </p>
    </div>
  </div>
</div>
