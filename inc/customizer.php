<?php
/**
 * Theme Customizer settings.
 *
 * @package KennelFlow_Demo_Theme
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register Customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 * @return void
 */
function kennelflow_demo_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'kennelflow_demo_branding',
		array(
			'title'    => __( 'Harbor Pet Campus', 'kennelflow-demo-theme' ),
			'priority' => 30,
		)
	);

	$fields = array(
		'kennelflow_demo_tagline' => array(
			'label'   => __( 'Hero tagline', 'kennelflow-demo-theme' ),
			'default' => __( 'Modern care for every tail and whisker.', 'kennelflow-demo-theme' ),
			'type'    => 'text',
		),
		'kennelflow_demo_hero_heading' => array(
			'label'   => __( 'Hero heading', 'kennelflow-demo-theme' ),
			'default' => __( 'Your pet\'s campus for boarding, clinic care, and grooming.', 'kennelflow-demo-theme' ),
			'type'    => 'textarea',
		),
		'kennelflow_demo_phone' => array(
			'label'   => __( 'Phone number', 'kennelflow-demo-theme' ),
			'default' => '(555) 014-PAWS',
			'type'    => 'text',
		),
		'kennelflow_demo_address' => array(
			'label'   => __( 'Address', 'kennelflow-demo-theme' ),
			'default' => '1200 Harbor Lane, Bayview, CA 94016',
			'type'    => 'text',
		),
		'kennelflow_demo_hours' => array(
			'label'   => __( 'Business hours', 'kennelflow-demo-theme' ),
			'default' => 'Mon–Sat 7:00 AM – 7:00 PM · Sun 8:00 AM – 4:00 PM',
			'type'    => 'text',
		),
		'kennelflow_demo_primary_color' => array(
			'label'   => __( 'Primary color', 'kennelflow-demo-theme' ),
			'default' => '#0D9488',
			'type'    => 'color',
		),
		'kennelflow_demo_accent_color' => array(
			'label'   => __( 'Accent color', 'kennelflow-demo-theme' ),
			'default' => '#1E3A5F',
			'type'    => 'color',
		),
	);

	foreach ( $fields as $id => $field ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => $field['default'],
				'sanitize_callback' => 'color' === $field['type']
					? 'sanitize_hex_color'
					: ( 'textarea' === $field['type'] ? 'sanitize_textarea_field' : 'sanitize_text_field' ),
				'transport'         => 'refresh',
			)
		);

		if ( 'color' === $field['type'] ) {
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					$id,
					array(
						'label'   => $field['label'],
						'section' => 'kennelflow_demo_branding',
					)
				)
			);
		} elseif ( 'textarea' === $field['type'] ) {
			$wp_customize->add_control(
				$id,
				array(
					'label'   => $field['label'],
					'section' => 'kennelflow_demo_branding',
					'type'    => 'textarea',
				)
			);
		} else {
			$wp_customize->add_control(
				$id,
				array(
					'label'   => $field['label'],
					'section' => 'kennelflow_demo_branding',
					'type'    => 'text',
				)
			);
		}
	}

	$wp_customize->add_setting(
		'kennelflow_demo_hero_image',
		array(
			'default'           => '',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'kennelflow_demo_hero_image',
			array(
				'label'     => __( 'Hero background image', 'kennelflow-demo-theme' ),
				'section'   => 'kennelflow_demo_branding',
				'mime_type' => 'image',
			)
		)
	);
}
add_action( 'customize_register', 'kennelflow_demo_customize_register' );

/**
 * Get a theme mod with default fallback.
 *
 * @param string $key     Setting key.
 * @param string $default Default value.
 * @return string
 */
function kennelflow_demo_get_mod( $key, $default = '' ) {
	$value = get_theme_mod( $key, $default );
	return is_string( $value ) ? $value : $default;
}
