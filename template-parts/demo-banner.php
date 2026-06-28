<?php
/**
 * Dismissible demo banner for administrators.
 *
 * @package KennelFlow_Demo_Theme
 */

defined( 'ABSPATH' ) || exit;

if ( ! current_user_can( 'manage_options' ) ) {
	return;
}

if ( '1' === get_user_meta( get_current_user_id(), 'kennelflow_demo_banner_dismissed', true ) ) {
	return;
}

$sample_url = menu_page_url( 'kennelflow-data', false );
?>
<div class="kf-demo-banner" role="status">
	<?php esc_html_e( 'KennelFlow demo theme active.', 'kennelflow-demo-theme' ); ?>
	<?php if ( $sample_url ) : ?>
		<a href="<?php echo esc_url( $sample_url ); ?>"><?php esc_html_e( 'Generate sample data', 'kennelflow-demo-theme' ); ?></a>
	<?php else : ?>
		<?php esc_html_e( 'Activate KennelFlow-Data and run Sample Data to populate calendars.', 'kennelflow-demo-theme' ); ?>
	<?php endif; ?>
	<button type="button" class="kf-demo-banner__dismiss" data-dismiss-url="<?php echo esc_url( kennelflow_demo_get_dismiss_banner_url() ); ?>"><?php esc_html_e( 'Dismiss', 'kennelflow-demo-theme' ); ?></button>
</div>
