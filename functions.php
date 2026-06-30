<?php
/**
 * Functions
 */
//global $first_parent_found;
/******************************************************************************
 * Included Functions
 ******************************************************************************/

// Constants
define( 'IMAGE_ASSETS', get_stylesheet_directory_uri() . '/assets/images/' );
define( 'IMAGE_PLACEHOLDER', IMAGE_ASSETS . 'placeholder.svg' );

// Helpers function
require_once get_stylesheet_directory() . '/inc/helpers.php';

add_action( 'init', function () {
	// Register ACF Gravity Forms field
	if ( class_exists( 'ACF' ) ) {
		require_once get_stylesheet_directory() . '/inc/class-acf-field-gravity-v5.php';
	}

	// ACF Gutenberg blocks
	include_once get_stylesheet_directory() . '/inc/gutenberg.php';
}, 9 );

/**
 * Prevent Fatal error on site if ACF not installed/activated
 */
function include_acf_placeholder() {
	include_once get_stylesheet_directory() . '/inc/acf-placeholder.php';
}

add_action( 'wp', 'include_acf_placeholder', PHP_INT_MAX );

// Install Recommended plugins
require_once get_stylesheet_directory() . '/inc/recommended-plugins.php';
// Walker modification
require_once get_stylesheet_directory() . '/inc/class-starter-navigation.php';
// Walker modification
require_once get_stylesheet_directory() . '/inc/class-walker-navigation.php';
// Walker modification
require_once get_stylesheet_directory() . '/inc/class-mob-walker-navigation.php';
// Home slider function
include_once get_stylesheet_directory() . '/inc/home-slider.php';
// Dynamic admin. Add Custom columns to posts list view
include_once get_stylesheet_directory() . '/inc/class-dynamic-admin.php';
// SVG Support
include_once get_stylesheet_directory() . '/inc/svg-support.php';
// Extend WP Search with Custom fields
include_once get_stylesheet_directory() . '/inc/custom-fields-search.php';
// WooCommerce functionality
if ( function_exists( 'WC' ) ) {
	include_once get_stylesheet_directory() . '/inc/woo-custom.php';
}
// Include all additional shortcodes
//include_once get_stylesheet_directory() . '/inc/shortcodes.php';

/******************************************************************************
 * Global Functions
 ******************************************************************************/

/**
 * WP 5.2 wp_body_open backward compatibility
 */
if ( ! function_exists( 'wp_body_open' ) ) {
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}

// By adding theme support, we declare that this theme does not use a
// hard-coded <title> tag in the document head, and expect WordPress to
// provide it for us.
add_theme_support( 'title-tag' );

//  Add widget support shortcodes
add_filter( 'widget_text', 'do_shortcode' );

// Support for Featured Images
add_theme_support( 'post-thumbnails' );

// Custom Background
add_theme_support( 'custom-background', array( 'default-color' => 'fff' ) );

// Custom Logo
add_theme_support( 'custom-logo', array(
	'height'      => '150',
	'flex-height' => true,
	'flex-width'  => true,
) );

function show_custom_logo( $size = 'medium' ) {
	if ( $custom_logo_id = get_theme_mod( 'custom_logo' ) ) {
		$logo_image = wp_get_attachment_image( $custom_logo_id, $size, false, array(
			'class'    => 'custom-logo skip-lazy',
			'itemprop' => 'siteLogo',
			'alt'      => get_bloginfo( 'name' ),
		) );
	} else {
		$logo_url   = get_stylesheet_directory_uri() . '/assets/images/custom-logo.png';
		$w          = 200;
		$h          = 160;
		$logo_image = '<img src="' . $logo_url . '" width="' . $w . '" height="' . $h . '" class="custom-logo" itemprop="siteLogo" alt="' . get_bloginfo( 'name' ) . '">';
	}

	$html = sprintf( '<a href="%1$s" class="custom-logo-link" rel="home" title="%2$s" itemscope>%3$s</a>', esc_url( home_url( '/' ) ), get_bloginfo( 'name' ), $logo_image );
	echo apply_filters( 'get_custom_logo', $html );
}

// Add HTML5 elements
add_theme_support( 'html5', array(
	'comment-list',
	'search-form',
	'comment-form',
	'gallery',
	'caption',
	'script',
	'style',
) );

// Add RSS Links generation
add_theme_support( 'automatic-feed-links' );
// Hide comments feed link
add_filter( 'feed_links_show_comments_feed', '__return_false' );

// Add excerpt to pages
add_post_type_support( 'page', 'excerpt' );

// Register Navigation Menu
register_nav_menus( array(
	'header-menu' => 'Header Menu',
	'footer-menu' => 'Footer Menu',
	'mobile-menu' => 'Mobile Menu',
) );

/**
 * Create pagination
 *
 * @param WP_Query $query
 * @param bool $echo
 * @param null|string $base
 * @param array $args
 *
 * @return string|void
 */
function starter_pagination( $query = '', $base = null, $echo = true, $args = [] ) {
	if ( empty( $query ) ) {
		global $wp_query;
		$query = $wp_query;
	}

	$big       = 999999999;
	$pagi_args = array(
		'base'      => $base ?: str_replace( $big, '%#%', esc_url( explode( '?', get_pagenum_link( $big ), 2 )[0] ) ),
		'format'    => 'page/%#%',
		'prev_next' => true,
		'prev_text' => '<span class="pagination-arrow fas fa-angle-left"></span>',
		'next_text' => '<span class="pagination-arrow fas fa-angle-right"></span>',
		'current'   => max( 1, $query->query_vars['paged'] ),
		'total'     => $query->max_num_pages,
		'type'      => 'array',
	);

	$args = ! empty( $_GET ) ? array_merge( $args, $_GET ) : $args;
	if ( $args ) {
		foreach ( $args as $key => $val ) {
			$pagi_args['add_args'][ $key ] = $val;
		}
	}
	$links      = paginate_links( $pagi_args );
	$pagination = '';

	if ( $links ) {
		// Add empty prev link
		if ( $pagi_args['current'] == 1 ) {
			array_unshift( $links, str_replace( 'pagination-arrow', 'pagination-arrow disabled', $pagi_args['prev_text'] ) );
		}

		// Add empty next link
		if ( $pagi_args['current'] !== 1 && $pagi_args['current'] == $pagi_args['total'] ) {
			$links[] = str_replace( 'pagination-arrow', 'pagination-arrow disabled', $pagi_args['next_text'] );
		}

		// Pagination container can be replaced with custom.
		// Pagination styles are placed in /scss/inc/_wp-core.scss:136
		$pagination = "<ul class='page-numbers'>\n\t<li>";
		$pagination .= implode( "</li>\n\t<li>", $links );
		$pagination .= "</li>\n</ul>\n";

		//		$pagination = str_replace( 'page-numbers', 'pagination', $r );
	}

	if ( $echo ) {
		echo $pagination;
	} else {
		return $pagination;
	}
}

// Register Sidebars
function starter_widgets_init() {
	/* Sidebar Right */
	register_sidebar( array(
		'id'            => 'starter_sidebar_right',
		'name'          => __( 'Sidebar Right' ),
		'description'   => __( 'This sidebar is located on the right-hand side of each page.' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="widget__title">',
		'after_title'   => '</h5>',
	) );
	
    // Sidebar 1
    register_sidebar(
            array(
                    'id'            => 'starter_sidebar_sidebar_1',
                    'name'          => __( 'Sidebar 1', 'starter' ),
                    'description'   => __( 'Additional sidebar area.', 'starter' ),
                    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                    'after_widget'  => '</aside>',
                    'before_title'  => '<h5 class="widget__title">',
                    'after_title'   => '</h5>',
            )
    );

}

add_action( 'widgets_init', 'starter_widgets_init' );

/** Do shortcodes in sidebar */
function starter_sidebar_shortcode( $atts ) {
    $atts = shortcode_atts( array(
            'id' => '',
    ), $atts, 'starter_sidebar' );

    if ( empty( $atts['id'] ) || ! is_active_sidebar( $atts['id'] ) ) {
        return '';
    }

    ob_start();
    dynamic_sidebar( $atts['id'] );
    return ob_get_clean();
}
add_shortcode( 'starter_sidebar', 'starter_sidebar_shortcode' );


// Remove #more anchor from posts
function remove_more_jump_link( $link ) {
	$offset = strpos( $link, '#more-' );
	if ( $offset ) {
		$end = strpos( $link, '"', $offset );
	}
	if ( ! empty( $end ) ) {
		$link = substr_replace( $link, '', $offset, $end - $offset );
	}

	return $link;
}

add_filter( 'the_content_more_link', 'remove_more_jump_link' );

// Remove more tag <span> anchor
function remove_more_anchor( $content ) {
	return str_replace( '<p><span id="more-' . get_the_ID() . '"></span></p>', '', $content );
}

add_filter( 'the_content', 'remove_more_anchor' );


/******************************************************************************************************************************
 * Enqueue Scripts and Styles for Front-End
 *******************************************************************************************************************************/

//Remove jQuery Migrate
function starter_remove_jquery_migrate( $scripts ) {
	if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
		$script = $scripts->registered['jquery'];
		if ( $script->deps ) {
			// Check whether the script has any dependencies
			$script->deps = array_diff( $script->deps, array( 'jquery-migrate' ) );
		}
	}
}

