<?php
if (!isset($gift)) {
  echo "how did u find me";
  exit;
}
?>
<div class="widget gift-widget focused">
  <form action="/edit" method="post" style="margin: 0;">
    <input type="hidden" name="gift" value="<?php echo $gift->id; ?>" />
    <input class="edit-widget" type="submit" value="✏ Edit" />
  </form>
  <div>
    <div class="right no-wrap">
      <span class="admin-reserve" display-when-toggled="inline-block">
        <input style="margin-right: 0;" gift="<?php echo $gift->id; ?>" id="reserve-<?php echo $gift->id; ?>" type="checkbox" onclick="toggle(this, '<?php echo addslashes($gift->name); ?>');" <?php if ($gift->reserved) echo 'checked' ?> />
        <label for="reserve-<?php echo $gift->id; ?>">Reserve<?php if ($gift->reserved) echo 'd' ?></label>
      </span>
      <button gift="<?php echo $gift->id; ?>" id="remove-<?php echo $gift->id; ?>" class="delete-placeholder" type="button" value="❌" onclick="remove(this.getAttribute('gift'), '<?php echo addslashes($gift->name); ?>');"></button>
      <label class="delete-button" for="remove-<?php echo $gift->id; ?>" alt="Remove <?php echo addslashes($gift->name); ?> from your wishlist" title="Remove">❌</label>
    </div>
    <div>
      <h2 class="gift-name">
        <!-- <button href="#" class="edit" title="Edit: Name" onclick="edit('name-<?php echo $gift->id; ?>');">✏</button> -->
        <span id="name-<?php echo $gift->id; ?>">
          <?php
          if (empty($gift->url)) {
            echo htmlentities($gift->name);
          } else {
          ?>
          <a class="link" href="<?php echo $gift->url ?>">
            <?php echo htmlentities($gift->name); ?>
          </a>
        <?php } ?>
        </span>
      </h2>
      <?php if (!empty($gift->notes)) { ?>
        <p class="subheading">
        <!-- <button href="#" class="edit" title="Edit: Comments" onclick="edit('notes-<?php echo $gift->id; ?>');">✏</button> -->
        <span id="notes-<?php echo $gift->id; ?>" class="gift-notes">
          <?php echo nl2br(htmlentities($gift->notes)); ?>
        </span>
        </p>
      <?php } ?>
    </div>
  </div>
</div>
