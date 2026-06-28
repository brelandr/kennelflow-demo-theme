<?php
/**
 * Homepage hero section.
 *
 * @package KennelFlow_Demo_Theme
 */

defined( 'ABSPATH' ) || exit;

$heading  = kennelflow_demo_get_mod( 'kennelflow_demo_hero_heading', __( 'Your pet\'s campus for boarding, clinic care, and grooming.', 'kennelflow-demo-theme' ) );
$tagline  = kennelflow_demo_get_mod( 'kennelflow_demo_tagline', __( 'Modern care for every tail and whisker.', 'kennelflow-demo-theme' ) );
$book_url = kennelflow_demo_has_vet_booking_shortcode()
	? kennelflow_demo_get_page_url( 'book-appointment' )
	: kennelflow_demo_get_page_url( 'book-boarding' );
$portal   = kennelflow_demo_get_page_url( 'my-pets' );

$hero_image_id = absint( get_theme_mod( 'kennelflow_demo_hero_image', 0 ) );
$hero_style    = '';
if ( $hero_image_id ) {
	$url = wp_get_attachment_image_url( $hero_image_id, 'kennelflow_demo_hero' );
	if ( $url ) {
		$hero_style = ' style="background-image: linear-gradient(120deg, rgba(30, 58, 95, 0.88) 0%, rgba(13, 148, 136, 0.75) 100%), url(' . esc_url( $url ) . '); background-size: cover; background-position: center;"';
	}
}
?>
<section class="kf-hero">
	<div class="kf-hero__bg"<?php echo $hero_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built from esc_url above. ?> aria-hidden="true"></div>
	<div class="kf-container kf-hero__content">
		<p class="kf-hero__eyebrow"><?php echo esc_html( $tagline ); ?></p>
		<h1 class="kf-hero__title"><?php echo esc_html( $heading ); ?></h1>
		<p class="kf-hero__lead"><?php esc_html_e( 'Boarding suites, veterinary exams, and spa grooming — with online booking and a secure owner portal.', 'kennelflow-demo-theme' ); ?></p>
		<div class="kf-hero__actions">
			<?php if ( kennelflow_demo_has_vet_booking_shortcode() || kennelflow_demo_has_boarding_booking_shortcode() ) : ?>
				<a class="kf-btn kf-btn--primary" href="<?php echo esc_url( $book_url ); ?>"><?php esc_html_e( 'Book Online', 'kennelflow-demo-theme' ); ?></a>
			<?php endif; ?>
			<a class="kf-btn kf-btn--outline kf-btn--on-dark" href="<?php echo esc_url( $portal ); ?>"><?php esc_html_e( 'Owner Portal', 'kennelflow-demo-theme' ); ?></a>
		</div>
		<div class="kf-hero__stats">
			<div class="kf-hero__stat">
				<strong>24/7</strong>
				<span><?php esc_html_e( 'On-site care team', 'kennelflow-demo-theme' ); ?></span>
			</div>
			<div class="kf-hero__stat">
				<strong>3</strong>
				<span><?php esc_html_e( 'Services under one roof', 'kennelflow-demo-theme' ); ?></span>
			</div>
			<div class="kf-hero__stat">
				<strong>100%</strong>
				<span><?php esc_html_e( 'Digital owner updates', 'kennelflow-demo-theme' ); ?></span>
			</div>
		</div>
	</div>
</section>
