<?php
/**
 * Front page template — marketing homepage.
 *
 * @package KennelFlow_Demo_Theme
 */

get_header();
?>

<main id="primary">
	<?php get_template_part( 'template-parts/hero', 'home' ); ?>
	<?php get_template_part( 'template-parts/section', 'services' ); ?>
	<?php get_template_part( 'template-parts/section', 'cta-band' ); ?>
</main>

<?php
get_footer();
