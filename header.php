<!-- Replace "custom" with site's name :) -->
<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>>> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>>> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" <?php language_attributes(); ?>>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<?php if (is_search()) { ?><meta name="robots" content="noindex, nofollow" /><?php } ?>
	<title><?php
		if (function_exists('is_tag') && is_tag()) {
			single_tag_title("Tag Archive for &quot;"); echo '&quot; - '; }
		elseif (is_archive()) {
			wp_title(''); echo ' Archive - '; }
		elseif (is_search()) {
			echo 'Search for &quot;'.wp_specialchars($s).'&quot; - '; }
		elseif (!(is_404()) && (is_single()) || (is_page())) {
			wp_title(''); echo ' - '; }
		elseif (is_404()) {
			echo 'Not Found - '; }
		if (is_home()) {
			bloginfo('name'); echo ' - '; bloginfo('description'); }
		else {
			bloginfo('name'); }
		if ($paged>1) {
			echo ' - page '. $paged; }
	?></title>

	<meta name="title" content="<?php
		if (function_exists('is_tag') && is_tag()) {
			single_tag_title("Tag Archive for &quot;"); echo '&quot; - '; }
		elseif (is_archive()) {
			wp_title(''); echo ' Archive - '; }
		elseif (is_search()) {
			echo 'Search for &quot;'.wp_specialchars($s).'&quot; - '; }
		elseif (!(is_404()) && (is_single()) || (is_page())) {
			wp_title(''); echo ' - '; }
		elseif (is_404()) {
			echo 'Not Found - '; }
		if (is_home()) {
			bloginfo('name'); echo ' - '; bloginfo('description'); }
		else {
			bloginfo('name'); }
		if ($paged>1) {
		echo ' - page '. $paged; }
	?>">
	<meta name="description" content="<?php bloginfo('description'); ?>">
	<meta name="google-site-verification" content="">
	<meta name="author" content="-Your Name Here-">
	<meta name="Copyright" content="Copyright -Your Name Here- 2011. All Rights Reserved.">
	<meta name="viewport" content="width=device-width">

	<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/favicon.ico">
	<link rel="apple-touch-icon" href="<?php bloginfo('template_directory'); ?>/apple-touch-icon.png">

	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">

	<script src="<?php bloginfo('template_directory'); ?>/js/modernizr-version.min.js"></script>

	<link rel="alternate" type="application/rss+xml" title="<?php printf(__('%1$s %2$s Feed'), get_bloginfo('name'), '&raquo;'); ?>" href="<?php bloginfo('rss_url'); ?>">

	<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head(); ?>
</head>

<body id="<?php $post_parent = get_post($post->post_parent); $parentSlug = $post_parent->post_name; if (is_category()) { echo "CategoryPage"; } elseif (is_search()) { echo "SearchResults"; } elseif (is_tag()) { echo "Tag"; } else { echo $parentSlug; } ?>" class="<?php if (is_category()) { echo 'category'; } elseif (is_search()) { echo 'search'; } elseif (is_tag()) { echo "tag"; } elseif (is_home()) { echo "home"; } elseif (is_404()) { echo "page404"; } else { echo $post->post_name; } ?>">
	<!--[if lt IE 7 ]><p class=chromeframe><?php _e('Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.'); ?></p><![endif]-->
	<header role="banner">
		<h1><a href="<?php echo home_url( '/' ); ?>"><?php bloginfo('name'); ?></a></h1>
		<em class="description"><?php bloginfo( 'description' ); ?></em>
	</header>

	<nav role="navigation">
		<a href="#" class="dropdown-control">Menu</a>
		<?php wp_nav_menu( array('container' => false, 'menu' => 'nav_top' )); ?>

	</nav>

	<div id="main" role="main">