add_action( 'wp_default_scripts', 'starter_remove_jquery_migrate' );

function starter_scripts_and_styles() {
	if ( ! is_admin() ) {
		
		wp_deregister_style('gform_theme_ie11');

		// Load Stylesheets
		wp_enqueue_style( 'foundation', get_template_directory_uri() . '/assets/css/foundation.css', null, filemtime( get_stylesheet_directory() . '/assets/css/foundation.css' ) );
		wp_enqueue_style( 'select2', get_template_directory_uri() . '/assets/css/select2.min.css', null, '4.1.0' );
		wp_enqueue_style( 'custom', get_template_directory_uri() . '/assets/css/custom.css', null, filemtime( get_stylesheet_directory() . '/assets/css/custom.css' ) );
		wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css', null, filemtime( get_stylesheet_directory() . '/style.css' ) );

		// Load JavaScripts
		wp_deregister_script( 'jquery-migrate' );
		wp_enqueue_script( 'jquery' );

		wp_enqueue_script( 'foundation.min', get_template_directory_uri() . '/assets/js/foundation.min.js', null, '6.8.1', true );
		wp_add_inline_script( 'foundation.min', 'jQuery(document).foundation();' );

		//plugins
		wp_enqueue_script( 'slick', get_template_directory_uri() . '/assets/js/plugins/slick.min.js', null, '1.8.1', true );
		wp_enqueue_script( 'select2', get_template_directory_uri() . '/assets/js/plugins/select2.full.min.js', null, '4.1.0', true );
		wp_enqueue_script( 'fancybox.v3', get_template_directory_uri() . '/assets/js/plugins/jquery.fancybox.v3.js', null, '3.5.7', true );
		//		wp_enqueue_script( 'fancybox.v4', get_template_directory_uri() . '/assets/js/plugins/fancybox.v4.js', null, '4.0.27', true );
		//		wp_enqueue_script( 'jarallax', get_template_directory_uri() . '/assets/js/plugins/jarallax.min.js', null, '2.14.0', true );

		// !!! DO NOT Use MatchHeight unless it's the only option to align blocks! Use Flex-box styles instead !!!
				wp_enqueue_script( 'matchHeight', get_template_directory_uri() . '/assets/js/plugins/jquery.matchHeight-min.js', null, '0.7.2', true );


		//custom javascript
		wp_enqueue_script( 'global', get_template_directory_uri() . '/assets/js/global.js', [ 'jquery' ], filemtime( get_stylesheet_directory() . '/assets/js/global.js' ), true ); /* This should go first */
		// Additional PHP data that will be accessible in JS files
		$localize_args = [
			'url' => admin_url( 'admin-ajax.php' ),
		];
		wp_localize_script( 'global', 'ajax', $localize_args );

	}
}

add_action( 'wp_enqueue_scripts', 'starter_scripts_and_styles' );

add_filter( 'acf/load_field/type=google_map', function ( $field ) {
	$google_map_api = 'https://maps.googleapis.com/maps/api/js';
	$api_args       = array(
		'key'      => get_theme_mod( 'google_maps_api' ) ?: 'AIzaSyBgg23TIs_tBSpNQa8RC0b7fuV4SOVN840',
		'language' => 'en',
		'v'        => '3.exp',
	);
	wp_enqueue_script( 'google.maps.api', add_query_arg( $api_args, $google_map_api ), null, null, true );

	return $field;
} );

/******************************************************************************
 * Additional Functions
 *******************************************************************************/

// Specify image sizes that need to be optimized
function specify_sizes_to_optimize( $sizes ) {
	if ( empty( $sizes ) || $sizes == 'thumbnail,medium' ) {
		$sizes = 'thumbnail,medium,medium_large,large,large_high,full_hd,1536x1536,2048x2048';
	}

	return $sizes;
}

add_filter( 'wbcr/factory/populate_option_allowed_sizes_thumbnail', 'specify_sizes_to_optimize' );

// Disable Robin Image optimizer backup
function disabled_image_bckp_by_default() {
	return ! empty( get_option( 'wbcr_io_backup_origin_images' ) ) ? get_option( 'wbcr_io_backup_origin_images' ) : 0;
}

add_filter( 'wbcr/factory/populate_option_backup_origin_images', 'disabled_image_bckp_by_default' );

function disabled_image_bckp_on_init() {
	update_option( 'wbcr_io_backup_origin_images', 0 );
}

add_action( 'wbcr/factory/plugin_activated', 'disabled_image_bckp_on_init' );

// Disable Robin Image resize image
function disabled_image_resize_by_default() {
	return ! empty( get_option( 'wbcr_io_resize_larger' ) ) ? get_option( 'wbcr_io_resize_larger' ) : 0;
}

add_filter( 'wbcr/factory/populate_option_resize_larger', 'disabled_image_resize_by_default' );

// Enable revisions for all custom post types
add_filter( 'cptui_user_supports_params', function () {
	return array( 'revisions' );
} );

/**
 * Limit number of revisions for all post types
 *
 * @return int
 */
function limit_revisions_number() {
	return 10;
}

add_filter( 'wp_revisions_to_keep', 'limit_revisions_number' );

// Add ability ro reply to comments
add_filter( 'wpseo_remove_reply_to_com', '__return_false' );

// Enable control over YouTube iframe through API + add unique ID
function add_youtube_iframe_args( $html, $url, $args ) {

	/* Modify video parameters. */
	if ( strstr( $html, 'youtube.com/embed/' ) && ! empty( $args['location'] ) ) {
		preg_match_all( '|embed/(.*)\?|', $html, $matches );
		$html = str_replace( '?feature=oembed', '?feature=oembed&enablejsapi=1&autoplay=1&mute=1&controls=0&loop=1&showinfo=0&rel=0&playlist=' . $matches[1][0], $html );
		$html = str_replace( '<iframe', '<iframe rel="0" enablejsapi="1" id=slide-' . get_the_ID(), $html );
	}

	return $html;
}

add_filter( 'oembed_result', 'add_youtube_iframe_args', 10, 3 );

/**
 * Remove author archive pages
 */
function remove_author_archive_page() {
	global $wp_query;

	if ( is_author() ) {
		$wp_query->set_404();
		status_header( 404 );
		// Redirect to homepage
		// wp_redirect(get_option('home'));
	}
    if (strpos($_SERVER['REQUEST_URI'], '/nutritional-content/') !== false) {
        wp_redirect(home_url('/health-and-wellnesseducation/'), 301);
        exit;
    }
}

add_action( 'template_redirect', 'remove_author_archive_page' );

/**
 * Remove comments feed links
 */
add_filter( 'post_comments_feed_link', '__return_null' );

// Stick Admin Bar To The Top
if ( ! is_admin() ) {
	add_theme_support( 'admin-bar', array( 'callback' => '__return_false' ) );

	function stick_admin_bar() {
		echo "
			<style>
			@media only screen and (min-width: 1025px) {
				body.admin-bar {margin-top:32px !important}
			}
			@media only screen and (max-width: 1024px) {
				#wpadminbar {display: none;}
			}
			</style>
			";
	}

	add_action( 'wp_head', 'stick_admin_bar' );
}

// Customize Login Screen
function wordpress_login_styling() {
	if ( $custom_logo_id = get_theme_mod( 'custom_logo' ) ) {
		$custom_logo_img = wp_get_attachment_image_src( $custom_logo_id, 'medium' );
		$custom_logo_src = $custom_logo_img[0];
	} else {
		$custom_logo_src = 'wp-admin/images/wordpress-logo.svg?ver=20131107';
	}

	$bg_image = get_background_image();

	?>
	<style type="text/css">
		.login #login h1 a {
			background-image: url('<?php echo $custom_logo_src; ?>');
			background-size: contain;
			background-position: 50% 50%;
			width: auto;
			height: 120px;
			max-width: 320px;
		}

		body.login {
			background-color: #f1f1f1;
			background-repeat: repeat;
			background-position: center center;
			<?php echo $bg_image ? "background-image: url('{$bg_image}') !important;" : ''; ?>
		}
	</style>
<?php }

add_action( 'login_enqueue_scripts', 'wordpress_login_styling' );

function admin_logo_custom_url() {
	$site_url = get_bloginfo( 'url' );

	return ( $site_url );
}

add_filter( 'login_headerurl', 'admin_logo_custom_url' );

/**
 * Display GravityForms fields label if it set to Hidden
 */

function display_gf_fields_label() {
	echo '<style>.hidden_label label.gfield_label{visibility:visible;line-height:inherit;}.theme-overlay .theme-version{display: none;}</style>';
}

add_action( 'admin_head', 'display_gf_fields_label' );

// ACF Pro Options Page

if ( function_exists( 'acf_add_options_page' ) ) {

	acf_add_options_page( array(
		'page_title' => 'Theme General Settings',
		'menu_title' => 'Theme Settings',
		'menu_slug'  => 'theme-general-settings',
		'capability' => 'edit_posts',
		'redirect'   => false,
	) );

}

