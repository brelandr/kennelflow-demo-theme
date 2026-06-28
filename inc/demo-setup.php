<?php
/**
 * One-click demo page, menu, and user setup.
 *
 * @package KennelFlow_Demo_Theme
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class KennelFlow_Demo_Setup
 */
class KennelFlow_Demo_Setup {

	const OPTION_VERSION = 'kennelflow_demo_setup_version';

	const OPTION_PAGE_IDS = 'kennelflow_demo_page_ids';

	const SETUP_VERSION = '1.0.3';

	/**
	 * Boot hooks.
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'after_switch_theme', array( __CLASS__, 'maybe_run_setup' ) );
		add_action( 'init', array( __CLASS__, 'maybe_fix_site_identity' ), 20 );
		add_action( 'admin_menu', array( __CLASS__, 'register_admin_page' ) );
		add_action( 'admin_post_kennelflow_demo_run_setup', array( __CLASS__, 'handle_manual_setup' ) );
		add_action( 'admin_notices', array( __CLASS__, 'admin_notices' ) );
	}

	/**
	 * Run setup on theme activation if not current version.
	 *
	 * @return void
	 */
	public static function maybe_run_setup() {
		if ( self::SETUP_VERSION === get_option( self::OPTION_VERSION, '' ) ) {
			return;
		}
		self::run_setup();
	}

	/**
 * Register Appearance submenu for re-running setup.
	 *
	 * @return void
	 */
	public static function register_admin_page() {
		add_theme_page(
			__( 'KennelFlow Demo Setup', 'kennelflow-demo-theme' ),
			__( 'Demo Setup', 'kennelflow-demo-theme' ),
			'manage_options',
			'kennelflow-demo-setup',
			array( __CLASS__, 'render_admin_page' )
		);
	}

