<?php if($hidden) : ?>
  <li id="fn-<?= $count ?>" style="list-style-type:none">
    <?= $note ?>
  </li>

<?php else : ?>
  <li id="fn-<?= $count ?>" value="<?= $order ?>">
    <?= $note ?> <span class="footnotereverse"><a href="#fnref-<?= $count ?>">&#8617;</a></span>
  </li>
<?php endif ?>
