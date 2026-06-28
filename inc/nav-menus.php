<?php
/**
 * Navigation menu registration and fallbacks.
 *
 * @package KennelFlow_Demo_Theme
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register nav menu locations.
 *
 * @return void
 */
function kennelflow_demo_register_nav_menus() {
	register_nav_menus(
		array(
			'primary' => __( 'Primary Header Menu', 'kennelflow-demo-theme' ),
			'footer'  => __( 'Footer Menu', 'kennelflow-demo-theme' ),
		)
	);
}
add_action( 'after_setup_theme', 'kennelflow_demo_register_nav_menus' );

/**
 * Fallback primary menu when none assigned.
 *
 * @return void
 */
function kennelflow_demo_primary_menu_fallback() {
	$items = array(
		array(
			'label' => __( 'Home', 'kennelflow-demo-theme' ),
			'url'   => home_url( '/' ),
		),
		array(
			'label' => __( 'Services', 'kennelflow-demo-theme' ),
			'url'   => kennelflow_demo_get_page_url( 'services' ),
		),
	);

	if ( kennelflow_demo_has_vet_booking_shortcode() ) {
		$items[] = array(
			'label' => __( 'Book Appointment', 'kennelflow-demo-theme' ),
			'url'   => kennelflow_demo_get_page_url( 'book-appointment' ),
		);
	}

	if ( kennelflow_demo_has_boarding_booking_shortcode() ) {
		$items[] = array(
			'label' => __( 'Book Boarding', 'kennelflow-demo-theme' ),
			'url'   => kennelflow_demo_get_page_url( 'book-boarding' ),
		);
	}

	$items[] = array(
		'label' => __( 'My Pets', 'kennelflow-demo-theme' ),
		'url'   => kennelflow_demo_get_page_url( 'my-pets' ),
	);

	if ( class_exists( 'WooCommerce' ) ) {
		$items[] = array(
			'label' => __( 'Shop', 'kennelflow-demo-theme' ),
			'url'   => wc_get_page_permalink( 'shop' ),
		);
	}

	$items[] = array(
		'label' => __( 'Contact', 'kennelflow-demo-theme' ),
		'url'   => kennelflow_demo_get_page_url( 'contact' ),
	);

	echo '<ul id="primary-menu" class="kf-nav__list">';
	foreach ( $items as $item ) {
		printf(
			'<li class="menu-item"><a href="%1$s">%2$s</a></li>',
			esc_url( $item['url'] ),
			esc_html( $item['label'] )
		);
	}
	echo '</ul>';
}

/**
 * Fallback footer menu.
 *
 * @return void
 */
function kennelflow_demo_footer_menu_fallback() {
	$items = array(
		array(
			'label' => __( 'About', 'kennelflow-demo-theme' ),
			'url'   => kennelflow_demo_get_page_url( 'about' ),
		),
		array(
			'label' => __( 'Contact', 'kennelflow-demo-theme' ),
			'url'   => kennelflow_demo_get_page_url( 'contact' ),
		),
		array(
			'label' => __( 'Staff Calendar', 'kennelflow-demo-theme' ),
			'url'   => kennelflow_demo_get_page_url( 'staff-calendar' ),
		),
	);

	if ( class_exists( 'WooCommerce' ) ) {
		$items[] = array(
			'label' => __( 'My Account', 'kennelflow-demo-theme' ),
			'url'   => wc_get_page_permalink( 'myaccount' ),
		);
	}

	echo '<ul id="footer-menu" class="kf-footer-nav">';
	foreach ( $items as $item ) {
		printf(
			'<li><a href="%1$s">%2$s</a></li>',
			esc_url( $item['url'] ),
			esc_html( $item['label'] )
		);
	}
	echo '</ul>';
}
