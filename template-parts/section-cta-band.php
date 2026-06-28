<?php
/**
 * CTA band for homepage.
 *
 * @package KennelFlow_Demo_Theme
 */

defined( 'ABSPATH' ) || exit;

$portal = kennelflow_demo_get_page_url( 'my-pets' );
$book   = kennelflow_demo_has_vet_booking_shortcode()
	? kennelflow_demo_get_page_url( 'book-appointment' )
	: kennelflow_demo_get_page_url( 'book-boarding' );
?>
<section class="kf-cta-band">
	<div class="kf-container kf-cta-band__inner">
		<div>
			<h2><?php esc_html_e( 'Ready to give your pet the Harbor experience?', 'kennelflow-demo-theme' ); ?></h2>
			<p><?php esc_html_e( 'Create an account, upload compliance documents, and manage everything from your phone.', 'kennelflow-demo-theme' ); ?></p>
		</div>
		<div class="kf-hero__actions">
			<?php if ( kennelflow_demo_has_vet_booking_shortcode() || kennelflow_demo_has_boarding_booking_shortcode() ) : ?>
				<a class="kf-btn kf-btn--primary" href="<?php echo esc_url( $book ); ?>"><?php esc_html_e( 'Book now', 'kennelflow-demo-theme' ); ?></a>
			<?php endif; ?>
			<a class="kf-btn kf-btn--inverse" href="<?php echo esc_url( $portal ); ?>"><?php esc_html_e( 'My Pets portal', 'kennelflow-demo-theme' ); ?></a>
		</div>
	</div>
</section>
