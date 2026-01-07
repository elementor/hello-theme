<?php
/**
 * Theme functions and definitions
 *
 * @package Hello420
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Theme constants
 */
define( 'HELLO420_VERSION', '2.2.1-dev' );
define( 'HELLO420_THEME_SLUG', 'hello420' );
define( 'HELLO420_TEXT_DOMAIN', 'hello420' );

define( 'HELLO420_THEME_PATH', get_template_directory() );
define( 'HELLO420_THEME_URL', get_template_directory_uri() );
define( 'HELLO420_ASSETS_PATH', HELLO420_THEME_PATH . '/assets/' );
define( 'HELLO420_ASSETS_URL', HELLO420_THEME_URL . '/assets/' );
define( 'HELLO420_SCRIPTS_PATH', HELLO420_ASSETS_PATH . 'js/' );
define( 'HELLO420_SCRIPTS_URL', HELLO420_ASSETS_URL . 'js/' );
define( 'HELLO420_STYLE_PATH', HELLO420_ASSETS_PATH . 'css/' );
define( 'HELLO420_STYLE_URL', HELLO420_ASSETS_URL . 'css/' );
define( 'HELLO420_IMAGES_PATH', HELLO420_ASSETS_PATH . 'images/' );
define( 'HELLO420_IMAGES_URL', HELLO420_ASSETS_URL . 'images/' );

/**
 * Internal error log file for Hello 420.
 *
 * This helps debugging "Critical Error" screens when server logs are not easily accessible.
 */
if ( ! defined( 'HELLO420_ERROR_LOG' ) ) {
	$hello420_wp_content_dir = defined( 'WP_CONTENT_DIR' ) ? WP_CONTENT_DIR : ( rtrim( ABSPATH, '/\\' ) . '/wp-content' );
	define( 'HELLO420_ERROR_LOG', rtrim( $hello420_wp_content_dir, '/\\' ) . '/hello420-error.log' );
}

/**
 * Write a safe, minimal error entry for diagnostics without breaking the site.
 */
function hello420_log_error( \Throwable $error, string $context = 'runtime' ): void {
	$time = gmdate( 'c' );
	$line = sprintf(
		"[%s] [%s] %s in %s:%d\n",
		$time,
		$context,
		$error->getMessage(),
		$error->getFile(),
		$error->getLine()
	);

	// Best-effort write: file + PHP error_log fallback.
	try {
		@file_put_contents( HELLO420_ERROR_LOG, $line . $error->getTraceAsString() . "\n\n", FILE_APPEND );
	} catch ( \Throwable $e ) {
		// ignore
	}

	@error_log( 'Hello 420 error (' . $context . '): ' . $error->getMessage() . ' in ' . $error->getFile() . ':' . $error->getLine() );
}

if ( ! isset( $content_width ) ) {
	$content_width = 800; // Pixels.
}

/**
 * Enforce PHP 8.2+ on theme activation.
 */
function hello420_enforce_php_requirement(): void {
	if ( version_compare( PHP_VERSION, '8.2', '>=' ) ) {
		return;
	}

	// Attempt to switch back to a default theme.
	$default = WP_DEFAULT_THEME ?? 'twentytwentyfour';
	switch_theme( $default );

	unset( $_GET['activated'] );

	add_action( 'admin_notices', static function () {
		echo '<div class="notice notice-error"><p>' . esc_html__( 'Hello 420 requires PHP 8.2 or newer. The theme has been deactivated.', 'hello420' ) . '</p></div>';
	} );
}
add_action( 'after_switch_theme', 'hello420_enforce_php_requirement' );

/**
 * Basic Elementor requirement notice (theme remains activatable).
 */
function hello420_elementor_required_notice(): void {
	if ( ! current_user_can( 'activate_plugins' ) ) {
		return;
	}

	if ( defined( 'ELEMENTOR_VERSION' ) ) {
		return;
	}

	// Only show in admin.
	if ( ! is_admin() ) {
		return;
	}

	echo '<div class="notice notice-warning"><p>' . esc_html__( 'Hello 420 is optimized for Elementor and requires the Elementor plugin to unlock its full functionality.', 'hello420' ) . '</p></div>';
}
add_action( 'admin_notices', 'hello420_elementor_required_notice' );

/**
 * Set up theme support.
 */
function hello420_setup(): void {
	hello420_maybe_update_theme_version_in_db();

	load_theme_textdomain( HELLO420_TEXT_DOMAIN, HELLO420_THEME_PATH . '/languages' );

	if ( apply_filters( 'hello420_register_menus', true ) ) {
		register_nav_menus( [ 'menu-1' => esc_html__( 'Header', 'hello420' ) ] );
		register_nav_menus( [ 'menu-2' => esc_html__( 'Footer', 'hello420' ) ] );
	}

	if ( apply_filters( 'hello420_post_type_support', true ) ) {
		add_post_type_support( 'page', 'excerpt' );
	}

	if ( apply_filters( 'hello420_add_theme_support', true ) ) {
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support(
			'html5',
			[
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'script',
				'style',
				'navigation-widgets',
			]
		);
		add_theme_support(
			'custom-logo',
			[
				'height'      => 100,
				'width'       => 350,
				'flex-height' => true,
				'flex-width'  => true,
			]
		);
		add_theme_support( 'align-wide' );
		add_theme_support( 'responsive-embeds' );

		// Editor Styles.
		add_theme_support( 'editor-styles' );
		add_editor_style( 'assets/css/editor-styles.css' );

		// WooCommerce.
		if ( apply_filters( 'hello420_add_woocommerce_support', true ) ) {
			add_theme_support( 'woocommerce' );
			add_theme_support( 'wc-product-gallery-zoom' );
			add_theme_support( 'wc-product-gallery-lightbox' );
			add_theme_support( 'wc-product-gallery-slider' );
		}
	}
}
add_action( 'after_setup_theme', 'hello420_setup' );

