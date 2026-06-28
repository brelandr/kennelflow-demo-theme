<?php
/**
 * Template Name: Owner Portal
 * Template Post Type: page
 *
 * Pet owner dashboard shortcode wrapper.
 *
 * @package KennelFlow_Demo_Theme
 */

get_header();
?>

<main id="primary" class="kf-main kf-main--portal">
	<div class="kf-container">
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<header class="kf-page-header">
				<h1><?php the_title(); ?></h1>
			</header>
			<?php if ( ! is_user_logged_in() ) : ?>
				<div class="kf-portal-banner">
					<?php
					echo wp_kses(
						sprintf(
							/* translators: 1: username code, 2: password code, 3: login link opening tag, 4: closing tag */
							__( 'Demo pet owner: log in as %1$s / %2$s — %3$sLog in%4$s', 'kennelflow-demo-theme' ),
							'<code>demoowner</code>',
							'<code>password</code>',
							'<a href="' . esc_url( wp_login_url( get_permalink() ) ) . '">',
							'</a>'
						),
						array(
							'code' => array(),
							'a'    => array( 'href' => array() ),
						)
					);
					?>
				</div>
			<?php endif; ?>
			<div class="kf-app-shell">
				<?php the_content(); ?>
			</div>
			<?php
		endwhile;
		?>
	</div>
</main>

<?php
get_footer();