// Set Google Map API key

function set_custom_google_api_key() {
	acf_update_setting( 'google_api_key', get_theme_mod( 'google_maps_api' ) ?: 'AIzaSyBgg23TIs_tBSpNQa8RC0b7fuV4SOVN840' );
}

add_action( 'acf/init', 'set_custom_google_api_key' );

// Disable Emoji

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
add_filter( 'tiny_mce_plugins', 'disable_wp_emojis_in_tinymce' );

function disable_wp_emojis_in_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

// Wrap any iframe and emved tag into div for responsive view

function iframe_wrapper( $content ) {
	// match any iframes
	$pattern = '~<iframe.*?<\/iframe>|<embed.*?<\/embed>~';
	preg_match_all( $pattern, $content, $matches );

	foreach ( $matches[0] as $match ) {
		// Check if it is a video player iframe
		preg_match( '~src="(.*?)"~', $match, $iframe_src );
		if ( is_embed_video( $iframe_src[1] ) ) {
			// wrap matched iframe with div
			$wrappedframe = '<span class="responsive-embed widescreen">' . $match . '</span>';
			//replace original iframe with new in content
			$content = str_replace( $match, $wrappedframe, $content );
		}
	}

	return $content;
}

add_filter( 'the_content', 'iframe_wrapper' );
add_filter( 'acf_the_content', 'iframe_wrapper' );


// Dynamic Admin
if ( is_admin() ) {
	// $dynamic_admin = new DynamicAdmin();
	//	$dynamic_admin->addField( 'page', 'template', 'Page Template', 'template_detail_field_for_page' );

	// $dynamic_admin->run();
}

// Custom outline color
add_action( 'wp_head', 'custom_outline_color' );

function custom_outline_color() {
	$outline_color = get_theme_mod( 'outline_color' );
	if ( $outline_color ) {
		echo "<style>a,input,button,textarea,select{outline-color: {$outline_color}}</style>";
	}
}

// Register Google Maps API key settings in customizer

function register_google_maps_settings( $wp_customize ) {
	$wp_customize->add_section( 'google_maps', array(
		'title'    => __( 'Google Maps', 'default' ),
		'priority' => 30,
	) );

	$wp_customize->add_setting( 'google_maps_api', array(
		'default' => 'AIzaSyBgg23TIs_tBSpNQa8RC0b7fuV4SOVN840',
	) );
	$wp_customize->add_control( 'google_maps_api', array(
		'label'    => __( 'Google Maps API key', 'default' ),
		'section'  => 'google_maps',
		'settings' => 'google_maps_api',
		'type'     => 'text',
	) );

	$wp_customize->add_setting( 'outline_color', array() );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'outline_color', array(
		'label'    => __( 'Outline color', 'default' ),
		'section'  => 'colors',
		'settings' => 'outline_color',
	) ) );
}

add_action( 'customize_register', 'register_google_maps_settings' );

/**
 * Prevent Heartbeat API fire too often. Default is 5 sec, increase it to 60 sec.
 */
add_filter( 'heartbeat_settings', function ( $settings ) {
	$settings['interval'] = 60;

	return $settings;
} );

/**
 * Copyright field functionality
 *
 * @param array $field ACF Field settings
 *
 * @return array
 */

function populate_copyright_instructions( $field ) {
	$field['instructions'] = 'Input <code>@year</code> to replace static year with dynamic, so it will always shows current year.';

	return $field;
}

add_action( 'acf/load_field/name=copyright', 'populate_copyright_instructions' );

if ( ! is_admin() ) {
	// Replace @year with current year
	add_filter( 'acf/load_value/name=copyright', function ( $value ) {
		return str_replace( '@year', date( 'Y' ), $value );
	} );
}

/**
 * Remove 'current_page_parent' class from blog page item on any other post type archives
 *
 * @param array $classes list of classes
 * @param WP_Post $item menu item object
 *
 * @return array list of classes
 */

function remove_blog_page_classes( $classes, $item ) {
	if ( ( is_post_type_archive() || ! is_singular( 'post' ) ) && $item->type == 'post_type' && $item->object_id == get_option( 'page_for_posts' ) ) {
		$classes = array_diff( $classes, array( 'current_page_parent' ) );
	}

	return $classes;
}

add_filter( 'nav_menu_css_class', 'remove_blog_page_classes', 10, 2 );


/**
 * Custom styles in TinyMCE
 *
 * @param array $buttons
 *
 * @return array
 */

function custom_style_selector( $buttons ) {
	array_unshift( $buttons, 'styleselect' );

	return $buttons;
}

add_filter( 'mce_buttons_2', 'custom_style_selector' );

function starter_update_default_tinymce_settings( $init_array ) {
	// Define the style_formats array
	$style_formats               = array(
		array(
			'title'    => 'Heading 1',
			'classes'  => 'h1',
			'selector' => 'h1,h2,h3,h4,h5,h6,p,li',
			'wrapper'  => false,
		),
		array(
			'title'    => 'Heading 2',
			'classes'  => 'h2',
			'selector' => 'h1,h2,h3,h4,h5,h6,p,li',
			'wrapper'  => false,
		),
		array(
			'title'    => 'Heading 3',
			'classes'  => 'h3',
			'selector' => 'h1,h2,h3,h4,h5,h6,p,li',
			'wrapper'  => false,
		),
		array(
			'title'    => 'Heading 4',
			'classes'  => 'h4',
			'selector' => 'h1,h2,h3,h4,h5,h6,p,li',
			'wrapper'  => false,
		),
		array(
			'title'    => 'Heading 5',
			'classes'  => 'h5',
			'selector' => 'h1,h2,h3,h4,h5,h6,p,li',
			'wrapper'  => false,
		),
		array(
			'title'    => 'Heading 6',
			'classes'  => 'h6',
			'selector' => 'h1,h2,h3,h4,h5,h6,p,li',
			'wrapper'  => false,
		),
		array(
			'title'    => 'Button',
			'classes'  => 'button',
			'selector' => 'a',
			'wrapper'  => false,
		),
		array(
			'title'  => 'Small text',
			'inline' => 'small',
		),
		array(
			'title'    => 'Two columns',
			'classes'  => 'two-columns',
			'selector' => 'p,h1,h2,h3,h4,h5,h6,ul',
		),
		array(
			'title'    => 'Three columns',
			'classes'  => 'three-columns',
			'selector' => 'p,h1,h2,h3,h4,h5,h6,ul',
		),
	);
	$init_array['style_formats'] = json_encode( $style_formats );

	// Define Editor styles css version. Preventing hard caching
	$time = filemtime( get_stylesheet_directory() . '/editor-style.css' );
	// Add the timestamp
	$init_array['cache_suffix'] = 'v=' . $time;

	// Add custom color to TinyMCE editor text color selector
	$default_colours = '"000000", "Black","993300", "Burnt orange","333300", "Dark olive","003300", "Dark green","003366", "Dark azure","000080", "Navy Blue","333399", "Indigo","333333", "Very dark gray","800000", "Maroon","FF6600", "Orange","808000", "Olive","008000", "Green","008080", "Teal","0000FF", "Blue","666699", "Grayish blue","808080", "Gray","FF0000", "Red","FF9900", "Amber","99CC00", "Yellow green","339966", "Sea green","33CCCC", "Turquoise","3366FF", "Royal blue","800080", "Purple","999999", "Medium gray","FF00FF", "Magenta","FFCC00", "Gold","FFFF00", "Yellow","00FF00", "Lime","00FFFF", "Aqua","00CCFF", "Sky blue","993366", "Brown","C0C0C0", "Silver","FF99CC", "Pink","FFCC99", "Peach","FFFF99", "Light yellow","CCFFCC", "Pale green","CCFFFF", "Pale cyan","99CCFF", "Light sky blue","CC99FF", "Plum","FFFFFF", "White"';

	$custom_colours = '';

	foreach ( get_theme_colors() as $color ) {
		$custom_colours .= '"' . str_replace( '#', '', $color['color'] ) . '","' . $color['name'] . '",';
	}

	$init_array['textcolor_map']  = '[' . $default_colours . ',' . $custom_colours . ']';
	$init_array['textcolor_rows'] = 6; // expand colour grid to 6 rows

	return $init_array;
}

add_filter( 'tiny_mce_before_init', 'starter_update_default_tinymce_settings' );

// Include styles for TinyMCE editor
add_editor_style();

/**
 * Populate ACF color picker swatches with custom colors
 *
 * @return void
 */
function starter_custom_color_picker_colors() {
	$site_colors = get_theme_colors();
	$colors      = wp_list_pluck( $site_colors ?? [], 'color' );
	if ( $colors ) {
		$colors_num     = count( $colors );
		$default_colors = [ '#000', '#fff', '#d33', '#d93', '#ee2', '#81d742', '#1e73be', '#8224e3' ];
		array_splice( $default_colors, 0, $colors_num, $colors );
		$colors_string = json_encode( $default_colors );
		wp_add_inline_script( 'acf-input', "acf.add_filter('color_picker_args', function( args ){args.palettes={$colors_string}; return args; });" );
	}

	wp_add_inline_style( 'acf-input', "body .iris-picker .iris-palette{box-shadow:inset 0 0 2px rgba(0,0,0,.4)}" );
}

