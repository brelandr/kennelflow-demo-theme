<?php
/**
 * KennelFlow plugin detection helpers.
 *
 * @package KennelFlow_Demo_Theme
 */

defined( 'ABSPATH' ) || exit;

/**
 * Whether KennelFlow Core is active.
 *
 * @return bool
 */
function kennelflow_demo_is_core_active() {
	return function_exists( 'ltkf_is_core_active' ) && ltkf_is_core_active();
}

/**
 * Whether KennelFlow Vet is active.
 *
 * @return bool
 */
function kennelflow_demo_is_vet_active() {
	return defined( 'KENNELFLOW_VET_VERSION' ) || class_exists( 'KennelFlow_Vet_Plugin' );
}

/**
 * Whether KennelFlow Boarding is active.
 *
 * @return bool
 */
function kennelflow_demo_is_boarding_active() {
	return defined( 'KENNELFLOW_BOARDING_VERSION' ) || class_exists( 'KennelFlow_Boarding_Plugin' );
}

/**
 * Whether GroomPress / KennelFlow Groom is active.
 *
 * @return bool
 */
function kennelflow_demo_is_groom_active() {
	return defined( 'KENNELFLOW_GROOM_VERSION' ) || class_exists( 'KennelFlow_Groom_Plugin' );
}

/**
 * Whether a booking wizard shortcode is available for the Book Boarding page.
 *
 * @return bool
 */
function kennelflow_demo_has_boarding_booking_shortcode() {
	if ( kennelflow_demo_has_vet_booking_shortcode() ) {
		return true;
	}
	return shortcode_exists( 'ltkf_booking' );
}

/**
 * Shortcode for the Book Boarding page.
 *
 * When KennelFlow Vet is active it owns the boarding wizard (`kennelflow_vet_booking`
 * and legacy `[ltkf_booking]`). With Boarding/Core only, Core registers `[ltkf_booking]`.
 *
 * @return string Bracket-wrapped shortcode or empty string when none registered.
 */
function kennelflow_demo_get_boarding_booking_shortcode() {
	if ( kennelflow_demo_has_vet_booking_shortcode() ) {
		return '[kennelflow_vet_booking]';
	}
	if ( shortcode_exists( 'ltkf_booking' ) ) {
		return '[ltkf_booking]';
	}
	return '';
}

/**
 * Repair Book Boarding page when it still has an unregistered legacy shortcode.
 *
 * @return void
 */
function kennelflow_demo_maybe_repair_book_boarding_page() {
	$expected = kennelflow_demo_get_boarding_booking_shortcode();
	if ( '' === $expected ) {
		return;
	}

	$map = get_option( 'kennelflow_demo_page_ids', array() );
	if ( ! is_array( $map ) || empty( $map['book-boarding'] ) ) {
		return;
	}

	$page_id = absint( $map['book-boarding'] );
	$page    = get_post( $page_id );
	if ( ! $page instanceof WP_Post || 'page' !== $page->post_type ) {
		return;
	}

	$content = trim( (string) $page->post_content );
	if ( $content === $expected ) {
		return;
	}

	$legacy = array( '[ltkf_booking]', '[kfvet_booking]' );
	if ( ! in_array( $content, $legacy, true ) && ! str_contains( $content, '[ltkf_booking]' ) ) {
		return;
	}

	wp_update_post(
		array(
			'ID'           => $page_id,
			'post_content' => $expected,
		)
	);
}
add_action( 'init', 'kennelflow_demo_maybe_repair_book_boarding_page', 20 );

/**
 * Whether the vet booking shortcode is registered.
 *
 * @return bool
 */
function kennelflow_demo_has_vet_booking_shortcode() {
	return shortcode_exists( 'kennelflow_vet_booking' ) || shortcode_exists( 'kfvet_booking' );
}
