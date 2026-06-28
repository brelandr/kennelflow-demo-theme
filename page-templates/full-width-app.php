<?php
/**
 * Template Name: Full Width App
 * Template Post Type: page
 *
 * Shortcode pages — booking wizards.
 *
 * @package KennelFlow_Demo_Theme
 */

get_header();
?>

<main id="primary" class="kf-main kf-main--app">
	<div class="kf-container">
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<header class="kf-page-header">
				<h1><?php the_title(); ?></h1>
				<p><?php esc_html_e( 'Complete the steps below to schedule your visit.', 'kennelflow-demo-theme' ); ?></p>
			</header>
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
