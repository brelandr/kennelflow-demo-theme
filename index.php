<?php
/**
 * Fallback index template.
 *
 * @package KennelFlow_Demo_Theme
 */

get_header();
?>

<main id="primary" class="kf-main">
	<div class="kf-container">
		<?php if ( have_posts() ) : ?>
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article <?php post_class(); ?>>
					<header class="kf-page-header">
						<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
					</header>
					<div class="kf-content-prose">
						<?php the_excerpt(); ?>
					</div>
				</article>
				<?php
			endwhile;
			?>
		<?php else : ?>
			<p><?php esc_html_e( 'No content found.', 'kennelflow-demo-theme' ); ?></p>
		<?php endif; ?>
	</div>
</main>

<?php
get_footer();
