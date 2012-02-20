<?php 
/*
 * Replace "custom" by the theme name (no spaces)
 */

// Nicely loading jQuery from CDN, with local fallback
function rd_bulletproof_jquery() {
	$url = 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js';
	wp_deregister_script('jquery');
	if (get_transient('google_jquery') == true) {
		wp_register_script('jquery', $url, array(), null, true);
	}
	else {
		$resp = wp_remote_head($url);
		if (!is_wp_error($resp) && 200 == $resp['response']['code']) {
			set_transient('google_jquery', true, 60 * 5);
			wp_register_script('jquery', $url, array(), null, true);
		}
		else {
			set_transient('google_jquery', false, 60 * 5);
			$url = get_bloginfo('wpurl') . '/wp-includes/js/jquery/jquery.js';
			wp_register_script('jquery', $url, array(), '1.7.1', true);
		}
	}
	wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'rd_bulletproof_jquery');


// html5 figure & figcaption
add_shortcode('wp_caption', 'custom_img_caption_shortcode');
add_shortcode('caption', 'custom_img_caption_shortcode');

function custom_img_caption_shortcode($attr, $content = null) {
	extract(shortcode_atts(array(
		'id' => '',
		'align' => 'alignnone',
		'width' => '',
		'caption' => ''
	), $attr));
	if ( 1 > (int) $width || empty($caption) ) return $content;
	if ( $id ) $idtag = 'id="' . esc_attr($id) . '" ';
	return '<figure ' . $idtag . 'aria-describedby="figcaption_' . $id . '" style="width: ' . (10 + (int) $width) . 'px">' . do_shortcode( $content ) . '<figcaption id="figcaption_' . $id . '">' . $caption . '</figcaption></figure>';
}


// Theme init setup
add_action( 'after_setup_theme', 'custom_setup' );

if ( ! function_exists( 'custom_setup' ) ):
	function custom_setup() {

		// Translations
		load_theme_textdomain( 'custom', get_template_directory() . '/languages' );

		$locale = get_locale();
		$locale_file = get_template_directory() . "/languages/$locale.php";
		if ( is_readable( $locale_file ) )
			require_once( $locale_file );

		// add default post & comments feed to head (since v3.0)
		add_theme_support( 'automatic-feed-links' );
		// add post thumbnail support
		add_theme_support( 'post-thumbnails' );
		// add postformats support (since 3.1)
		add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ));
		// add page excerpt support
		add_post_type_support( 'page', 'excerpt' );
		// register custom menu
		register_nav_menu( 'primary', 'Primary Menu' );
		// Remove links to the extra feeds (e.g. category feeds)
		remove_action( 'wp_head', 'feed_links_extra', 3 );
		// Remove link to the RSD service endpoint, EditURI link
		remove_action( 'wp_head', 'rsd_link' );
		// Remove link to the Windows Live Writer manifest file
		remove_action( 'wp_head', 'wlwmanifest_link' );
		// Remove index link
		remove_action( 'wp_head', 'index_rel_link' );
		// Remove prev link
		remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
		// Remove start link
		remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
		// Display relational links for adjacent posts
		remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );
		// Remove XHTML generator showing WP version
		remove_action( 'wp_head', 'wp_generator' );

	}
endif;
?>