add_action( 'acf/input/admin_enqueue_scripts', 'starter_custom_color_picker_colors' );

// Custom Search Filter
function filter_search_results($query) {
    if ($query->is_search() && $query->is_main_query() && !is_admin()) {

        $audience_tax = isset($_GET['audience']) ? $_GET['audience'] : '';
        $article_category = isset($_GET['article-category']) ? $_GET['article-category'] : '';

        $tax_query = array('relation' => 'AND');

        if (!empty($audience_tax)) {
            $tax_query[] = array(
                'taxonomy' => 'audience',
                'field'    => 'slug',
                'terms'    => $audience_tax,
            );
        }

        if (!empty($article_category)) {
            $tax_query[] = array(
                'taxonomy' => 'article-category',
                'field'    => 'slug',
                'terms'    => $article_category,
            );
        }

        if (!empty($tax_query)) {
            $query->set('tax_query', $tax_query);
        }
    }
}

add_action('pre_get_posts', 'filter_search_results');

// Move Yoast Meta Box to bottom

function yoasttobottom() {
	return 'low';
}

add_filter( 'wpseo_metabox_prio', 'yoasttobottom' );

/**
 * Gravity forms custom functions
 */

/**
 * Enable GF Honeypot for all forms
 *
 * @param $form
 * @param $is_new
 */

function enable_honeypot_on_new_form_creation( $form, $is_new ) {
	if ( $is_new ) {
		$form['enableHoneypot'] = true;
		$form['is_active']      = 1;
		GFAPI::update_form( $form );
	}
}

add_action( 'gform_after_save_form', 'enable_honeypot_on_new_form_creation', 10, 2 );

/**
 * Disable date field autocomplete popup
 *
 * @param string $input field HTML markup
 * @param object $field GForm field object
 *
 * @return string
 */

function gform_remove_date_autocomplete( $input, $field ) {
	if ( is_admin() ) {
		return $input;
	}
	if ( $field->type == 'date' ) {
		$input = str_replace( '<input', '<input autocomplete="off" ', $input );
	}

	return $input;
}

add_filter( 'gform_field_content', 'gform_remove_date_autocomplete', 11, 2 );

// Prevent page jumping on form submit
add_filter( 'gform_confirmation_anchor', '__return_false' );

// Show Gravity Form field label appearance dropdown
add_filter( 'gform_enable_field_label_visibility_settings', '__return_true' );

// Replace standard form input with button
function form_submit_button( $button, $form ) {
	if ( $form['button']['type'] == 'image' && ! empty( $form['button']['imageUrl'] ) ) {
		return $button;
	}

	preg_match( "~value=(?:\"|')(.*?)(?:\"|')~", $button, $matches );

	return str_replace( array( 'input', '/>' ), array( 'button', '>' ), $button ) . "{$matches[1]}</button>";
}

add_filter( "gform_submit_button", "form_submit_button", 10, 2 );
add_filter( "gform_next_button", "form_submit_button", 10, 2 );
add_filter( "gform_previous_button", "form_submit_button", 10, 2 );

// Add ADA support on Gravity form error message
function form_submit_error_ada_notice( $msg ) {
	return str_replace( "class=", "role='alert' class=", $msg );
}

add_filter( 'gform_validation_message', 'form_submit_error_ada_notice' );

// Add ADA support on Gravity form success message
function form_submit_success_ada_notice( $msg ) {
	return str_replace( "id='gform_confirmation_message", "role='alert' id='gform_confirmation_message", $msg );
}

add_filter( 'gform_confirmation', 'form_submit_success_ada_notice' );

// Prevent loading Gravity forms styles
//add_filter( 'gform_disable_css', '__return_true' );

// Overwrite default gravity forms theme slug
/*add_filter( 'gform_form_theme_slug', function () {
	return 'gravity-theme';
} );*/

// Preselect gravity form legacy theme in Gutenberg block
/*add_action( 'enqueue_block_editor_assets', function () {
	wp_add_inline_script( 'gform_gravityforms_admin', 'wp.hooks.addFilter("blocks.registerBlockType","gravityforms/form",(t,r)=>"gravityforms/form"===r?Object.assign({},t,{attributes:Object.assign({},t.attributes,{theme:{type:"string",default:"gravity-theme"}})}):t);' );
} );*/

/**
 * Remove US phone format from Gravity forms phone field
 *
 * @param array $options List of phone options
 *
 * @return array
 */
function starter_gf_limit_phone_formats( $options ) {
	if ( ! empty( $options['standard'] ) && ! empty( $options['international'] ) ) {
		$options['standard'] = $options['international'];
		unset( $options['international'] );
	}

	return $options;
}

add_filter( 'gform_phone_formats', 'starter_gf_limit_phone_formats' );

/**
 * Update Gravity forms title column with instruction
 *
 * @param array $columns List of columns
 *
 * @return array
 */
function starter_update_forms_title_column( $columns ) {
	if ( ! empty( $columns['title'] ) ) {
		$columns['title'] = $columns['title'] . ' ' . __( '(Use ACF text to output form title, instead of Form title)', 'starter' );
	}

	return $columns;
}

add_filter( 'gform_form_list_columns', 'starter_update_forms_title_column' );

/**
 * Allow script and iframe html tags within ACF WYSIWYG editor field
 */

add_filter( 'acf/the_field/allow_unsafe_html', '__return_true' );

/*********************** PUT YOU FUNCTIONS BELOW ********************************/

add_image_size( 'full_hd', 1920, 0, array( 'center', 'center' ) );
add_image_size( 'large_high', 1024, 0, false );
// add_image_size( 'name', width, height, array('center','center'));

/**
 * Replace WordPress email Sender name
 *
 * @return string
 */
function replace_email_sender_name() {
	return get_bloginfo();
}

add_filter( 'wp_mail_from_name', 'replace_email_sender_name' );

/**
 * Add WooCommerce support
 */
function theme_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
	// add_theme_support( 'wc-product-gallery-zoom' );
	// add_theme_support( 'wc-product-gallery-lightbox' );
	// add_theme_support( 'wc-product-gallery-slider' );
}

add_action( 'after_setup_theme', 'theme_add_woocommerce_support' );

/**
 * Add the wp-editor back into WordPress after it was removed in 4.2.2.
 *
 * @param Object $post
 *
 * @return void
 */
function starter_show_editor_on_posts_page( $post ) {
	if ( isset( $post ) && $post->ID != get_option( 'page_for_posts' ) ) {
		return;
	}
	
	// Remove Notice "You are currently editing the page that shows your latest posts."
	remove_action( 'edit_form_after_title', '_wp_posts_page_notice' );
	
	// Add content editor to the posts page
	add_post_type_support( 'page', 'editor' );
}

//add_action( 'edit_form_after_title', 'starter_show_editor_on_posts_page', 1 );

/**
 * Theme main colors.
 *
 * @return array
 */
function get_theme_colors() {
	// Default colors fallback.
	// TODO Fill $palette array with main design colors to be able use in Gutenberg editor 
	$palette = [
		[ "name" => "Black", "slug" => "black", "color" => "#000000" ],
		[ "name" => "White", "slug" => "white", "color" => "#ffffff" ],
		[ "name" => "Blue", "slug" => "blue", "color" => "#2d22b4" ],
		[ "name" => "Main White", "slug" => "white-main", "color" => "#FBFBFA" ],
		[ "name" => "Green", "slug" => "green", "color" => "#576949" ],
		[ "name" => "Gray", "slug" => "gray", "color" => "#9C9C9C" ],
		[ "name" => "Light Gray", "slug" => "light-gray", "color" => "#C2C4C0" ],
		[ "name" => "Orange", "slug" => "orange", "color" => "#F5A200" ],
		[ "name" => "Light Green", "slug" => "light-green", "color" => "#DFE5DC" ],
		[ "name" => "Text Black", "slug" => "light-green", "color" => "#21201F" ],
	];
	return $palette;
}

/**
 * Most popular html
 * @param $popular_posts
 * @param $instance
 * @return string
 */
