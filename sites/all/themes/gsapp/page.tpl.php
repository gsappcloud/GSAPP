<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php print $language->language; ?>" xml:lang="<?php print $language->language; ?>">

<head>
<title><?php print $head_title; ?></title>
<?php print $head; ?>
<?php print $styles; ?>

<link type="text/css" rel="stylesheet" media="all" href="<?php print $includes_dir; ?>/html-elements.css" />
<link type="text/css" rel="stylesheet" media="all" href="<?php print $includes_dir; ?>/tabs.css" />
<link type="text/css" rel="stylesheet" media="all" href="<?php print $includes_dir; ?>/gsapp.css" />
<link type="text/css" rel="stylesheet" media="print" href="<?php print $includes_dir; ?>/print.css" />

<!--[if IE]>
  <link rel="stylesheet" href="<?php print $includes_dir; ?>/ie.css" type="text/css">
<![endif]-->

<!--[if IE 6]>
  <link rel="stylesheet" href="<?php print $includes_dir; ?>/ie6.css" type="text/css">
<![endif]-->

<?php print $scripts; ?>
<script type="text/javascript" src="<?php print $includes_dir; ?>/gsapp.js"></script>
<script type="text/javascript" src="<?php print $includes_dir; ?>/ccwidget.js"></script>

<script src="http://www.google.com/jsapi" type="text/javascript"></script>
<script type="text/javascript"> 
  google.load('search', '1', {language : 'en'});
  google.setOnLoadCallback(function() {
    var customSearchOptions = {};
    var customSearchControl = new google.search.CustomSearchControl(
      '004033327063740628517:awygqf_dy3q', customSearchOptions);
    customSearchControl.setResultSetSize(google.search.Search.SMALL_RESULTSET);
    customSearchControl.draw('cse');
  }, true);
</script>
</head>

<body class="<?php print $body_classes;?>">


<!-- Header -->

<div class="wrapper <?php print (array_intersect(array('Faculty','TA','Student','Director','Alumni'),$user->roles) ? 'faculty' : ''); ?>">

  <div id="logo-container">
  	<a href="<?php print base_path(); ?>" class="home"><img src="<?php print base_path(); ?>files/gsapp/imceshared/tct2003/GSAPPlogoTop.png" alt="GSAPP" border="0" /></a>
    <a href="http://www.columbia.edu" class="cu-link"><img src="<?php print base_path(); ?>files/gsapp/imceshared/tct2003/GSAPPlogoBottom.png" alt="Columbia University" border="0" /></a>
  </div>

  <div id="search-container">
    <div id="searchbar">
      <div id="cse">Loading search</div>
    </div>
  </div>

	<?php if (!$user->uid): ?>
	<div id="login"><?php print l("Login", "user/wind"); ?></div>
	<?php else:?>
	<div id="login"><?php print l("My Site", "my-site"); ?></div>
	<?php endif; ?>

  <div id="header">
		<?php print $navigation_main; ?>
  </div><!-- /#header -->

<!-- Content -->

    <div id="content" class="clearfix">
		<?php if ($tabs): ?><div class="tabs"><?php print $tabs; ?></div><?php endif; ?>
		<?php print $messages . $help . $header; ?>

		<?php if ($is_front): ?>
        <div id="two_col_lt">

            <div class="container">
				<?php print ($content_header) ? '<div class="content_header">' . $content_header . '</div>' : ''; ?>
            	<?php //print $content; ?>
				<?php //print ($content_footer) ? '<div class="content_header">' . $content_footer . '</div>' : ''; ?>
            </div>

            <div id="one_col_lt" class="left_outer">
				<?php print $left_outer; ?>
            </div>

            <div id="one_col_rt" class="left_inner">
				<?php print $left_inner; ?>
            </div>

        </div>
		<?php else: ?>
        <div id="one_col_lt" class="left_outer">
			<?php print $left_outer; ?>
        </div>
		<?php endif; ?>


		<?php if ($is_front): ?>
		<div id="two_col_rt">
            <div id="one_col_lt" class="right_inner">
                <!-- Headliner Event -->
                <!-- Today at the GSAPP -->
                <!-- Event Calendar -->
            	<?php print $right_inner; ?>
            </div>

            <div id="one_col_rt" class="right_outer">
				<?php print $right_outer; ?>
            </div>
        </div>
		<?php else: ?>
		<?php if($right_outer):?>

		 <div id="one_col_rt" class="right_outer">
				<?php print $right_outer; ?>
		 </div>
        <div id="two_col_rt">
        	<?php if($title):?>
            <h3 class='title'><?php print $title; ?></h3>
            <?php endif;?>
			<?php print ($content_header) ? '<div class="content_header">' . $content_header . '</div>' : ''; ?>
            <?php print $content; ?>
			<?php print ($content_footer) ? '<div class="content_footer">' . $content_footer . '</div>' : ''; ?>
        </div>
        <?php else:?>
         <?php if($right_outer):?>
		 <div id="one_col_rt" class="right_outer">
				<?php print $right_outer; ?>
		 </div>
		 <?php endif; ?>
        <div id="three_col_rt">
        	<?php if($title):?>
            <h3 class='title'><?php print $title; ?></h3>
            <?php endif;?>
			<?php print ($breadcrumb) ? '<div id="breadcrumb-container">[' . $breadcrumb . ']</div>' : ''; ?>
			<?php print ($content_header) ? '<div class="content_header">' . $content_header . '</div>' : ''; ?>
            <div id="content"><?php print $content; ?></div>
			<?php print ($content_footer) ? '<div class="content_footer">' . $content_footer . '</div>' : ''; ?>
        </div>
        <?php endif; ?>
		<?php endif; ?>

    </div><!-- /#content -->

<!-- Footer -->

    <div id="footer">
<?php
$block_copyr = module_invoke('copyright', 'block', 'view', 7);
// print $block_copyr['content'];

?>
		<div id="footer-inner" class="clearfix"><?php print $footer . $block_copyr['content'] ; ?></div>
<!--		<p>&copy; <?= date('Y'); ?>  Graduate School of Architecture, Planning and Preservation, Columbia University 1172 Amsterdam Avenue New York, New York 10027</p>
-->
    </div><!-- /#footer -->

</div>

<?php print $closure; ?>

</body>
</html>