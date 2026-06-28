<?php
/**
 * Template Name: Staff Calendar
 * Template Post Type: page
 *
 * Hub calendar shortcode for staff.
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
				<p><?php esc_html_e( 'Staff only — sign in with an administrator or staff account to view the calendar.', 'kennelflow-demo-theme' ); ?></p>
			</header>
			<div class="kf-app-shell">
				<div class="kf-app-shell__hint">
					<?php esc_html_e( 'This embeds the KennelFlow Hub calendar. Demo admins can also use Pets → Calendar in wp-admin.', 'kennelflow-demo-theme' ); ?>
				</div>
				<?php the_content(); ?>
			</div>
			<?php
		endwhile;
		?>
	</div>
</main>

<?php
get_footer();
