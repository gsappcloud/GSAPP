<?php
// $Id: views-view.tpl.php,v 1.10 2008/09/22 20:50:58 merlinofchaos Exp $
/**
 * @file views-view.tpl.php
 * Main view template
 *
 * Variables available:
 * - $header: The view header
 * - $footer: The view footer
 * - $rows: The results of the view query, if any
 * - $empty: The empty text to display if the view is empty
 * - $pager: The pager next/prev links to display, if any
 * - $exposed: Exposed widget form/info to display
 * - $feed_icon: Feed icon to display, if any
 * - $more: A link to view more, if any
 * - $admin_links: A rendered list of administrative links
 * - $admin_links_raw: A list of administrative links suitable for theme('links')
 *
 * @ingroup views_templates
 */
?>

<?php if ($attachment_before): ?>
<div class="attachment-before">
  <?php print $attachment_before; ?>
</div>
<?php endif; ?>


<?php 
$output = '';
_generateAtoZ($view,$args,$view->result,$output,'user');
print $output;
?>
<?php if ($attachment_after): ?>
<div class="attachment-after">
  <?php print $attachment_after; ?>
</div>
<?php endif; ?>
