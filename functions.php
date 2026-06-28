<?php
/**
 * KennelFlow Campus Demo theme bootstrap.
 *
 * @package KennelFlow_Demo_Theme
 */

defined( 'ABSPATH' ) || exit;

define( 'KENNELFLOW_DEMO_THEME_VERSION', '1.0.5' );
define( 'KENNELFLOW_DEMO_THEME_DIR', get_template_directory() );
define( 'KENNELFLOW_DEMO_THEME_URI', get_template_directory_uri() );

require_once KENNELFLOW_DEMO_THEME_DIR . '/inc/plugin-detect.php';
require_once KENNELFLOW_DEMO_THEME_DIR . '/inc/nav-menus.php';
require_once KENNELFLOW_DEMO_THEME_DIR . '/inc/customizer.php';
require_once KENNELFLOW_DEMO_THEME_DIR . '/inc/demo-setup.php';
require_once KENNELFLOW_DEMO_THEME_DIR . '/inc/woocommerce.php';

/**
 * Theme setup.
 *
 * @return void
 */
function kennelflow_demo_theme_setup() {
	load_theme_textdomain( 'kennelflow-demo-theme', KENNELFLOW_DEMO_THEME_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 80,
			'width'       => 280,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );

	add_image_size( 'kennelflow_demo_hero', 1920, 900, true );
	add_image_size( 'kennelflow_demo_card', 640, 480, true );
}
add_action( 'after_setup_theme', 'kennelflow_demo_theme_setup' );

/**
 * Enqueue front-end assets.
 *
 * @return void
 */
function kennelflow_demo_theme_asset_version( $relative_path ) {
	$path = KENNELFLOW_DEMO_THEME_DIR . '/' . ltrim( $relative_path, '/' );
	if ( is_readable( $path ) ) {
		return (string) filemtime( $path );
	}
	return KENNELFLOW_DEMO_THEME_VERSION;
}

/**
 * Enqueue front-end assets.
 *
 * @return void
 */
function kennelflow_demo_theme_enqueue_assets() {
	$theme_css_ver = kennelflow_demo_theme_asset_version( 'assets/css/theme.css' );

	wp_enqueue_style(
		'kennelflow-demo-fonts',
		KENNELFLOW_DEMO_THEME_URI . '/assets/css/fonts.css',
		array(),
		kennelflow_demo_theme_asset_version( 'assets/css/fonts.css' )
	);

	wp_enqueue_style(
		'kennelflow-demo-theme',
		KENNELFLOW_DEMO_THEME_URI . '/assets/css/theme.css',
		array( 'kennelflow-demo-fonts' ),
		$theme_css_ver
	);

	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_style(
			'kennelflow-demo-woocommerce',
			KENNELFLOW_DEMO_THEME_URI . '/assets/css/woocommerce.css',
			array( 'kennelflow-demo-theme' ),
			KENNELFLOW_DEMO_THEME_VERSION
		);
	}

	wp_enqueue_script(
		'kennelflow-demo-navigation',
		KENNELFLOW_DEMO_THEME_URI . '/assets/js/navigation.js',
		array(),
		KENNELFLOW_DEMO_THEME_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'kennelflow_demo_theme_enqueue_assets' );

/**
 * Body classes for layout variants.
 *
 * @param array $classes Body classes.
 * @return array
 */
function kennelflow_demo_theme_body_classes( $classes ) {
	$classes[] = 'kf-campus';

	if ( is_page_template( 'page-templates/full-width-app.php' ) ) {
		$classes[] = 'kf-campus--app';
	}

	if ( is_page_template( 'page-templates/portal.php' ) ) {
		$classes[] = 'kf-campus--portal';
	}

	return $classes;
}
add_filter( 'body_class', 'kennelflow_demo_theme_body_classes' );

/**
 * Customizer CSS variables.
 *
 * @return void
 */
function kennelflow_demo_theme_customizer_css() {
	$primary = sanitize_hex_color( get_theme_mod( 'kennelflow_demo_primary_color', '#0D9488' ) );
	$accent  = sanitize_hex_color( get_theme_mod( 'kennelflow_demo_accent_color', '#1E3A5F' ) );

	if ( ! $primary ) {
		$primary = '#0D9488';
	}
	if ( ! $accent ) {
		$accent = '#1E3A5F';
	}

	$css = sprintf(
		':root { --kf-primary: %1$s; --kf-accent: %2$s; }',
		$primary,
		$accent
	);

	wp_add_inline_style( 'kennelflow-demo-theme', $css );
}
add_action( 'wp_enqueue_scripts', 'kennelflow_demo_theme_customizer_css', 20 );