function getCurrentUrl() {
    return $_GET['id'];
}
function my_custom_popular_posts_html_list($popular_posts, $instance) {
    $url = $_SERVER['HTTP_REFERER'];
    $parsed_url = parse_url($url);
    parse_str($parsed_url['query'], $query_params);
    $id = $query_params['id'];
    if ( !empty( $id )) {

        $output = '<div class="wpp-list most-popular-slider articles-slider">';
        foreach( $popular_posts as $popular_post ) {
            $term = get_term($instance['term_id']);
            $primary_category_id = get_post_meta($popular_post->id, '_yoast_wpseo_primary_article-category', true);
            if ((int)$primary_category_id === $term->term_id) {
                $labels = get_the_terms($popular_post->id, 'article-category');
                $term_format = get_the_terms($popular_post->id, 'format');
                $term_audience = get_the_terms($popular_post->id, 'audience');
                $time = get_field('minutes_to', $popular_post->id);
                $article_excerpt = get_field('article_excerpt', $popular_post->id);
                $post_data = get_post($popular_post->id);
                $post_url = get_permalink($popular_post->id);
                $alt = get_post_meta(get_post_thumbnail_id($popular_post->id), '_wp_attachment_image_alt', true);
                $src = get_attached_img_url($popular_post->id);

                $output .= "<div class='article-item'>";
                $output .= "<div class='post-practitioner-category'>";
//                $cat_name = $labels[0]->name;
//                $cat_link = get_category_link($labels[0]->term_id);
                $term_link = get_category_link($instance['term_id']);
                if ($term_audience[0]->slug === 'hcp') {
                    $output .= "<span><img class='category-icon' src='" . get_template_directory_uri() . "/assets/images/categ-icon.svg'></span>";
                }
//                if ($instance['taxonomy'] === 'article-category') {
                    $args_query = array(
                        'post_type' => 'article',
                        'order' => 'DESC',
                        'posts_per_page' => 10,
                        'meta_query'     => array(
                            array(
                                'key'     => '_yoast_wpseo_primary_article-category',
                                'value'   => (string)$term->term_id,
                                'compare' => '='
                            ),
                        ),
                        'tax_query' => array(
                            array(
                                'taxonomy' => $term->taxonomy,
                                'field' => 'id',
                                'terms' => $term->term_id,
                            ),
                        ),
                    );
                    $query_posts = new WP_Query( $args_query );
                    if (count($query_posts->posts) > 3) {
                        $output .= "<a href=' ".$term_link ."?id=" . $term_audience[0]->slug."'><span class='post-category'> $term->name </span></a>";
                    } else {
                        $output .= "<span class='post-category not-allow'> $term->name </span>";
                    }

//                } else {
//                    if ($cat_name) {
//                        $output .= "<a href='" . $cat_link . "?id=" . $term_audience[0]->slug . "'><span class='post-category'> $cat_name </span></a>";
//                    }
//                }

                $output .= "</div>" . "\n";
                $output .= "<a class='article-title' href='$post_url'>" . $popular_post->title . "</a>";
                $output .= "<div class='post-info-block'>";
                $output .= "<b>" . (strlen(get_the_author_meta('display_name', $post_data->post_author)) > 24 ? substr(get_the_author_meta('display_name', $post_data->post_author), 0, 20) . '...' : get_the_author_meta('display_name', $post_data->post_author)) . "</b>";
                $output .= "<span><img class='format-icon' src='" . get_template_directory_uri() . "/assets/images/format-icons/" . $term_format[0]->slug . ".svg'></span>";
                $output .= "<span><i>(";
                $output .= $time . " min ";
                if ($term_format[0]->slug === 'video') {
                    $output .= "watch)";
                } elseif ($term_format[0]->slug === 'podcast') {
                    $output .= "listen)";
                } else {
                    $output .= "read)</i></span>";
                }
                $output .= "</div>" . "\n";
                $output .= "<div class='post-contact-popular'>" . "\n";
                $output .= (empty($article_excerpt) ? wp_strip_all_tags(get_the_content(null, true, $post_data->ID)) : $article_excerpt);
                $output .= "</div>" . "\n";
                $output .= "<div class='article-item-image-wrap'>" . "\n";
                $output .=  "<a class='overlay' href='$post_url' aria-hidden='true' tabindex='-1'></a><img class='" . ($src ? 'lazyloading' : 'placeholder-img') . "' alt='$alt' src='" . ($src ? $src : get_template_directory_uri() . '/assets/images/placeholder.svg') . "'>";
                $output .= "</div>" . "\n";
                if (!is_page(128)) {
                    if ($term_format[0]->slug === 'video') {
                        $output .= "<a class='article-button' href='$post_url'>Watch video" . is_page(128) . "<img alt='' src='" . get_template_directory_uri() . '/assets/images/arrow-button.svg' . "'></a>";
                    } elseif ($term_format[0]->slug === 'podcast') {
                        $output .= "<a class='article-button' href='$post_url'>Listen to Podcast<img alt='' src='" . get_template_directory_uri() . '/assets/images/arrow-button.svg' . "'></a>";
                    } else {
                        $output .= "<a class='article-button' href='$post_url'>Read Article<img alt='' src='" . get_template_directory_uri() . '/assets/images/arrow-button.svg' . "'></a>";
                    }
                } else {
                    $output .= "<a class='article-button' href='$post_url'>Read Article<img alt='' src='" . get_template_directory_uri() . '/assets/images/arrow-button.svg' . "'></a>";
                };
                $output .= "</div>" . "\n";
            }
        }



        $output .= '</div>';
    }
    else{
        $output = '<div class="wpp-list most-popular-slider articles-slider">';
        foreach( $popular_posts as $popular_post ) {
            $term = get_term($instance['term_id']);
            $primary_category_id = get_post_meta($popular_post->id, '_yoast_wpseo_primary_article-category', true);
            if ((int)$primary_category_id === $term->term_id) {
                $labels = get_the_terms($popular_post->id, 'article-category');
                $term_format = get_the_terms($popular_post->id, 'format');
                $term_audience = get_the_terms($popular_post->id, 'audience');
                $time = get_field('minutes_to', $popular_post->id);
                $article_excerpt = get_field('article_excerpt', $popular_post->id);
                $post_data = get_post($popular_post->id);
                $post_url = get_permalink($popular_post->id);
                $alt = get_post_meta(get_post_thumbnail_id($popular_post->id), '_wp_attachment_image_alt', true);
                $src = get_attached_img_url($popular_post->id);
                $output .= "<div class='article-item'>";
                $output .= "<div class='post-practitioner-category'>";
                $cat_name = $labels[0]->name;
                $cat_link = get_category_link($labels[0]->term_id);
                $term_link = get_category_link($instance['term_id']);
                $audience_link = get_category_link($term_audience[0]->term_id);
                $args_query = array(
                    'post_type' => 'article',
                    'order' => 'DESC',
                    'posts_per_page' => 10,
                    'meta_query' => array(
                        array(
                            'key' => '_yoast_wpseo_primary_article-category',
                            'value' => (string)$labels[0]->term_id,
                            'compare' => '='
                        ),
                    ),
                    'tax_query' => array(
                        array(
                            'taxonomy' => $labels[0]->taxonomy,
                            'field' => 'id',
                            'terms' => $labels[0]->term_id,
                        ),
                    ),
                );
                $query_posts = new WP_Query($args_query);
                if ($term_audience[0]->slug === 'hcp') {
                    $output .= "<span><img class='category-icon' src='" . get_template_directory_uri() . "/assets/images/categ-icon.svg'></span>";
                }
                if ($instance['taxonomy'] === 'article-category') {
                    if (count($query_posts->posts) > 3) {
                        $output .= "<a href='" . $term_link . "?id=" . $term_audience[0]->slug . "'><span class='post-category'> $term->name </span></a>";
                    } else {
                        $output .= "<span class='post-category not-allow'> $term->name </span>";
                    }
                } else {
                    if ($cat_name) {
                        if (count($query_posts->posts) > 3) {
                            $output .= "<a href='" . $cat_link . "?id=" . $term_audience[0]->slug . "'><span class='post-category'> $cat_name </span></a>";
                        } else {
                            $output .= "<span class='post-category not-allow'> $cat_name </span>";
                        }
                    }
                }

                $output .= "</div>" . "\n";
                $output .= "<a class='article-title' href='$post_url'>" . $popular_post->title . "</a>";
                $output .= "<div class='post-info-block'>";
                $output .= "<b>" . (strlen(get_the_author_meta('display_name', $post_data->post_author)) > 24 ? substr(get_the_author_meta('display_name', $post_data->post_author), 0, 20) . '...' : get_the_author_meta('display_name', $post_data->post_author)) . "</b>";
                $output .= "<span><img class='format-icon' src='" . get_template_directory_uri() . "/assets/images/format-icons/" . $term_format[0]->slug . ".svg'></span>";
                $output .= "<span><i>(";
                $output .= $time . " min ";
                if ($term_format[0]->slug === 'video') {
                    $output .= "watch)</i></span>";
                } elseif ($term_format[0]->slug === 'podcast') {
                    $output .= "listen)</i></span>";
                } else {
                    $output .= "read)</i></span>";
                }
                $output .= "</div>" . "\n";
                $output .= "<div class='post-contact-popular'>" . "\n";
                $output .= (empty($article_excerpt) ? wp_strip_all_tags(get_the_content(null, true, $post_data->ID)) : $article_excerpt);
                $output .= "</div>" . "\n";
                $output .= "<div class='article-item-image-wrap'>" . "\n";
                $output .= "<a class='overlay' href='$post_url'></a><img alt='$alt' class='" . ($src ? 'lazyloading' : 'placeholder-img') . "' src='" . ($src ? $src : get_template_directory_uri() . '/assets/images/placeholder.svg') . "'>";
                $output .= "</div>" . "\n";
                if (!is_page(128)) {
                    if ($term_format[0]->slug === 'video') {
                        $output .= "<a class='article-button' href='$post_url'>Watch video" . is_page(128) . "<img alt='' src='" . get_template_directory_uri() . '/assets/images/arrow-button.svg' . "'></a>";
                    } elseif ($term_format[0]->slug === 'podcast') {
                        $output .= "<a class='article-button' href='$post_url'>Listen to Podcast<img alt='' src='" . get_template_directory_uri() . '/assets/images/arrow-button.svg' . "'></a>";
                    } else {
                        $output .= "<a class='article-button' href='$post_url'>Read Article<img alt='' src='" . get_template_directory_uri() . '/assets/images/arrow-button.svg' . "'></a>";
                    }
                } else {
                    $output .= "<a class='article-button' href='$post_url'>Read Article<img alt='' src='" . get_template_directory_uri() . '/assets/images/arrow-button.svg' . "'></a>";
                };
                $output .= "</div>" . "\n";
            } else {
                if ( strpos( $parsed_url['path'], 'category' ) === false ) {
                    $labels = get_the_terms($popular_post->id, 'article-category');
                    $term_format = get_the_terms($popular_post->id, 'format');
                    $term_audience = get_the_terms($popular_post->id, 'audience');
                    $time = get_field('minutes_to', $popular_post->id);
                    $article_excerpt = get_field('article_excerpt', $popular_post->id);
                    $post_data = get_post($popular_post->id);
                    $post_url = get_permalink($popular_post->id);
                    $alt = get_post_meta(get_post_thumbnail_id($popular_post->id), '_wp_attachment_image_alt', true);
                    $src = get_attached_img_url($popular_post->id);
                    $output .= "<div class='article-item'>";
                    $output .= "<div class='post-practitioner-category'>";
                    $cat_name = $labels[0]->name;
                    $cat_link = get_category_link($labels[0]->term_id);
                    $term_link = get_category_link($instance['term_id']);
                    $audience_link = get_category_link($term_audience[0]->term_id);
                    $args_query = array(
                        'post_type' => 'article',
                        'order' => 'DESC',
                        'posts_per_page' => 10,
                        'meta_query' => array(
                            array(
                                'key' => '_yoast_wpseo_primary_article-category',
                                'value' => (string)$labels[0]->term_id,
                                'compare' => '='
                            ),
                        ),
                        'tax_query' => array(
                            array(
                                'taxonomy' => $labels[0]->taxonomy,
                                'field' => 'id',
                                'terms' => $labels[0]->term_id,
                            ),
                        ),
                    );
                    $query_posts = new WP_Query($args_query);
                    if ($term_audience[0]->slug === 'hcp') {
                        $output .= "<span><img class='category-icon' src='" . get_template_directory_uri() . "/assets/images/categ-icon.svg'></span>";
                    }
                    if ($instance['taxonomy'] === 'article-category') {
                        if (count($query_posts->posts) > 3) {
                            $output .= "<a href='" . $term_link . "?id=" . $term_audience[0]->slug . "'><span class='post-category'> $term->name </span></a>";
                        } else {
                            $output .= "<span class='post-category not-allow'> $term->name </span>";
                        }
                    } else {
                        if ($cat_name) {
                            if (count($query_posts->posts) > 3) {
                                $output .= "<a href='" . $cat_link . "?id=" . $term_audience[0]->slug . "'><span class='post-category'> $cat_name </span></a>";
                            } else {
                                $output .= "<span class='post-category not-allow'> $cat_name </span>";
                            }
                        }
                    }

                    $output .= "</div>" . "\n";
                    $output .= "<a class='article-title' href='$post_url'>" . $popular_post->title . "</a>";
                    $output .= "<div class='post-info-block'>";
                    $output .= "<b>" . (strlen(get_the_author_meta('display_name', $post_data->post_author)) > 24 ? substr(get_the_author_meta('display_name', $post_data->post_author), 0, 20) . '...' : get_the_author_meta('display_name', $post_data->post_author)) . "</b>";
                    $output .= "<span><img class='format-icon' src='" . get_template_directory_uri() . "/assets/images/format-icons/" . $term_format[0]->slug . ".svg'></span>";
                    $output .= "<span><i>(";
                    $output .= $time . " min ";
                    if ($term_format[0]->slug === 'video') {
                        $output .= "watch)</i></span>";
                    } elseif ($term_format[0]->slug === 'podcast') {
                        $output .= "listen)</i></span>";
                    } else {
                        $output .= "read)</i></span>";
                    }
                    $output .= "</div>" . "\n";
                    $output .= "<div class='post-contact-popular'>" . "\n";
                    $output .= (empty($article_excerpt) ? wp_strip_all_tags(get_the_content(null, true, $post_data->ID)) : $article_excerpt);
                    $output .= "</div>" . "\n";
                    $output .= "<div class='article-item-image-wrap'>" . "\n";
                    $output .= "<a class='overlay' href='$post_url'></a><img alt='$alt' class='" . ($src ? 'lazyloading' : 'placeholder-img') . "' src='" . ($src ? $src : get_template_directory_uri() . '/assets/images/placeholder.svg') . "'>";
                    $output .= "</div>" . "\n";
                    if (!is_page(128)) {
                        if ($term_format[0]->slug === 'video') {
                            $output .= "<a class='article-button' href='$post_url'>Watch video" . is_page(128) . "<img alt='' src='" . get_template_directory_uri() . '/assets/images/arrow-button.svg' . "'></a>";
                        } elseif ($term_format[0]->slug === 'podcast') {
                            $output .= "<a class='article-button' href='$post_url'>Listen to Podcast<img alt='' src='" . get_template_directory_uri() . '/assets/images/arrow-button.svg' . "'></a>";
                        } else {
                            $output .= "<a class='article-button' href='$post_url'>Read Article<img alt='' src='" . get_template_directory_uri() . '/assets/images/arrow-button.svg' . "'></a>";
                        }
                    } else {
                        $output .= "<a class='article-button' href='$post_url'>Read Article<img alt='' src='" . get_template_directory_uri() . '/assets/images/arrow-button.svg' . "'></a>";
                    };
                    $output .= "</div>" . "\n";
                }
            }
        }

        $output .= '</div>';
    }
    return $output;
}
add_filter('wpp_custom_html', 'my_custom_popular_posts_html_list', 10, 2);

