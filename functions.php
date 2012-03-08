<?php load_theme_textdomain( 'base5', get_template_directory() . '/languages' );

require_once ( get_template_directory() . '/theme-options.php' );


// TinyMCE on Page Excerpt
function tinymce_excerpt_js(){ ?>
	<script type="text/javascript">
		jQuery(document).ready( tinymce_excerpt );
		function tinymce_excerpt() {
			jQuery("#excerpt").addClass("mceEditor");
			tinyMCE.execCommand("mceAddControl", false, "excerpt");
		}
	</script>
<?php }
add_action( 'admin_head-post.php', 'tinymce_excerpt_js');
add_action( 'admin_head-post-new.php', 'tinymce_excerpt_js');

function tinymce_css(){ ?>
	<style type='text/css'>
		#postexcerpt .inside { margin:0;padding:0;background:#fff; }
		#postexcerpt .inside p { padding:0px 0px 5px 10px; background: #f5f5f5; margin-top: 0; padding-top: 12px; border-top: 1px solid #dfdfdf; }
		#postexcerpt #excerpteditorcontainer { border-style: solid; padding: 0; }
	</style>
<?php }
add_action( 'admin_head-post.php', 'tinymce_css');
add_action( 'admin_head-post-new.php', 'tinymce_css');


// Display the year
function copyrightYear() {
	$year = 2012;

	if (date("Y") == $year) {
		echo $year;
	} else {
		echo $year . "-" . date("Y");
	}
}


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
add_shortcode('wp_caption', 'img_caption_shortcode');
add_shortcode('caption', 'img_caption_shortcode');

function img_caption_shortcode($attr, $content = null) {
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


// Cleaning the mess from plugins in head
function pluginmess() {
	wp_deregister_style( 'page-list-style' ); 							// Plugin: page-list
	wp_deregister_script( 'cgmp-google-map-json-trigger' ); // Plugin: comprehensive-google-map-plugin
}
add_action( 'wp_print_styles', 'pluginmess', 100 );


// Theme init
add_action( 'after_setup_theme', 'theme_init' );

if ( ! function_exists( 'theme_init' ) ):
	function theme_init() {
		// First we check to see if our default theme settings have been applied.
		$the_theme_status = get_option( 'theme_setup_status' );
		// If the theme has not yet been used we want to run our default settings.
		if ( $the_theme_status !== '1' ) {
			// Setup Default WordPress settings
			$core_settings = array(
				'blog_charset' => 'UTF-8',
				'permalink_structure' => '/%category%/%postname%/',
				'gmt_offset' => '+1',
				'default_role' => 'author',
				'comments_per_page' => 20,
				'thread_comments' => 1,
				'rss_use_excerpt' => 1,
				'hack_file' => 0
			);
			foreach ( $core_settings as $k => $v ) {
				update_option( $k, $v );
			}

			// Lets let the admin know whats going on.
			$msg = '
			<div class="updated">
				<p>' . get_option( 'current_theme' ) . ' <a href="' . admin_url( 'options-general.php' ) . '" title="See Settings">settings</a> loaded.</p>
			</div>';
			add_action( 'admin_notices', $c = create_function( '', 'echo "' . addcslashes( $msg, '"' ) . '";' ) );

		}
		// Else if we are re-activing the theme
		elseif ( $the_theme_status === '1' and isset( $_GET['activated'] ) ) {
			$msg = '
			<div class="updated">
				<p>' . get_option( 'current_theme' ) . ' theme was successfully re-activated.</p>
			</div>';
			add_action( 'admin_notices', $c = create_function( '', 'echo "' . addcslashes( $msg, '"' ) . '";' ) );
		}

		$locale = get_locale();
		$locale_file = get_template_directory() . "/languages/$locale.php";
		if ( is_readable( $locale_file ) )
			require_once( $locale_file );

		// add default post & comments feed to head (since v3.0)
		add_theme_support( 'automatic-feed-links' );
		// add post thumbnail support
		add_theme_support( 'post-thumbnails', array( 'post', 'page' ) );
		// add postformats support (since 3.1)
		add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ));
		// add page excerpt support
		add_post_type_support( 'page', 'excerpt' );
		// register custom menus
		register_nav_menus(
			array(
				'nav_top' => 'Top Navigation',
				'nav_footer' => 'Footer Navigation'
			)
		);
		// Remove the "Links" menu item
		function delete_link_menu() {
			remove_menu_page('link-manager.php');
		}
		add_action( 'admin_menu', 'delete_link_menu' );
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

		// Change the footer in admin panel
		function remove_footer_admin () {
			echo 'Fueled by <a href="http://www.wordpress.org" target="_blank">WordPress</a> | Designed by <a href="http://yannabgrall.com" target="_blank">Yann Abgrall</a></p>';
		}
		add_filter('admin_footer_text', 'remove_footer_admin');


		// Once done, we register our setting to make sure we don't duplicate everytime we activate.
		update_option( 'theme_setup_status', '1' );
	}
endif;
?>
