<?php
/**
 * WooCommerce theme integration.
 *
 * @package KennelFlow_Demo_Theme
 */

defined( 'ABSPATH' ) || exit;

/**
 * Declare WooCommerce support.
 *
 * @return void
 */
function kennelflow_demo_woocommerce_setup() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 400,
			'single_image_width'    => 600,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'max_rows'        => 6,
				'default_columns' => 3,
				'min_columns'     => 1,
				'max_columns'     => 4,
			),
		)
	);

	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'kennelflow_demo_woocommerce_setup' );

/**
 * Remove default WooCommerce wrappers — theme provides layout.
 *
 * @return void
 */
function kennelflow_demo_woocommerce_wrappers() {
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

	add_action( 'woocommerce_before_main_content', 'kennelflow_demo_wc_wrapper_start', 10 );
	add_action( 'woocommerce_after_main_content', 'kennelflow_demo_wc_wrapper_end', 10 );
}
add_action( 'wp', 'kennelflow_demo_woocommerce_wrappers' );

/**
 * WooCommerce content wrapper start.
 *
 * @return void
 */
function kennelflow_demo_wc_wrapper_start() {
	echo '<main id="primary" class="kf-main kf-main--shop"><div class="kf-container kf-wc-wrap">';
}

/**
 * WooCommerce content wrapper end.
 *
 * @return void
 */
function kennelflow_demo_wc_wrapper_end() {
	echo '</div></main>';
}
