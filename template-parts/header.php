<?php
/**
 * Header template.
 *
 * @package KennelFlow_Demo_Theme
 */

defined( 'ABSPATH' ) || exit;

$portal_url = kennelflow_demo_get_page_url( 'my-pets' );
$book_url   = kennelflow_demo_has_vet_booking_shortcode()
	? kennelflow_demo_get_page_url( 'book-appointment' )
	: ( kennelflow_demo_has_boarding_booking_shortcode() ? kennelflow_demo_get_page_url( 'book-boarding' ) : $portal_url );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="kf-skip-link" href="#primary"><?php esc_html_e( 'Skip to content', 'kennelflow-demo-theme' ); ?></a>

<div class="kf-site">
	<?php get_template_part( 'template-parts/demo', 'banner' ); ?>

	<header class="kf-header" role="banner">
		<div class="kf-container kf-header__inner">
			<?php if ( has_custom_logo() ) : ?>
				<div class="kf-brand kf-brand--logo">
					<?php the_custom_logo(); ?>
				</div>
			<?php else : ?>
				<a class="kf-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<span class="kf-brand__mark" aria-hidden="true">&#128062;</span>
					<span class="kf-brand__text">
						<?php bloginfo( 'name' ); ?>
						<span><?php echo esc_html( kennelflow_demo_get_mod( 'kennelflow_demo_tagline', __( 'Pet Campus', 'kennelflow-demo-theme' ) ) ); ?></span>
					</span>
				</a>
			<?php endif; ?>

			<nav class="kf-nav" aria-label="<?php esc_attr_e( 'Primary', 'kennelflow-demo-theme' ); ?>">
				<button type="button" class="kf-nav__toggle" aria-expanded="false" aria-controls="primary-menu-panel">
					<?php esc_html_e( 'Menu', 'kennelflow-demo-theme' ); ?>
				</button>
				<div class="kf-nav__panel" id="primary-menu-panel">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'menu_id'        => 'primary-menu',
							'menu_class'     => 'kf-nav__list',
							'container'      => false,
							'fallback_cb'    => 'kennelflow_demo_primary_menu_fallback',
						)
					);
					?>
				</div>
			</nav>

			<div class="kf-header__actions">
				<?php if ( is_user_logged_in() ) : ?>
					<span class="kf-btn kf-btn--ghost"><?php echo esc_html( wp_get_current_user()->display_name ); ?></span>
					<a class="kf-btn kf-btn--outline" href="<?php echo esc_url( wp_logout_url( home_url( '/' ) ) ); ?>"><?php esc_html_e( 'Log out', 'kennelflow-demo-theme' ); ?></a>
				<?php else : ?>
					<a class="kf-btn kf-btn--ghost" href="<?php echo esc_url( wp_login_url( $portal_url ) ); ?>"><?php esc_html_e( 'Log in', 'kennelflow-demo-theme' ); ?></a>
				<?php endif; ?>
				<a class="kf-btn kf-btn--primary" href="<?php echo esc_url( $portal_url ); ?>"><?php esc_html_e( 'My Pets', 'kennelflow-demo-theme' ); ?></a>
			</div>
		</div>
	</header>
