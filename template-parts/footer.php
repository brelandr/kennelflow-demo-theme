<?php
/**
 * Footer template.
 *
 * @package KennelFlow_Demo_Theme
 */

defined( 'ABSPATH' ) || exit;

$phone   = kennelflow_demo_get_mod( 'kennelflow_demo_phone', '(555) 014-PAWS' );
$address = kennelflow_demo_get_mod( 'kennelflow_demo_address', '1200 Harbor Lane, Bayview, CA 94016' );
$pwa_url = home_url( '/kennelflow-mobile/' );
?>
	<footer class="kf-footer" role="contentinfo">
		<div class="kf-container kf-footer__grid">
			<div>
				<div class="kf-footer__brand"><?php bloginfo( 'name' ); ?></div>
				<p class="kf-footer__tagline"><?php echo esc_html( get_bloginfo( 'description' ) ); ?></p>
				<p><?php echo esc_html( $address ); ?></p>
				<p><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></p>
			</div>
			<div>
				<h3><?php esc_html_e( 'Explore', 'kennelflow-demo-theme' ); ?></h3>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'menu_class'     => 'kf-footer-nav',
						'container'      => false,
						'fallback_cb'    => 'kennelflow_demo_footer_menu_fallback',
						'depth'          => 1,
					)
				);
				?>
			</div>
			<div>
				<h3><?php esc_html_e( 'Staff Tools', 'kennelflow-demo-theme' ); ?></h3>
				<ul class="kf-footer-nav">
					<li><a href="<?php echo esc_url( kennelflow_demo_get_page_url( 'staff-calendar' ) ); ?>"><?php esc_html_e( 'Staff Calendar', 'kennelflow-demo-theme' ); ?></a></li>
					<?php if ( kennelflow_demo_is_boarding_active() ) : ?>
						<li><a href="<?php echo esc_url( $pwa_url ); ?>"><?php esc_html_e( 'Mobile Report Card', 'kennelflow-demo-theme' ); ?></a></li>
					<?php endif; ?>
					<li><a href="<?php echo esc_url( admin_url() ); ?>"><?php esc_html_e( 'WordPress Admin', 'kennelflow-demo-theme' ); ?></a></li>
				</ul>
			</div>
		</div>
		<div class="kf-footer__demo">
			<div class="kf-container">
				<?php if ( class_exists( 'KennelFlow_Data_Demo_Personas' ) && KennelFlow_Data_Demo_Personas::is_sandbox_enabled() ) : ?>
					<?php esc_html_e( 'KennelFlow sandbox — use the role switcher at the top of the page to explore as Pet owner, Boarding desk, Veterinarian, Groomer, or Site admin without logging out.', 'kennelflow-demo-theme' ); ?>
				<?php else : ?>
					<?php esc_html_e( 'Demo site', 'kennelflow-demo-theme' ); ?> —
					<?php esc_html_e( 'Pet owner login:', 'kennelflow-demo-theme' ); ?>
					<code>demoowner</code> / <code>password</code>
					<?php esc_html_e( '· Admin:', 'kennelflow-demo-theme' ); ?>
					<code>admin</code> / <code>password</code>
				<?php endif; ?>
			</div>
		</div>
		<div class="kf-footer__bottom">
			<div class="kf-container">
				&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?> · <?php esc_html_e( 'Powered by KennelFlow', 'kennelflow-demo-theme' ); ?>
			</div>
		</div>
	</footer>
</div><!-- .kf-site -->

<?php wp_footer(); ?>
</body>
</html>
