<?php
/**
 * 404 template.
 *
 * @package KennelFlow_Demo_Theme
 */

get_header();
?>

<main id="primary" class="kf-main">
	<div class="kf-container">
		<header class="kf-page-header">
			<h1><?php esc_html_e( 'Page not found', 'kennelflow-demo-theme' ); ?></h1>
			<p><?php esc_html_e( 'We couldn\'t find that page. Try the links below or return home.', 'kennelflow-demo-theme' ); ?></p>
		</header>
		<p>
			<a class="kf-btn kf-btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to home', 'kennelflow-demo-theme' ); ?></a>
			<a class="kf-btn kf-btn--outline" href="<?php echo esc_url( kennelflow_demo_get_page_url( 'my-pets' ) ); ?>"><?php esc_html_e( 'My Pets', 'kennelflow-demo-theme' ); ?></a>
		</p>
	</div>
</main>

<?php
get_footer();
