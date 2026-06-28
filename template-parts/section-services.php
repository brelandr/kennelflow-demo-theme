<?php
/**
 * Services section for homepage.
 *
 * @package KennelFlow_Demo_Theme
 */

defined( 'ABSPATH' ) || exit;

$book_board = kennelflow_demo_get_page_url( 'book-boarding' );
$book_vet   = kennelflow_demo_get_page_url( 'book-appointment' );
$services   = kennelflow_demo_get_page_url( 'services' );
?>
<section class="kf-section" id="services">
	<div class="kf-container">
		<header class="kf-section__header">
			<p class="kf-section__eyebrow"><?php esc_html_e( 'What we offer', 'kennelflow-demo-theme' ); ?></p>
			<h2 class="kf-section__title"><?php esc_html_e( 'Complete care on one campus', 'kennelflow-demo-theme' ); ?></h2>
			<p class="kf-section__lead"><?php esc_html_e( 'From overnight boarding to wellness exams and breed-specific grooming — coordinated through KennelFlow.', 'kennelflow-demo-theme' ); ?></p>
		</header>

		<div class="kf-services-grid">
			<?php if ( kennelflow_demo_is_boarding_active() ) : ?>
				<article class="kf-service-card">
					<div class="kf-service-card__icon" aria-hidden="true">&#127968;</div>
					<h3><?php esc_html_e( 'Boarding & Daycare', 'kennelflow-demo-theme' ); ?></h3>
					<p><?php esc_html_e( 'Spacious suites, daily report cards, and flexible drop-off windows. Owners book and pay through the portal.', 'kennelflow-demo-theme' ); ?></p>
					<?php if ( kennelflow_demo_has_boarding_booking_shortcode() ) : ?>
						<a class="kf-btn kf-btn--outline" href="<?php echo esc_url( $book_board ); ?>"><?php esc_html_e( 'Book boarding', 'kennelflow-demo-theme' ); ?></a>
					<?php else : ?>
						<a class="kf-btn kf-btn--outline" href="<?php echo esc_url( $book_vet ); ?>"><?php esc_html_e( 'Book a stay', 'kennelflow-demo-theme' ); ?></a>
					<?php endif; ?>
				</article>
			<?php endif; ?>

			<?php if ( kennelflow_demo_is_vet_active() ) : ?>
				<article class="kf-service-card">
					<div class="kf-service-card__icon" aria-hidden="true">&#129657;</div>
					<h3><?php esc_html_e( 'Veterinary Clinic', 'kennelflow-demo-theme' ); ?></h3>
					<p><?php esc_html_e( 'Wellness visits, vaccinations, and sick appointments with records synced to your owner portal.', 'kennelflow-demo-theme' ); ?></p>
					<a class="kf-btn kf-btn--outline" href="<?php echo esc_url( $book_vet ); ?>"><?php esc_html_e( 'Book appointment', 'kennelflow-demo-theme' ); ?></a>
				</article>
			<?php endif; ?>

			<article class="kf-service-card">
				<div class="kf-service-card__icon" aria-hidden="true">&#9986;</div>
				<h3><?php esc_html_e( 'Professional Grooming', 'kennelflow-demo-theme' ); ?></h3>
				<p><?php esc_html_e( 'Full-service grooming scheduled by our team. Add a spa day to any boarding stay or call the front desk.', 'kennelflow-demo-theme' ); ?></p>
				<a class="kf-btn kf-btn--outline" href="<?php echo esc_url( $services ); ?>"><?php esc_html_e( 'Learn more', 'kennelflow-demo-theme' ); ?></a>
			</article>
		</div>
	</div>
</section>

<section class="kf-section kf-section--alt">
	<div class="kf-container">
		<header class="kf-section__header">
			<p class="kf-section__eyebrow"><?php esc_html_e( 'Happy families', 'kennelflow-demo-theme' ); ?></p>
			<h2 class="kf-section__title"><?php esc_html_e( 'Trusted by pet parents', 'kennelflow-demo-theme' ); ?></h2>
		</header>
		<div class="kf-testimonials">
			<figure class="kf-testimonial">
				<blockquote><?php esc_html_e( 'The daily report cards and photos while we travel are incredible. Bailey always comes home happy.', 'kennelflow-demo-theme' ); ?></blockquote>
				<cite><?php esc_html_e( '— Sarah M., Golden Retriever parent', 'kennelflow-demo-theme' ); ?></cite>
			</figure>
			<figure class="kf-testimonial">
				<blockquote><?php esc_html_e( 'Having vet records and boarding in one portal saves so much time. Max\'s vaccinations are always up to date.', 'kennelflow-demo-theme' ); ?></blockquote>
				<cite><?php esc_html_e( '— Demo Owner, Labrador parent', 'kennelflow-demo-theme' ); ?></cite>
			</figure>
			<figure class="kf-testimonial">
				<blockquote><?php esc_html_e( 'The staff calendar and grooming schedule keep our whole team aligned. KennelFlow just works.', 'kennelflow-demo-theme' ); ?></blockquote>
				<cite><?php esc_html_e( '— Campus Manager', 'kennelflow-demo-theme' ); ?></cite>
			</figure>
		</div>
	</div>
</section>