function hello420_maybe_update_theme_version_in_db(): void {
	$option_name = 'hello420_theme_version';
	$db_version  = get_option( $option_name );

	if ( HELLO420_VERSION !== $db_version ) {
		update_option( $option_name, HELLO420_VERSION );
	}
}

/**
 * Check whether to display header/footer.
 */
function hello420_display_header_footer(): bool {
	return (bool) apply_filters( 'hello420_header_footer', true );
}

/**
 * Theme scripts & styles.
 */
function hello420_scripts_styles(): void {
	if ( apply_filters( 'hello420_enqueue_style', true ) ) {
		wp_enqueue_style(
			'hello420-reset',
			HELLO420_STYLE_URL . 'reset.css',
			[],
			HELLO420_VERSION
		);
	}

	if ( apply_filters( 'hello420_enqueue_theme_style', true ) ) {
		wp_enqueue_style(
			'hello420-theme-style',
			HELLO420_STYLE_URL . 'theme.css',
			[],
			HELLO420_VERSION
		);
	}

	if ( hello420_display_header_footer() ) {
		wp_enqueue_style(
			'hello420-header-footer',
			HELLO420_STYLE_URL . 'header-footer.css',
			[],
			HELLO420_VERSION
		);
	}
}
add_action( 'wp_enqueue_scripts', 'hello420_scripts_styles' );

/**
 * Register Elementor locations (Pro).
 */
function hello420_register_elementor_locations( $elementor_theme_manager ): void {
	if ( apply_filters( 'hello420_register_elementor_locations', true ) ) {
		$elementor_theme_manager->register_all_core_location();
	}
}
add_action( 'elementor/theme/register_locations', 'hello420_register_elementor_locations' );

/**
 * Set default content width.
 */
function hello420_content_width(): void {
	$GLOBALS['content_width'] = (int) apply_filters( 'hello420_content_width', 800 );
}
add_action( 'after_setup_theme', 'hello420_content_width', 0 );

/**
 * Add description meta tag with excerpt text.
 */
function hello420_add_description_meta_tag(): void {
	if ( ! apply_filters( 'hello420_description_meta_tag', true ) ) {
		return;
	}

	if ( ! is_singular() ) {
		return;
	}

	$post = get_queried_object();
	if ( empty( $post->post_excerpt ) ) {
		return;
	}

	echo '<meta name="description" content="' . esc_attr( wp_strip_all_tags( $post->post_excerpt ) ) . '">' . "\n";
}
add_action( 'wp_head', 'hello420_add_description_meta_tag' );

// Settings page.
require HELLO420_THEME_PATH . '/includes/settings-functions.php';

// Header & footer styling option, inside Elementor.
require HELLO420_THEME_PATH . '/includes/elementor-functions.php';

// Customizer controls (only when in Customizer preview).
add_action( 'init', static function () {
	if ( ! is_customize_preview() ) {
		return;
	}

	if ( ! hello420_display_header_footer() ) {
		return;
	}

	require HELLO420_THEME_PATH . '/includes/customizer-functions.php';
} );

/**
 * Check whether to display the page title.
 */
function hello420_check_hide_title( bool $val ): bool {
	if ( ! defined( 'ELEMENTOR_VERSION' ) || ! class_exists( '\Elementor\Plugin' ) ) {
		return $val;
	}

	try {
		$plugin = \Elementor\Plugin::$instance ?? null;
		if ( ! is_object( $plugin ) && method_exists( '\Elementor\Plugin', 'instance' ) ) {
			$plugin = \Elementor\Plugin::instance();
		}

		if ( ! is_object( $plugin ) || empty( $plugin->documents ) || ! method_exists( $plugin->documents, 'get' ) ) {
			return $val;
		}

		$current_doc = $plugin->documents->get( get_the_ID() );
		if ( $current_doc && method_exists( $current_doc, 'get_settings' ) && 'yes' === $current_doc->get_settings( 'hide_title' ) ) {
			$val = false;
		}
	} catch ( \Throwable $e ) {
		// Never break the front-end if Elementor APIs change.
	}

	return $val;
}
add_filter( 'hello420_page_title', 'hello420_check_hide_title' );

$hello420_theme_file = HELLO420_THEME_PATH . '/theme.php';
if ( file_exists( $hello420_theme_file ) ) {
	require $hello420_theme_file;
} else {
	hello420_log_error( new \RuntimeException( 'Missing required theme bootstrap file: ' . $hello420_theme_file ), 'boot' );
	return;
}

try {
	Hello420Theme\Theme::instance();
} catch ( \Throwable $e ) {
	hello420_log_error( $e, 'boot' );

	// Show a notice to admins (only in wp-admin).
	if ( is_admin() && current_user_can( 'manage_options' ) ) {
		add_action( 'admin_notices', static function () {
			echo '<div class="notice notice-error"><p>' .
				esc_html__( 'Hello 420 encountered an internal error during bootstrap. Check wp-content/hello420-error.log for details.', 'hello420' ) .
				'</p></div>';
		} );
	}
}