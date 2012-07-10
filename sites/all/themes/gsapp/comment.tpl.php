<div class="comment entry <?php print $comment_classes; ?>">

  <?php if ($unpublished): ?>
    <div class="unpublished"><?php print t('Unpublished'); ?></div>
  <?php endif; ?>

  <div class="content">
    <?php if ($picture) print $picture; ?>
    <?php print $content; ?>
  </div>

  <div class="entryshare">
	Posted by: <?php print l($comment->registered_name, 'user/' . $comment->uid); ?>
  </div>

  <?php if ($links): ?>
    <div class="links">
      <?php print $links; ?>
    </div>
  <?php endif; ?>

</div> <!-- /comment -->