/**
 * Enqueue high-contrast hero/CTA button overrides last (after WooCommerce/block CSS).
 *
 * @return void
 */
function kennelflow_demo_theme_enqueue_button_overrides() {
	wp_register_style( 'kennelflow-demo-buttons', false, array(), KENNELFLOW_DEMO_THEME_VERSION );
	wp_enqueue_style( 'kennelflow-demo-buttons' );
	wp_add_inline_style( 'kennelflow-demo-buttons', kennelflow_demo_theme_dark_button_css() );
}
add_action( 'wp_enqueue_scripts', 'kennelflow_demo_theme_enqueue_button_overrides', 999 );

/**
 * High-contrast button styles for dark sections (hero, CTA band).
 *
 * Loaded inline so sandbox caches pick up the fix when the theme is redeployed.
 *
 * @return string
 */
function kennelflow_demo_theme_dark_button_css() {
	return '
		body.kf-campus .kf-hero a.kf-btn.kf-btn--inverse,
		body.kf-campus .kf-cta-band a.kf-btn.kf-btn--inverse,
		body.kf-campus .kf-hero a.kf-btn.kf-btn--on-dark,
		body.kf-campus .kf-hero .kf-btn--outline,
		body.kf-campus .kf-cta-band .kf-btn--outline {
			background-color: #ffffff !important;
			background-image: none !important;
			color: #1e3a5f !important;
			border: 2px solid #ffffff !important;
			box-shadow: 0 4px 18px rgba(15, 23, 42, 0.28) !important;
		}
		body.kf-campus .kf-hero a.kf-btn.kf-btn--inverse:hover,
		body.kf-campus .kf-hero a.kf-btn.kf-btn--inverse:focus,
		body.kf-campus .kf-cta-band a.kf-btn.kf-btn--inverse:hover,
		body.kf-campus .kf-cta-band a.kf-btn.kf-btn--inverse:focus,
		body.kf-campus .kf-hero a.kf-btn.kf-btn--on-dark:hover,
		body.kf-campus .kf-hero .kf-btn--outline:hover,
		body.kf-campus .kf-cta-band .kf-btn--outline:hover {
			background-color: #f1f5f9 !important;
			color: #1e3a5f !important;
			border-color: #f1f5f9 !important;
		}
		body.kf-campus .kf-hero .kf-btn--primary,
		body.kf-campus .kf-cta-band .kf-btn--primary {
			box-shadow: 0 4px 18px rgba(0, 0, 0, 0.28) !important;
			border: 2px solid rgba(255, 255, 255, 0.35) !important;
		}
	';
}

/**
 * Dismiss demo admin banner.
 *
 * @return void
 */
function kennelflow_demo_dismiss_banner() {
	if ( ! is_user_logged_in() || ! current_user_can( 'manage_options' ) ) {
		wp_safe_redirect( home_url( '/' ) );
		exit;
	}
	if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'kennelflow_demo_dismiss_banner' ) ) {
		wp_die( esc_html__( 'Invalid security token.', 'kennelflow-demo-theme' ) );
	}
	update_user_meta( get_current_user_id(), 'kennelflow_demo_banner_dismissed', '1' );
	wp_safe_redirect( wp_get_referer() ? wp_get_referer() : home_url( '/' ) );
	exit;
}
add_action( 'admin_post_kennelflow_demo_dismiss_banner', 'kennelflow_demo_dismiss_banner' );

/**
 * Get dismiss URL for demo banner.
 *
 * @return string
 */
function kennelflow_demo_get_dismiss_banner_url() {
	return wp_nonce_url(
		admin_url( 'admin-post.php?action=kennelflow_demo_dismiss_banner' ),
		'kennelflow_demo_dismiss_banner'
	);
}

/**
 * Get a demo page URL by slug (from setup option map).
 *
 * @param string $slug Page slug key.
 * @return string
 */
function kennelflow_demo_get_page_url( $slug ) {
	$map = get_option( 'kennelflow_demo_page_ids', array() );
	if ( ! empty( $map[ $slug ] ) ) {
		$url = get_permalink( (int) $map[ $slug ] );
		if ( $url ) {
			return $url;
		}
	}
	return home_url( '/' . $slug . '/' );
}