add_filter( 'gform_confirmation', 'custom_confirmation', 10, 4 );

function custom_confirmation( $confirmation, $form, $entry, $ajax = true ) {
    $form_id = $form['fields'][0]['formId'];
    $confirmation = "Thanks, you're signed-up!";
    $output = '<div id="gform_confirmation_wrapper_'.$form_id.'" class="gform_fields-confirm">';
    $output .= '<div id="gf_'.$form['fields'][0]['formId'].'" class="gform_anchor" tabindex="-1"></div>';
    $output .= '<h3 class="gform_title">'.$form['title'].'</h3>';
    if ($form_id !== 5) {
        $output .= '<div class="group-radio">';
        $output .= '<input type="radio" id="'.$form['fields'][0]['choices'][0]['value'].'" '. ($entry[6] === $form['fields'][0]['choices'][0]['text']  ? 'checked="checked"' : "disabled" ).'>';
        $output .= '<label for="practitioner">'. $form['fields'][0]['choices'][0]['text'] . '</label>';
        $output .= '</div>';
        $output .= '<div class="group-radio">';
        $output .= '<input type="radio" id="'.$form['fields'][0]['choices'][1]['value'].'" '. ($entry[6] === $form['fields'][0]['choices'][1]['text']  ? 'checked="checked"' : "disabled" ).'>';
        $output .= '<label for="practitioner">'. $form['fields'][0]['choices'][1]['text'] . '</label>';
        $output .= '</div>';
    }
    $output .= '<div class="ginput_container_email">';
    $output .= '<input disabled value="'. $entry[5] . '">';
    $output .= return_svg(get_template_directory_uri().'/assets/images/done.svg', 'arrow-button');
    $output .= '</div>';
    $output .= '<p id="gform_confirmation_message_'.$form_id.'" >'.$confirmation .'</p>';
    $output .= '</div>';

    return $output;
}

add_action( 'wp_ajax_load_more_callback', 'load_more_callback' );
add_action( 'wp_ajax_nopriv_load_more_callback', 'load_more_callback' );

function load_more_callback() {

    $args = array(
        'post_type' => 'article',
        'order' => 'ASC',
        'posts_per_page' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'audience',
                'field' => 'id',
                'terms' => $_POST['type'],
            ),
        ),

    );

    $query = new WP_Query( $args );

    $categories = [];
    foreach ($query->posts as $post) {
        $post_id = get_the_terms($post->ID, 'article-category')[0]->term_id;
        if (!in_array($post_id, $categories))  {
            $categories[] = $post_id;
        }
    }
    $max_pages = $query->max_num_pages;
    if ( $categories ):
        ob_start();
        foreach ($categories as $id ):
            $term = get_term_by('term_id', $id, 'article-category');
            $image = get_field('category_image', 'article-category_' . $term->term_id);
            $response = get_template_part( 'parts/loop', 'grid', ['id' => $id, 'title' => $term->name, 'alt' => $image['alt'], 'url' => $image['url']]);
        endforeach;
        $output = ob_get_contents();

        ob_end_clean();
    else: $response = '';
    endif;
    $result = [
        'max' => $max_pages,
        'html' => $output,
    ];
    echo  json_encode($result);
    exit;
}

