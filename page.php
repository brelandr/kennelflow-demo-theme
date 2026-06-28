<?php
/**
 * Default page template.
 *
 * @package KennelFlow_Demo_Theme
 */

get_header();
?>

<main id="primary" class="kf-main">
	<div class="kf-container">
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<header class="kf-page-header">
				<h1><?php the_title(); ?></h1>
			</header>
			<div class="kf-content-prose">
				<?php the_content(); ?>
			</div>
			<?php
		endwhile;
		?>
	</div>
</main>

<?php
get_footer();