	/**
	 * Admin setup page.
	 *
	 * @return void
	 */
	public static function render_admin_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		$ran = get_option( self::OPTION_VERSION, '' );
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'KennelFlow Demo Setup', 'kennelflow-demo-theme' ); ?></h1>
			<p><?php esc_html_e( 'Creates demo pages, navigation menus, and the demo pet owner account. Safe to re-run — existing pages are updated, not duplicated.', 'kennelflow-demo-theme' ); ?></p>
			<?php if ( $ran ) : ?>
				<p><strong><?php esc_html_e( 'Last setup version:', 'kennelflow-demo-theme' ); ?></strong> <?php echo esc_html( $ran ); ?></p>
			<?php endif; ?>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<?php wp_nonce_field( 'kennelflow_demo_run_setup', 'kennelflow_demo_setup_nonce' ); ?>
				<input type="hidden" name="action" value="kennelflow_demo_run_setup" />
				<?php submit_button( __( 'Run Demo Setup', 'kennelflow-demo-theme' ), 'primary', 'submit', false ); ?>
			</form>
			<hr />
			<h2><?php esc_html_e( 'Next: Sample Data', 'kennelflow-demo-theme' ); ?></h2>
			<p><?php esc_html_e( 'After setup, open KennelFlow → Sample Data (KennelFlow-Data plugin) and click Generate sample data to populate calendars, pets, and bookings.', 'kennelflow-demo-theme' ); ?></p>
			<?php if ( menu_page_url( 'kennelflow-data', false ) ) : ?>
				<p><a class="button button-secondary" href="<?php echo esc_url( menu_page_url( 'kennelflow-data', false ) ); ?>"><?php esc_html_e( 'Open Sample Data', 'kennelflow-demo-theme' ); ?></a></p>
			<?php endif; ?>
		</div>
		<?php
	}

	/**
	 * Handle manual setup form.
	 *
	 * @return void
	 */
	public static function handle_manual_setup() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Unauthorized.', 'kennelflow-demo-theme' ) );
		}
		if ( ! isset( $_POST['kennelflow_demo_setup_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['kennelflow_demo_setup_nonce'] ) ), 'kennelflow_demo_run_setup' ) ) {
			wp_die( esc_html__( 'Invalid security token.', 'kennelflow-demo-theme' ) );
		}

		self::run_setup();

		wp_safe_redirect(
			add_query_arg(
				array(
					'page'              => 'kennelflow-demo-setup',
					'kennelflow_setup'  => '1',
				),
				admin_url( 'themes.php' )
			)
		);
		exit;
	}

	/**
	 * Admin notices after setup.
	 *
	 * @return void
	 */
	public static function admin_notices() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		if ( isset( $_GET['kennelflow_setup'] ) && '1' === sanitize_text_field( wp_unslash( $_GET['kennelflow_setup'] ) ) ) {
			echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'KennelFlow demo setup completed.', 'kennelflow-demo-theme' ) . '</p></div>';
		}

		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
		if ( self::SETUP_VERSION !== get_option( self::OPTION_VERSION, '' ) && $screen && 'themes.php' === $screen->id ) {
			echo '<div class="notice notice-info"><p>';
			printf(
				/* translators: %s: link to demo setup page */
				esc_html__( 'KennelFlow Campus Demo: %s to create pages and menus.', 'kennelflow-demo-theme' ),
				'<a href="' . esc_url( admin_url( 'themes.php?page=kennelflow-demo-setup' ) ) . '">' . esc_html__( 'Run Demo Setup', 'kennelflow-demo-theme' ) . '</a>'
			);
			echo '</p></div>';
		}
	}

	/**
	 * Main setup routine.
	 *
	 * @return void
	 */
	public static function run_setup() {
		if ( ! current_user_can( 'manage_options' ) && ! doing_action( 'after_switch_theme' ) ) {
			return;
		}

		$page_ids = get_option( self::OPTION_PAGE_IDS, array() );
		if ( ! is_array( $page_ids ) ) {
			$page_ids = array();
		}

		$definitions = self::get_page_definitions();

		foreach ( $definitions as $key => $def ) {
			if ( ! empty( $def['condition'] ) && is_callable( $def['condition'] ) && ! call_user_func( $def['condition'] ) ) {
				continue;
			}

			$page_ids[ $key ] = self::upsert_page(
				$key,
				$def['title'],
				$def['content'],
				isset( $page_ids[ $key ] ) ? (int) $page_ids[ $key ] : 0,
				isset( $def['template'] ) ? $def['template'] : ''
			);
		}

		update_option( self::OPTION_PAGE_IDS, $page_ids );

		if ( ! empty( $page_ids['home'] ) ) {
			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', (int) $page_ids['home'] );
		}

		self::ensure_demo_owner();
		self::ensure_site_identity();
		self::ensure_woocommerce_pages();
		self::build_menus( $page_ids );

		update_option( self::OPTION_VERSION, self::SETUP_VERSION );
	}

	/**
	 * Page definitions for demo content.
	 *
	 * @return array<string, array<string, mixed>>
	 */
	protected static function get_page_definitions() {
		$services_content = self::get_services_page_content();
		$about_content    = self::get_about_page_content();
		$contact_content  = self::get_contact_page_content();

		$pages = array(
			'home' => array(
				'title'   => __( 'Home', 'kennelflow-demo-theme' ),
				'content' => '<!-- kennelflow-demo-home -->',
			),
			'my-pets' => array(
				'title'    => __( 'My Pets', 'kennelflow-demo-theme' ),
				'content'  => '[ltkf_dashboard]',
				'template' => 'page-templates/portal.php',
			),
			'services' => array(
				'title'   => __( 'Our Services', 'kennelflow-demo-theme' ),
				'content' => $services_content,
			),
			'about' => array(
				'title'   => __( 'About Us', 'kennelflow-demo-theme' ),
				'content' => $about_content,
			),
			'contact' => array(
				'title'   => __( 'Contact', 'kennelflow-demo-theme' ),
				'content' => $contact_content,
			),
			'staff-calendar' => array(
				'title'    => __( 'Staff Calendar', 'kennelflow-demo-theme' ),
				'content'  => '[ltkf_hub_calendar]',
				'template' => 'page-templates/staff-calendar.php',
			),
		);

		if ( kennelflow_demo_has_vet_booking_shortcode() ) {
			$pages['book-appointment'] = array(
				'title'    => __( 'Book Appointment', 'kennelflow-demo-theme' ),
				'content'  => '[kennelflow_vet_booking]',
				'template' => 'page-templates/full-width-app.php',
			);
		}

		$boarding_shortcode = kennelflow_demo_get_boarding_booking_shortcode();
		if ( '' !== $boarding_shortcode ) {
			$pages['book-boarding'] = array(
				'title'    => __( 'Book Boarding', 'kennelflow-demo-theme' ),
				'content'  => $boarding_shortcode,
				'template' => 'page-templates/full-width-app.php',
			);
		}

		return $pages;
	}

	/**
	 * Create or update a page.
	 *
	 * @param string $slug    Page slug.
	 * @param string $title   Page title.
	 * @param string $content Page content.
	 * @param int    $existing_id Existing page ID.
	 * @param string $template Page template path.
	 * @return int
	 */
	protected static function upsert_page( $slug, $title, $content, $existing_id = 0, $template = '' ) {
		$postarr = array(
			'post_title'   => $title,
			'post_content' => $content,
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_name'    => $slug,
		);

		if ( $existing_id > 0 && get_post( $existing_id ) ) {
			$postarr['ID'] = $existing_id;
			$page_id       = wp_update_post( $postarr, true );
		} else {
			$found = get_page_by_path( $slug, OBJECT, 'page' );
			if ( $found ) {
				$postarr['ID'] = (int) $found->ID;
				$page_id       = wp_update_post( $postarr, true );
			} else {
				$page_id = wp_insert_post( $postarr, true );
			}
		}

		if ( is_wp_error( $page_id ) ) {
			return 0;
		}

		$page_id = (int) $page_id;

		if ( '' !== $template ) {
			update_post_meta( $page_id, '_wp_page_template', $template );
		}

		return $page_id;
	}

	/**
	 * Ensure demo pet owner exists.
	 *
	 * @return void
	 */
	protected static function ensure_demo_owner() {
		$demo_pass = 'password';
		if ( class_exists( 'KennelFlow_Data_Demo_Personas' ) ) {
			$demo_pass = KennelFlow_Data_Demo_Personas::get_demo_password();
		}

		$user_id = username_exists( 'demoowner' );
		if ( ! $user_id ) {
			$user_id = wp_insert_user(
				array(
					'user_login'   => 'demoowner',
					'user_pass'    => $demo_pass,
					'user_email'   => 'owner@kennelflow.demo',
					'role'         => 'subscriber',
					'display_name' => 'Demo Owner',
				)
			);
		}

		if ( is_wp_error( $user_id ) || ! $user_id ) {
			return;
		}

		$user = get_user_by( 'id', (int) $user_id );
		if ( $user && kennelflow_demo_is_core_active() && in_array( 'pet_owner', (array) $user->roles, true ) === false ) {
			$user->add_role( 'pet_owner' );
		}
	}

	/**
	 * Repair site title/tagline on existing demo installs (e.g. InstaWP hostname as title).
	 *
	 * @return void
	 */
	public static function maybe_fix_site_identity() {
		self::ensure_site_identity();
	}

	/**
	 * Whether the current site title should be replaced with the demo default.
	 *
	 * InstaWP and similar sandboxes often set blogname to the site hostname.
	 *
	 * @param string $name Current blogname option.
	 * @return bool
	 */
	protected static function should_reset_demo_site_title( $name ) {
		$name = is_string( $name ) ? trim( $name ) : '';

		$legacy_names = array( '', 'WordPress', 'Harbor Pet Campus' );
		if ( in_array( $name, $legacy_names, true ) ) {
			return true;
		}

		$host = wp_parse_url( home_url(), PHP_URL_HOST );
		if ( is_string( $host ) && '' !== $host && $host === $name ) {
			return true;
		}

		/**
		 * Allow hosts to opt out or extend hostname detection.
		 *
		 * @param bool   $should_reset Whether to reset the site title.
		 * @param string $name         Current blogname.
		 */
		return (bool) apply_filters( 'kennelflow_demo_should_reset_site_title', false, $name );
	}

	/**
	 * Set default site name and tagline for demo.
	 *
	 * @return void
	 */
	protected static function ensure_site_identity() {
		$name = get_option( 'blogname', '' );
		if ( self::should_reset_demo_site_title( $name ) ) {
			update_option( 'blogname', 'Kennel Flow' );
		}

		$desc = get_option( 'blogdescription', '' );
		if ( '' === $desc ) {
			update_option( 'blogdescription', __( 'Boarding · Veterinary · Grooming', 'kennelflow-demo-theme' ) );
		}
	}

	/**
	 * Create WooCommerce pages if needed.
	 *
	 * @return void
	 */
	protected static function ensure_woocommerce_pages() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			return;
		}
		if ( function_exists( 'wc_create_pages' ) ) {
			wc_create_pages();
		}
	}

	/**
	 * Build primary and footer menus.
	 *
	 * @param array<string, int> $page_ids Page ID map.
	 * @return void
	 */
	protected static function build_menus( $page_ids ) {
		$primary_id = self::upsert_menu( 'KennelFlow Primary', 'primary' );
		$footer_id  = self::upsert_menu( 'KennelFlow Footer', 'footer' );

		if ( ! $primary_id || ! $footer_id ) {
			return;
		}

		self::clear_menu_items( $primary_id );
		self::clear_menu_items( $footer_id );

		$order = 1;

		if ( ! empty( $page_ids['home'] ) ) {
			self::add_page_to_menu( $primary_id, (int) $page_ids['home'], $order++ );
		}
		if ( ! empty( $page_ids['services'] ) ) {
			self::add_page_to_menu( $primary_id, (int) $page_ids['services'], $order++ );
		}
		if ( ! empty( $page_ids['book-appointment'] ) ) {
			self::add_page_to_menu( $primary_id, (int) $page_ids['book-appointment'], $order++ );
		}
		if ( ! empty( $page_ids['book-boarding'] ) ) {
			self::add_page_to_menu( $primary_id, (int) $page_ids['book-boarding'], $order++ );
		}
		if ( ! empty( $page_ids['my-pets'] ) ) {
			self::add_page_to_menu( $primary_id, (int) $page_ids['my-pets'], $order++ );
		}
		if ( class_exists( 'WooCommerce' ) ) {
			$shop_id = wc_get_page_id( 'shop' );
			if ( $shop_id > 0 ) {
				self::add_page_to_menu( $primary_id, $shop_id, $order++ );
			}
		}
		if ( ! empty( $page_ids['contact'] ) ) {
			self::add_page_to_menu( $primary_id, (int) $page_ids['contact'], $order++ );
		}

		$footer_order = 1;
		if ( ! empty( $page_ids['about'] ) ) {
			self::add_page_to_menu( $footer_id, (int) $page_ids['about'], $footer_order++ );
		}
		if ( ! empty( $page_ids['contact'] ) ) {
			self::add_page_to_menu( $footer_id, (int) $page_ids['contact'], $footer_order++ );
		}
		if ( ! empty( $page_ids['staff-calendar'] ) ) {
			self::add_page_to_menu( $footer_id, (int) $page_ids['staff-calendar'], $footer_order++ );
		}
		if ( class_exists( 'WooCommerce' ) ) {
			$account_id = wc_get_page_id( 'myaccount' );
			if ( $account_id > 0 ) {
				self::add_page_to_menu( $footer_id, $account_id, $footer_order++ );
			}
		}
	}

	/**
	 * Create or locate a nav menu and assign to location.
	 *
	 * @param string $name     Menu name.
	 * @param string $location Theme location.
	 * @return int Menu term ID.
	 */
	protected static function upsert_menu( $name, $location ) {
		$menu = wp_get_nav_menu_object( $name );
		if ( $menu ) {
			$menu_id = (int) $menu->term_id;
		} else {
			$menu_id = wp_create_nav_menu( $name );
			if ( is_wp_error( $menu_id ) ) {
				return 0;
			}
		}

		$locations           = get_theme_mod( 'nav_menu_locations', array() );
		$locations[ $location ] = (int) $menu_id;
		set_theme_mod( 'nav_menu_locations', $locations );

		return (int) $menu_id;
	}

	/**
	 * Remove all items from a menu.
	 *
	 * @param int $menu_id Menu term ID.
	 * @return void
	 */
	protected static function clear_menu_items( $menu_id ) {
		$items = wp_get_nav_menu_items( $menu_id );
		if ( ! is_array( $items ) ) {
			return;
		}
		foreach ( $items as $item ) {
			wp_delete_post( (int) $item->ID, true );
		}
	}

	/**
	 * Add a page to a nav menu.
	 *
	 * @param int $menu_id Menu ID.
	 * @param int $page_id Page ID.
	 * @param int $order   Menu order.
	 * @return void
	 */
	protected static function add_page_to_menu( $menu_id, $page_id, $order ) {
		wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'     => get_the_title( $page_id ),
				'menu-item-object'    => 'page',
				'menu-item-object-id' => $page_id,
				'menu-item-type'      => 'post_type',
				'menu-item-status'    => 'publish',
				'menu-item-position'  => $order,
			)
		);
	}

	/**
	 * Services page default content.
	 *
	 * @return string
	 */
	protected static function get_services_page_content() {
		$boarding = kennelflow_demo_is_boarding_active();
		$vet      = kennelflow_demo_is_vet_active();
		$groom    = kennelflow_demo_is_groom_active();

		ob_start();
		?>
		<div class="kf-content-prose">
			<p><?php esc_html_e( 'Harbor Pet Campus is a full-service facility for dogs and cats — boarding, veterinary care, and professional grooming under one roof.', 'kennelflow-demo-theme' ); ?></p>
			<?php if ( $boarding ) : ?>
				<h2><?php esc_html_e( 'Boarding & Daycare', 'kennelflow-demo-theme' ); ?></h2>
				<p><?php esc_html_e( 'Climate-controlled suites, daily report cards, and flexible check-in windows. Book a stay online or through your owner portal.', 'kennelflow-demo-theme' ); ?></p>
			<?php endif; ?>
			<?php if ( $vet ) : ?>
				<h2><?php esc_html_e( 'Veterinary Clinic', 'kennelflow-demo-theme' ); ?></h2>
				<p><?php esc_html_e( 'Wellness exams, vaccinations, and sick visits with integrated medical records visible in your pet owner portal.', 'kennelflow-demo-theme' ); ?></p>
			<?php endif; ?>
			<?php if ( $groom ) : ?>
				<h2><?php esc_html_e( 'Professional Grooming', 'kennelflow-demo-theme' ); ?></h2>
				<p><?php esc_html_e( 'Grooming appointments are scheduled by our team through the KennelFlow calendar. Ask at check-in or call the front desk to add a spa day to your pet\'s stay.', 'kennelflow-demo-theme' ); ?></p>
			<?php endif; ?>
		</div>
		<?php
		return (string) ob_get_clean();
	}

	/**
	 * About page default content.
	 *
	 * @return string
	 */
	protected static function get_about_page_content() {
		ob_start();
		?>
		<div class="kf-content-prose">
			<p><?php esc_html_e( 'Founded in 2018, Harbor Pet Campus combines modern veterinary medicine with resort-style boarding and attentive grooming — all powered by KennelFlow for seamless scheduling and owner communication.', 'kennelflow-demo-theme' ); ?></p>
			<h2><?php esc_html_e( 'Our Mission', 'kennelflow-demo-theme' ); ?></h2>
			<p><?php esc_html_e( 'Every pet deserves care that feels personal, transparent, and safe. We use digital report cards, online booking, and a secure owner portal so you stay connected wherever you are.', 'kennelflow-demo-theme' ); ?></p>
			<h2><?php esc_html_e( 'The Team', 'kennelflow-demo-theme' ); ?></h2>
			<p><?php esc_html_e( 'Licensed veterinarians, certified groomers, and experienced kennel staff work together on one campus — with shared pet records through KennelFlow Core.', 'kennelflow-demo-theme' ); ?></p>
		</div>
		<?php
		return (string) ob_get_clean();
	}

	/**
	 * Contact page default content.
	 *
	 * @return string
	 */
	protected static function get_contact_page_content() {
		$phone   = get_theme_mod( 'kennelflow_demo_phone', '(555) 014-PAWS' );
		$address = get_theme_mod( 'kennelflow_demo_address', '1200 Harbor Lane, Bayview, CA 94016' );
		$hours   = get_theme_mod( 'kennelflow_demo_hours', 'Mon–Sat 7:00 AM – 7:00 PM · Sun 8:00 AM – 4:00 PM' );

		ob_start();
		?>
		<div class="kf-content-prose kf-contact-grid">
			<div>
				<h2><?php esc_html_e( 'Visit Us', 'kennelflow-demo-theme' ); ?></h2>
				<p><?php echo esc_html( $address ); ?></p>
				<p><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></p>
			</div>
			<div>
				<h2><?php esc_html_e( 'Hours', 'kennelflow-demo-theme' ); ?></h2>
				<p><?php echo esc_html( $hours ); ?></p>
			</div>
			<div>
				<h2><?php esc_html_e( 'Owner Portal', 'kennelflow-demo-theme' ); ?></h2>
				<p><?php esc_html_e( 'Manage bookings, medical records, and payments online.', 'kennelflow-demo-theme' ); ?></p>
				<p><a class="kf-btn kf-btn--primary" href="<?php echo esc_url( kennelflow_demo_get_page_url( 'my-pets' ) ); ?>"><?php esc_html_e( 'Go to My Pets', 'kennelflow-demo-theme' ); ?></a></p>
			</div>
		</div>
		<?php
		return (string) ob_get_clean();
	}
}

KennelFlow_Demo_Setup::init();