add_action( 'wp_ajax_load_more_media_callback', 'load_more_media_callback' );
add_action( 'wp_ajax_nopriv_load_more_media_callback', 'load_more_media_callback' );
add_filter( 'gform_confirmation_anchor', '__return_true' );
function load_more_media_callback() {

    $args = array(
        'post_type' => 'article',
        'order' => 'DESC',
        'posts_per_page' => $_POST['per'],
        'paged'         => $_POST['paged'],
        'tax_query' => array(
            array(
                'taxonomy' => $_POST['tax'],
                'field' => 'slug',
                'terms' => $_POST['type'],
            ),
        ),
    );

    $query = new WP_Query( $args );

   $max_pages = $query->max_num_pages;
    if ( $query->posts ):
        ob_start();
        foreach ($query->posts as $post ):
            $response = get_template_part( 'parts/loop', 'media-article', ['post' => $post ]  );
        endforeach;
        $output = ob_get_contents();

        ob_end_clean();
    else: $response = '';
    endif;
    $result = [
        'max' => $max_pages,
        'html' => $output,
    ];
    echo  json_encode($result);
    exit;
}

add_action('wp_ajax_show_footer_email', 'show_footer_email');
add_action('wp_ajax_nopriv_show_footer_email', 'show_footer_email');
function show_footer_email() {
    $footer_contact_email = get_field('footer_contact_email', 'options');
    ob_start();

    echo '<button type="button" class="contact-block-email" href="mailto:'.$footer_contact_email.'">'.$footer_contact_email.'</button>';

    $output = ob_get_clean();

    echo $output;

    wp_die();
}
function title_filter( $where, &$wp_query ){
    global $wpdb;
    if ( $search_term = $wp_query->get( 'search_prod_title' ) ) {
        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( $wpdb->esc_like( $search_term ) ) . '%\'';
    }
    return $where;
}

add_action( 'wp_ajax_load_more_herbal_callback', 'load_more_herbal_callback' );
add_action( 'wp_ajax_nopriv_load_more_herbal_callback', 'load_more_herbal_callback' );

function load_more_herbal_callback() {

    $args = array(
        'post_type' => 'herbal_glosarry',
        'posts_per_page' => 12,
        'paged'         => $_POST['paged'],
    );
    if (!empty($_POST['searchValue'])) {
        $args['meta_query'] = array(
                array(
                    'key'     => 'used_for',
                    'value'   => $_POST['searchValue'],
                    'compare' => 'LIKE'
                )
        );
    }
    add_filter( 'posts_where', 'title_filter', 10, 2 );
    $query = new WP_Query( $args );
    remove_filter( 'posts_where', 'title_filter', 10, 2 );
    $max_pages = $query->max_num_pages;
    if ( $query->posts ):
        ob_start();
        foreach ($query->posts as $post ):
            $alt = get_post_meta( get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true);
            $url = get_attached_img_url($post->ID);
            get_template_part( 'parts/loop', 'grid', ['id' => $post->ID, 'title' => $post->post_title, 'alt' => $alt, 'url' => $url ]);
        endforeach;
        $output = ob_get_contents();

        ob_end_clean();
    else: $response = '';
    endif;
    $result = [
        'max' => $max_pages,
        'html' => $output,
    ];
    echo  json_encode($result);
    exit;
}


add_action( 'wp_ajax_filter_media_callback', 'filter_media_callback' );
add_action( 'wp_ajax_nopriv_filter_media_callback', 'filter_media_callback' );

function filter_media_callback() {
//    var_dump((int)$_POST['termId']);
    $args = array(
        'post_type' => 'article',
        'order' => 'DESC',
        'posts_per_page' => $_POST['paged'],
        'meta_query'     => array(
            array(
                'key'     => '_yoast_wpseo_primary_article-category',
                'value'   => (int)$_POST['termId'],
                'compare' => '='
            ),
        ),
        'tax_query' => array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'article-category',
                'field' => 'id',
                'terms' => (int)$_POST['termId'],

            ),
        ),
    );
    if (!empty($_POST['term'])) {
        $args['tax_query'] = array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'article-category',
                'field' => 'id',
                'terms' => (int)$_POST['termId'],

            ),
            array(
                'taxonomy' => 'format',
                'field' => 'slug',
                'terms' => $_POST['term'],

            ),
        );
    }
    if ( !empty( $_POST['urlAudience'] )) {
        $arr = array(
            'taxonomy' => 'audience',
            'field' => 'slug',
            'terms' => $_POST['urlAudience'],
        );
        array_push($args['tax_query'], $arr);
    }

    $query = new WP_Query( $args );
    $max_pages = $query->found_posts;
    if ( $query->posts ):
        ob_start();
        foreach ($query->posts as $post ):
                get_template_part( 'parts/loop', 'media-article', ['post' => $post ]  );
        endforeach;
        $output = ob_get_contents();

        ob_end_clean();
    else: $response = '';
    endif;
    $result = [
        'max' => $max_pages,
        'html' => $output,
    ];
    echo  json_encode($result);
    exit;
}


add_filter( 'wpp_query_args', 'modify_wpp_query' );



function custom_article_category_slug($args, $taxonomy) {
    if ('category' === $taxonomy) {
        $args['rewrite'] = array(
            'slug' => 'post-category',
            'with_front' => false
        );
    }
    return $args;
}
add_filter('register_taxonomy_args', 'custom_article_category_slug', 10, 2);

function custom_article_category_rewrite_rules() {
    add_rewrite_rule(
        '^category/([^/]+)/?$',
        'index.php?article-category=$matches[1]',
        'top'
    );
}
add_action('init', 'custom_article_category_rewrite_rules');

function flush_rewrite_rules_on_activation() {
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'flush_rewrite_rules_on_activation');



/*******************************************************************************/

// Gutenberg should be used by default!!!
// TODO comment acf_gutenberg support if Classic Editor is required  
add_theme_support( 'acf_gutenberg' );

// TODO uncomment acf_flexible support ONLY if Flexible Content is required by client
//add_theme_support( 'acf_flexible' );



/**
 * Search by taxonomy term
 */
function match_score($search_term, $term_name) {
    $search_term = trim($search_term);

    $search_words_input = preg_split('/\s+/', trim($search_term));
    $term_words_input = preg_split('/\s+/', trim($term_name));

    $search_words = array_map(function($word) {
        return preg_replace('/[^\p{L}\p{N}\s]+/u', '', $word);
    }, $search_words_input);

    $term_words = array_map(function($word) {
        return preg_replace('/[^\p{L}\p{N}\s]+/u', '', $word);
    }, $term_words_input);

    if (mb_strtolower($term_name) === mb_strtolower($search_term)) {
        return PHP_INT_MAX;
    }

    $score = 0;
    if(!empty($search_words) && !$search_words[0] == ''){
        foreach ($search_words as $search_word) {
            if(!$search_word == ''){
                foreach ($term_words as $term_word) {
                    if (!$term_word == '' && mb_strpos(mb_strtolower($term_word), mb_strtolower($search_word)) === 0) {
                        $score++;
                    }
                }
            }
        }
    }

    return $score;
}



function filtered_terms ($query) {
    $search_term = $query->query_vars['s'];
    $taxonomies = get_taxonomies( array(
        'public'   => true,
        '_builtin' => false,
    ), 'names' );

    $found_terms = [];

    foreach ($taxonomies as $taxonomy){
        $terms = get_terms( array(
            'taxonomy'   => $taxonomy,
        ) );

        foreach ($terms as $term) {
            $score = match_score($search_term, $term->name);
            if ($score > 0) {
                $found_terms[] = [
                    'term' => $term,
                    'score' => $score,
                ];
            }
        }

    }
    usort($found_terms, function($a, $b) {
        return $b['score'] - $a['score'];
    });

    return array_map(function($item) {
        return $item['term'];
    }, $found_terms);

}



function modify_search_query_for_pagination( $query ) {
    if ( ! is_admin() && $query->is_search() && $query->is_main_query() ) {

        $terms = filtered_terms ($query);

        //$term_count = count( $terms );


        //$query->term_count = $term_count;
        //$query->terms = $terms;

        //$query->found_posts +=  $term_count;


        //$posts_per_page = $query->get( 'posts_per_page' );
        //if(!$posts_per_page) {
        //    $posts_per_page = get_option( 'posts_per_page' );
        //}

        //$paged = max( 1, $query->get( 'paged' ) );
        //$offset = ( $paged - 1 ) * $posts_per_page - $term_count;


        //if ( $offset > 0 ) {
        //    $query->set( 'offset', $offset );
        //} else {
        //    $query->set( 'offset', 0 );
        //}



        $search_term = $query->get('s');
        if (!empty($search_term)) {
            global $wpdb;
            $active_post_types = get_post_types(['public' => true]);
            $placeholders = implode(',', array_fill(0, count($active_post_types), '%s'));
            $exact_match_posts = $wpdb->get_results($wpdb->prepare(
                "SELECT * FROM {$wpdb->posts}
                WHERE (post_title = %s OR post_content = %s)
                AND post_status = 'publish'
                AND post_type IN ($placeholders)",
                array_merge([$search_term, $search_term], $active_post_types)
            ));
//            $exact_match_posts = $wpdb->get_results($wpdb->prepare(
//                "SELECT * FROM {$wpdb->posts}
//                WHERE (post_title = %s OR post_content = %s)
//                AND post_status = 'publish'",
//                $search_term,
//                $search_term
//            ));
            if ($exact_match_posts) {
                $post_not_in = [];
                foreach ($exact_match_posts as $exact_match_post) {

                    $exact_match_post = get_post($exact_match_post->ID);

                    if (!in_array($exact_match_post, $terms, true)) {
                        $terms[] = $exact_match_post;
                        $post_not_in[] = $exact_match_post->ID;
                        $query->found_posts++;
                    }

                }

                $query->set('post__not_in', array_merge((array) $query->get('post__not_in'), $post_not_in));
            }
        }

        $query->terms = $terms;

    }
}
add_action( 'pre_get_posts', 'modify_search_query_for_pagination' );





function insert_fake_posts( $posts, $query ) {
    if ( ! is_admin() && $query->is_search() && $query->is_main_query() ) {
        $search_term = $query->query_vars['s'];
        $terms = isset( $query->terms ) ? $query->terms : array();



        $fake_posts = array();

        foreach ( $terms as $term ) {
            if ( $term && !$term instanceof WP_Post) {
                $term_post = new stdClass();
                $term_post->ID =  $term->term_id;
                $term_post->post_title = $term->name;
                $term_post->post_content = '';
                $term_post->post_type = 'taxonomy_term';
                $term_post->post_status = 'publish';
                $term_post->guid = get_term_link( $term );
                $term_post->post_excerpt = $term->description;
                $term_post->post_name = $term->taxonomy;
                $term_post->filter = 'raw';

                $fake_posts[] = $term_post;
            }

            if($term && $term instanceof WP_Post){
                array_unshift( $fake_posts, $term );
            }
        }


        $posts_per_page = $query->get( 'posts_per_page' );
        if(!$posts_per_page) {
            $posts_per_page = get_option( 'posts_per_page' );
        }
        $paged = max( 1, $query->get( 'paged' ) );
        $start = ( $paged - 1 ) * $posts_per_page;


        $fake_posts_for_page = array_slice( $fake_posts, $start, $posts_per_page );

        $remaining_posts_count = $posts_per_page - count( $fake_posts_for_page );
        $real_posts_for_page = array_slice( $posts, 0, $remaining_posts_count );

        return array_merge( $fake_posts_for_page, $real_posts_for_page );

    }

    return $posts;
}
add_filter( 'the_posts', 'insert_fake_posts', 10, 2 );



function adjust_found_posts_for_fake( $found_posts, $query ) {
    if ( ! is_admin() && $query->is_search() && $query->is_main_query() ) {
        $fake_post_count = isset( $query->term_count ) ? $query->term_count : 0;
        return $found_posts + $fake_post_count;
    }

    return $found_posts;
}
add_filter( 'found_posts', 'adjust_found_posts_for_fake', 10, 2 );




add_filter( 'wp_robots', function ( $robots ) {
    if ( isset( $robots['nofollow'] ) ) {
       unset( $robots['nofollow'] );
    }

    if ( isset( $robots['follow'] ) ) {
       unset( $robots['follow'] );
    }

    return $robots;
}, 99999 );



add_filter('the_content', function ($content) {
    global $post;

    if (!is_single()) return $content;

    // Определяем категорию
    $is_podcast = has_category('podcast', $post);
    $is_article = has_category('article', $post);

    if (!$is_podcast && !$is_article) return $content;

    // UTM для категории
    $utm = $is_podcast
        ? 'utm_source=wholistic_matters&utm_medium=referral&utm_campaign=wholisticmatters_podcast_article'
        : 'utm_source=wholistic_matters&utm_medium=referral&utm_campaign=wholisticmatters_article';

    // Меняем ссылки в контенте
    $content = preg_replace_callback(
        '#https://www\.standardprocess\.com(/[^\s"\']*)?#i',
        function ($matches) use ($utm) {
            $url = $matches[0];

            // Уже есть UTM — пропускаем
            if (strpos($url, 'utm_source') !== false) return $url;

            // Добавляем UTM
            $join = (strpos($url, '?') !== false) ? '&' : '?';
            return rtrim($url, '?&') . $join . $utm;
        },
        $content
    );

    return $content;
});


/**
 * Give core's image-lightbox buttons a crawler-visible accessible name.
 * Core sets it at runtime via the Interactivity API; this mirrors that
 * statically from the figure's <img> alt so static scans don't flag 4.1.2.
 */
function lightbox_label_lightbox_buttons( $content ) {
	if ( strpos( $content, 'lightbox-trigger' ) === false ) {
		return $content; // cheap bail — most content has none
	}

	$dom = new DOMDocument();
	libxml_use_internal_errors( true );
	$dom->loadHTML(
		'<?xml encoding="utf-8"?>' . $content,
		LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
	);
	libxml_clear_errors();

	$xpath   = new DOMXPath( $dom );
	$buttons = $xpath->query( "//button[contains(concat(' ', normalize-space(@class), ' '), ' lightbox-trigger ')]" );

	foreach ( $buttons as $button ) {
		if ( $button->hasAttribute( 'aria-label' ) ) {
			continue;
		}
		$figure = $xpath->query( 'ancestor::figure[1]', $button )->item( 0 );
		$alt    = '';

		if ( $figure ) {
			$img = $xpath->query( './/img[@alt]', $figure )->item( 0 );
			if ( $img ) {
				$alt = trim( $img->getAttribute( 'alt' ) );
			}
		}
		$label = '' !== $alt
			? sprintf( esc_attr__( 'Enlarge image: %s', 'red-egg' ), $alt )
			: esc_attr__( 'Enlarge image', 'red-egg' );
		$button->setAttribute( 'aria-label', $label );
	}

	$html = $dom->saveHTML();
	return preg_replace( '/^<\?xml.*?\?>\s*/', '', $html ); // drop the encoding prolog
}
add_filter( 'the_content', 'lightbox_label_lightbox_buttons', 20 );


/**
 * Give generic-text core/button links a descriptive accessible name.
 *
 * Context source, in priority order:
 *   1. Editor-supplied "Link destination" field (accessibleLabel attribute).
 *   2. Resolved title of a local post / page / media item.
 *   3. The external domain — no network call — with a new-tab note if relevant.
 * If none yield usable context, the button is left untouched rather than
 * labelled with a slug or tracking string.
 *
 * Visible text is always kept at the front of the label so WCAG 2.5.3
 * (Label in Name) holds.
 */
function screen_reader_prevent_generic_buttons( $block_content, $block ) {
	$p = new WP_HTML_Tag_Processor( $block_content );
	if ( ! $p->next_tag( 'a' ) || $p->get_attribute( 'aria-label' ) ) {
		return $block_content; // no link, or already named
	}

	$visible = trim( wp_strip_all_tags( $block_content ) );

	// 1. Editor-supplied destination always wins.
	$context = isset( $block['attrs']['accessibleLabel'] )
		? trim( $block['attrs']['accessibleLabel'] )
		: '';

	if ( '' === $context ) {
		// Only auto-name buttons whose visible text is non-descriptive.
		$generic = array( 'learn more', 'read more', 'click here', 'view more', 'download', 'download pdf', 'more', 'go' );
		if ( ! in_array( strtolower( $visible ), $generic, true ) ) {
			return $block_content; // already descriptive — leave it
		}

		$url = $p->get_attribute( 'href' );

		// 2. Resolve a local post / page / media title.
		if ( $url ) {
			$pid = url_to_postid( $url ) ?: attachment_url_to_postid( $url );
			if ( $pid ) {
				$context = get_the_title( $pid );
			}
		}

		// 3. External link → use the domain (no network call).
		if ( '' === $context && $url ) {
			$host = wp_parse_url( $url, PHP_URL_HOST );
			$home = wp_parse_url( home_url(), PHP_URL_HOST );
			if ( $host && $host !== $home ) {
				$context = preg_replace( '/^www\./', '', $host );
				if ( '_blank' === $p->get_attribute( 'target' ) ) {
					$context .= ' (opens in new tab)';
				}
			}
		}

		// Nothing reliable → leave the button alone.
		if ( '' === $context ) {
			return $block_content;
		}
	}

	$p->set_attribute( 'aria-label', $visible . ': ' . $context );
	return $p->get_updated_html();
}
add_filter( 'render_block_core/button', 'screen_reader_prevent_generic_buttons', 10, 2 );

