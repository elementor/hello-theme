<?php
// WP Theme Customizer
if ( ! defined( 'ABSPATH' ) ) { exit; }

$text_domain = 'hello-theme-child';

add_action( 'customize_register', 'hello_theme_child_customize_register' );
function hello_theme_child_customize_register( $wp_customize ) {
	// General Panel
	$wp_customize->add_panel( 'htc_general_panel', array(
		'title' => __( 'General Settings' ),
		'priority' => 25,
	) );

	// Font Panel
	$wp_customize->add_panel( 'htc_font_panel', array(
		'title' => __( 'Font Settings' ),
		'priority' => 30,
	) );

	// Header hooks Panel
	$wp_customize->add_panel( 'htc_header_box_panel', array(
		'title' => __( 'Header Hooks' ),
		'priority' => 40,
	) );

	// Footer hooks Panel
	$wp_customize->add_panel( 'htc_footer_box_panel', array(
		'title' => __( 'Footer Hooks' ),
		'priority' => 40,
	) );

	// General Section
	$wp_customize->add_section( 'htc_gen_body_bg_section', array(
	    'title' => __( 'Body', $text_domain ),
	    'panel' => 'htc_general_panel'
	) );

	$wp_customize->add_section( 'htc_gen_page_header_section', array(
	    'title' => __( 'Page Header', $text_domain ),
	    'panel' => 'htc_general_panel'
	) );

	$wp_customize->add_section( 'htc_dashboard_cleanup_section', array(
	    'title' => __( 'Dashboard Settings', $text_domain ),
	    'panel' => 'htc_general_panel'
	) );

	$wp_customize->add_section( 'htc_comments_section', array(
	    'title' => __( 'Comments', $text_domain ),
	    'panel' => 'htc_general_panel'
	) );

	// Font Section
	$wp_customize->add_section( 'htc_font_h1_section', array(
	    'title' => __( 'H1', $text_domain ),
	    'priority' => 50,
	    'panel' => 'htc_font_panel'
	) );

	$wp_customize->add_section( 'htc_font_h2_section', array(
	    'title' => __( 'H2', $text_domain ),
	    'priority' => 50,
	    'panel' => 'htc_font_panel'
	) );

	$wp_customize->add_section( 'htc_font_h3_section', array(
	    'title' => __( 'H3', $text_domain ),
	    'priority' => 50,
	    'panel' => 'htc_font_panel'
	) );

	$wp_customize->add_section( 'htc_font_h4_section', array(
	    'title' => __( 'H4', $text_domain ),
	    'priority' => 50,
	    'panel' => 'htc_font_panel'
	) );

	$wp_customize->add_section( 'htc_font_h5_section', array(
	    'title' => __( 'H5', $text_domain ),
	    'priority' => 50,
	    'panel' => 'htc_font_panel'
	) );

	$wp_customize->add_section( 'htc_font_h6_section', array(
	    'title' => __( 'H6', $text_domain ),
	    'priority' => 50,
	    'panel' => 'htc_font_panel'
	) );

	$wp_customize->add_section( 'htc_font_ptag_section', array(
	    'title' => __( 'Paragraph', $text_domain ),
	    'priority' => 50,
	    'panel' => 'htc_font_panel'
	) );

	// Header hooks Section
	$wp_customize->add_section( 'htc_header_box_ga_section', array(
	    'title' => __( 'Google Analytics', $text_domain ),
	    'priority' => 10,
	    'panel' => 'htc_header_box_panel'
	) );

	$wp_customize->add_section( 'htc_header_box_wmt_section', array(
	    'title' => __( 'Webmaster Tools', $text_domain ),
	    'priority' => 10,
	    'panel' => 'htc_header_box_panel'
	) );

	$wp_customize->add_section( 'htc_header_box_extra_section', array(
	    'title' => __( 'Extra Code', $text_domain ),
	    'priority' => 10,
	    'panel' => 'htc_header_box_panel'
	) );

	// Footer hooks Section
	$wp_customize->add_section( 'htc_footer_box_fbp_section', array(
	    'title' => __( 'Facebook Pixel', $text_domain ),
	    'priority' => 10,
	    'panel' => 'htc_footer_box_panel'
	) );

	$wp_customize->add_section( 'htc_footer_box_extra_section', array(
	    'title' => __( 'Extra Code', $text_domain ),
	    'priority' => 10,
	    'panel' => 'htc_footer_box_panel'
	) );

	// Custom JS section
	$wp_customize->add_section( 'htc_custom_js_section', array(
	    'title' => __( 'Custom JS', $text_domain ),
	    'priority' => 999,
	) );

	// General settings
	$wp_customize->add_setting( 'htc_gen_setting_body_color', array(
	    'default' => '#FFFFFF'
	) );

	$wp_customize->add_setting( 'htc_gen_setting_body_img', array(
	    'default' => ''
	) );

	$wp_customize->add_setting( 'htc_gen_setting_body_bgrep', array(
	    'default' => 'no-repeat'
	) );

	$wp_customize->add_setting( 'htc_gen_setting_body_bgpos', array(
	    'default' => 'center top'
	) );

	$wp_customize->add_setting( 'htc_gen_setting_body_bgsize', array(
	    'default' => 'cover'
	) );

	$wp_customize->add_setting( 'htc_gen_setting_phead_enable', array(
	    'default' => 'yes'
	) );

	$wp_customize->add_setting( 'htc_gen_setting_phead_width', array(
	    'default' => '100%'
	) );

	$wp_customize->add_setting( 'htc_gen_setting_phead_pad', array(
	    'default' => '20px'
	) );

	$wp_customize->add_setting( 'htc_gen_setting_phead_color', array(
	    'default' => '#FFFFFF'
	) );

	$wp_customize->add_setting( 'htc_gen_setting_phead_img', array(
	    'default' => ''
	) );

	$wp_customize->add_setting( 'htc_gen_setting_phead_bgrep', array(
	    'default' => 'no-repeat'
	) );

	$wp_customize->add_setting( 'htc_gen_setting_phead_bgpos', array(
	    'default' => 'center top'
	) );

	$wp_customize->add_setting( 'htc_gen_setting_phead_bgsize', array(
	    'default' => 'cover'
	) );

	$wp_customize->add_setting( 'htc_dashboard_cleanup_setting', array(
	    'default' => 'yes',
	    'transport' => 'postMessage'
	) );

	$wp_customize->add_setting( 'htc_comments_setting', array(
	    'default' => 'yes',
	    'transport' => 'postMessage'
	) );

	// Font settings
	$wp_customize->add_setting( 'htc_font_setting_h1', array(
	    'default' => '40',
	) );

	$wp_customize->add_setting( 'htc_font_setting_h1_type', array(
	    'default' => 'px',
	) );

	$wp_customize->add_setting( 'htc_font_setting_h1_family', array(
	    'default' => 'default',
	) );

	$wp_customize->add_setting( 'htc_font_setting_h1_color', array(
	    'default' => '#000000',
	) );

	$wp_customize->add_setting( 'htc_font_setting_h2', array(
	    'default' => '32',
	) );

	$wp_customize->add_setting( 'htc_font_setting_h2_type', array(
	    'default' => 'px',
	) );

	$wp_customize->add_setting( 'htc_font_setting_h2_family', array(
	    'default' => 'default',
	) );

	$wp_customize->add_setting( 'htc_font_setting_h2_color', array(
	    'default' => '#000000',
	) );

	$wp_customize->add_setting( 'htc_font_setting_h3', array(
	    'default' => '24',
	) );

	$wp_customize->add_setting( 'htc_font_setting_h3_type', array(
	    'default' => 'px',
	) );

	$wp_customize->add_setting( 'htc_font_setting_h3_family', array(
	    'default' => 'default',
	) );

	$wp_customize->add_setting( 'htc_font_setting_h3_color', array(
	    'default' => '#000000',
	) );

	$wp_customize->add_setting( 'htc_font_setting_h4', array(
	    'default' => '20',
	) );

	$wp_customize->add_setting( 'htc_font_setting_h4_type', array(
	    'default' => 'px',
	) );

	$wp_customize->add_setting( 'htc_font_setting_h4_family', array(
	    'default' => 'default',
	) );

	$wp_customize->add_setting( 'htc_font_setting_h4_color', array(
	    'default' => '#000000',
	) );

	$wp_customize->add_setting( 'htc_font_setting_h5', array(
	    'default' => '18',
	) );

	$wp_customize->add_setting( 'htc_font_setting_h5_type', array(
	    'default' => 'px',
	) );

	$wp_customize->add_setting( 'htc_font_setting_h5_family', array(
	    'default' => 'default',
	) );

	$wp_customize->add_setting( 'htc_font_setting_h5_color', array(
	    'default' => '#000000',
	) );

	$wp_customize->add_setting( 'htc_font_setting_h6', array(
	    'default' => '16',
	) );

	$wp_customize->add_setting( 'htc_font_setting_h6_type', array(
	    'default' => 'px',
	) );

	$wp_customize->add_setting( 'htc_font_setting_h6_family', array(
	    'default' => 'default',
	) );

	$wp_customize->add_setting( 'htc_font_setting_h6_color', array(
	    'default' => '#000000',
	) );

	$wp_customize->add_setting( 'htc_font_setting_p', array(
	    'default' => '14',
	) );

	$wp_customize->add_setting( 'htc_font_setting_p_type', array(
	    'default' => 'px',
	) );

	$wp_customize->add_setting( 'htc_font_setting_p_family', array(
	    'default' => 'default',
	) );

	$wp_customize->add_setting( 'htc_font_setting_p_color', array(
	    'default' => '#444444',
	) );

	// Header hooks settings
	$wp_customize->add_setting( 'htc_header_box_setting_ga', array(
	    'default' => '',
	    'transport' => 'postMessage'
	) );

	$wp_customize->add_setting( 'htc_header_box_setting_wmt', array(
	    'default' => '',
	    'transport' => 'postMessage'
	) );

	$wp_customize->add_setting( 'htc_header_box_setting_extra', array(
	    'default' => '',
	    'transport' => 'postMessage'
	) );

	// Footer hooks settings
	$wp_customize->add_setting( 'htc_footer_box_setting_fbp', array(
	    'default' => '',
	    'transport' => 'postMessage'
	) );

	$wp_customize->add_setting( 'htc_footer_box_setting_extra', array(
	    'default' => '',
	    'transport' => 'postMessage'
	) );

	// Custom JS settings
	$wp_customize->add_setting( 'htc_custom_js_setting', array(
	    'default' => '',
	    'transport' => 'postMessage'
	) );

	$font_choices = array(
		'default' => 'Select Google Font',
		'Source Sans Pro:400,700,400italic,700italic' => 'Source Sans Pro',
		'Open Sans:400italic,700italic,400,700' => 'Open Sans',
		'Oswald:400,700' => 'Oswald',
		'Playfair Display:400,700,400italic' => 'Playfair Display',
		'Montserrat:400,700' => 'Montserrat',
		'Raleway:400,700' => 'Raleway',
		'Droid Sans:400,700' => 'Droid Sans',
		'Lato:400,700,400italic,700italic' => 'Lato',
		'Arvo:400,700,400italic,700italic' => 'Arvo',
		'Lora:400,700,400italic,700italic' => 'Lora',
		'Merriweather:400,300italic,300,400italic,700,700italic' => 'Merriweather',
		'Oxygen:400,300,700' => 'Oxygen',
		'PT Serif:400,700' => 'PT Serif',
		'PT Sans:400,700,400italic,700italic' => 'PT Sans',
		'PT Sans Narrow:400,700' => 'PT Sans Narrow',
		'Cabin:400,700,400italic' => 'Cabin',
		'Fjalla One:400' => 'Fjalla One',
		'Francois One:400' => 'Francois One',
		'Josefin Sans:400,300,600,700' => 'Josefin Sans',
		'Libre Baskerville:400,400italic,700' => 'Libre Baskerville',
		'Arimo:400,700,400italic,700italic' => 'Arimo',
		'Ubuntu:400,700,400italic,700italic' => 'Ubuntu',
		'Bitter:400,700,400italic' => 'Bitter',
		'Droid Serif:400,700,400italic,700italic' => 'Droid Serif',
		'Roboto:400,400italic,700,700italic' => 'Roboto',
		'Open Sans Condensed:700,300italic,300' => 'Open Sans Condensed',
		'Roboto Condensed:400italic,700italic,400,700' => 'Roboto Condensed',
		'Roboto Slab:400,700' => 'Roboto Slab',
		'Yanone Kaffeesatz:400,700' => 'Yanone Kaffeesatz',
		'Rokkitt:400' => 'Rokkitt',
	);

	$bg_repeat = array( 'no-repeat' => 'no-repeat', 'repeat' => 'repeat', 'repeat-x' => 'repeat-x', 'repeat-y' => 'repeat-y' );
	$bg_position = array( 'center top' => 'center top', 'left top' => 'left top', 'right top' => 'right top', 'center center' => 'center center', 'left center' => 'left center', 'right center' => 'right center', 'center bottom' => 'center bottom', 'left bottom' => 'left bottom', 'right bottom' => 'right bottom' );
	$bg_size = array( 'auto' => 'auto', 'cover' => 'cover', 'contain' => 'contain' );

	// General Controls
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'htc_gen_control_body_color',
		array(
			'label' => __( 'Background Color', $text_domain ),
			'section' => 'htc_gen_body_bg_section',
			'settings' => 'htc_gen_setting_body_color'
		)
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'htc_gen_control_body_img',
		array(
			'label' => __( 'Background Image', $text_domain ),
			'section' => 'htc_gen_body_bg_section',
			'settings' => 'htc_gen_setting_body_img'
		)
	) );

	$wp_customize->add_control( 'htc_gen_control_body_bgrep',
		array(
			'type' => 'select',
			'label' => __( 'Background Repeat', $text_domain ),
			'section' => 'htc_gen_body_bg_section',
			'settings' => 'htc_gen_setting_body_bgrep',
			'choices' => $bg_repeat
		)
	);

	$wp_customize->add_control( 'htc_gen_control_body_bgpos',
		array(
			'type' => 'select',
			'label' => __( 'Background Position', $text_domain ),
			'section' => 'htc_gen_body_bg_section',
			'settings' => 'htc_gen_setting_body_bgpos',
			'choices' => $bg_position
		)
	);

	$wp_customize->add_control( 'htc_gen_control_body_bgsize',
		array(
			'type' => 'select',
			'label' => __( 'Background Size', $text_domain ),
			'section' => 'htc_gen_body_bg_section',
			'settings' => 'htc_gen_setting_body_bgsize',
			'choices' => $bg_size
		)
	);

	$wp_customize->add_control( 'htc_gen_control_phead_enable',
		array(
			'type' => 'radio',
			'label' => __( 'Enable page header?', $text_domain ),
			'section' => 'htc_gen_page_header_section',
			'settings' => 'htc_gen_setting_phead_enable',
			'choices' => array(
				'yes' => 'Yes',
				'no' => 'No'
			)
		)
	);

	$wp_customize->add_control( 'htc_gen_control_phead_width',
		array(
			'type' => 'text',
			'label' => __( 'Width', $text_domain ),
			'description' => __( 'accepts "%" or "px"', $text_domain ),
			'section' => 'htc_gen_page_header_section',
			'settings' => 'htc_gen_setting_phead_width'
		)
	);

	$wp_customize->add_control( 'htc_gen_control_phead_pad',
		array(
			'type' => 'text',
			'label' => __( 'Padding', $text_domain ),
			'description' => __( 'accepts "px" or "em"', $text_domain ),
			'section' => 'htc_gen_page_header_section',
			'settings' => 'htc_gen_setting_phead_pad'
		)
	);

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'htc_gen_control_phead_color',
		array(
			'label' => __( 'Background Color', $text_domain ),
			'section' => 'htc_gen_page_header_section',
			'settings' => 'htc_gen_setting_phead_color'
		)
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'htc_gen_control_phead_img',
		array(
			'label' => __( 'Background Image', $text_domain ),
			'section' => 'htc_gen_page_header_section',
			'settings' => 'htc_gen_setting_phead_img'
		)
	) );

	$wp_customize->add_control( 'htc_gen_control_phead_bgrep',
		array(
			'type' => 'select',
			'label' => __( 'Background Repeat', $text_domain ),
			'section' => 'htc_gen_page_header_section',
			'settings' => 'htc_gen_setting_phead_bgrep',
			'choices' => $bg_repeat
		)
	);

	$wp_customize->add_control( 'htc_gen_control_phead_bgpos',
		array(
			'type' => 'select',
			'label' => __( 'Background Position', $text_domain ),
			'section' => 'htc_gen_page_header_section',
			'settings' => 'htc_gen_setting_phead_bgpos',
			'choices' => $bg_position
		)
	);

	$wp_customize->add_control( 'htc_gen_control_phead_bgsize',
		array(
			'type' => 'select',
			'label' => __( 'Background Size', $text_domain ),
			'section' => 'htc_gen_page_header_section',
			'settings' => 'htc_gen_setting_phead_bgsize',
			'choices' => $bg_size
		)
	);

	$wp_customize->add_control( 'htc_dashboard_cleanup_control',
		array(
			'type' => 'radio',
			'description' => __( 'Enable dashboard clean-up?', $text_domain ),
			'section' => 'htc_dashboard_cleanup_section',
			'settings' => 'htc_dashboard_cleanup_setting',
			'choices' => array(
				'yes' => 'Yes',
				'no' => 'No'
			)
		)
	);

	$wp_customize->add_control( 'htc_comments_control',
		array(
			'type' => 'radio',
			'description' => __( 'Disable Comments functionality?', $text_domain ),
			'section' => 'htc_comments_section',
			'settings' => 'htc_comments_setting',
			'choices' => array(
				'yes' => 'Yes',
				'no' => 'No'
			)
		)
	);

	// Font Controls
	$wp_customize->add_control( 'htc_font_control_h1',
		array(
			'type' => 'number',
			'label' => __( 'H1', $text_domain ),
			'description' => __( 'Size', $text_domain ),
			'section' => 'htc_font_h1_section',
			'settings' => 'htc_font_setting_h1',
			'input_attrs' => array(
				'min' => 0,
				'step' => 1,
			),
		)
	);

	$wp_customize->add_control( 'htc_font_control_h1_type',
		array(
			'type' => 'select',
			'description' => __( 'Type', $text_domain ),
			'section' => 'htc_font_h1_section',
			'settings' => 'htc_font_setting_h1_type',
			'choices' => array(
				'px' => 'px',
				'em' => 'em',
			),
		)
	);

	$wp_customize->add_control( 'htc_font_control_h1_family',
		array(
			'type' => 'select',
			'description' => __( 'Family', $text_domain ),
			'section' => 'htc_font_h1_section',
			'settings' => 'htc_font_setting_h1_family',
			'choices' => $font_choices
		)
	);

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'htc_font_control_h1_color',
		array(
			'description' => __( 'Color', $text_domain ),
			'section' => 'htc_font_h1_section',
			'settings' => 'htc_font_setting_h1_color',
		)
	) );

	$wp_customize->add_control( 'htc_font_control_h2',
		array(
			'type' => 'number',
			'label' => __( 'H2', $text_domain ),
			'description' => __( 'Size', $text_domain ),
			'section' => 'htc_font_h2_section',
			'settings' => 'htc_font_setting_h2',
			'input_attrs' => array(
				'min' => 0,
				'step' => 1,
			),
		)
	);

	$wp_customize->add_control( 'htc_font_control_h2_type',
		array(
			'type' => 'select',
			'description' => __( 'Type', $text_domain ),
			'section' => 'htc_font_h2_section',
			'settings' => 'htc_font_setting_h2_type',
			'choices' => array(
				'px' => 'px',
				'em' => 'em',
			),
		)
	);

	$wp_customize->add_control( 'htc_font_control_h2_family',
		array(
			'type' => 'select',
			'description' => __( 'Family', $text_domain ),
			'section' => 'htc_font_h2_section',
			'settings' => 'htc_font_setting_h2_family',
			'choices' => $font_choices
		)
	);

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'htc_font_control_h2_color',
		array(
			'description' => __( 'Color', $text_domain ),
			'section' => 'htc_font_h2_section',
			'settings' => 'htc_font_setting_h2_color',
		)
	) );

	$wp_customize->add_control( 'htc_font_control_h3',
		array(
			'type' => 'number',
			'label' => __( 'H3', $text_domain ),
			'description' => __( 'Size', $text_domain ),
			'section' => 'htc_font_h3_section',
			'settings' => 'htc_font_setting_h3',
			'input_attrs' => array(
				'min' => 0,
				'step' => 1,
			),
		)
	);

	$wp_customize->add_control( 'htc_font_control_h3_type',
		array(
			'type' => 'select',
			'description' => __( 'Type', $text_domain ),
			'section' => 'htc_font_h3_section',
			'settings' => 'htc_font_setting_h3_type',
			'choices' => array(
				'px' => 'px',
				'em' => 'em',
			),
		)
	);

	$wp_customize->add_control( 'htc_font_control_h3_family',
		array(
			'type' => 'select',
			'description' => __( 'Family', $text_domain ),
			'section' => 'htc_font_h3_section',
			'settings' => 'htc_font_setting_h3_family',
			'choices' => $font_choices
		)
	);

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'htc_font_control_h3_color',
		array(
			'description' => __( 'Color', $text_domain ),
			'section' => 'htc_font_h3_section',
			'settings' => 'htc_font_setting_h3_color',
		)
	) );

	$wp_customize->add_control( 'htc_font_control_h4',
		array(
			'type' => 'number',
			'label' => __( 'H4', $text_domain ),
			'description' => __( 'Size', $text_domain ),
			'section' => 'htc_font_h4_section',
			'settings' => 'htc_font_setting_h4',
			'input_attrs' => array(
				'min' => 0,
				'step' => 1,
			),
		)
	);

	$wp_customize->add_control( 'htc_font_control_h4_type',
		array(
			'type' => 'select',
			'description' => __( 'Type', $text_domain ),
			'section' => 'htc_font_h4_section',
			'settings' => 'htc_font_setting_h4_type',
			'choices' => array(
				'px' => 'px',
				'em' => 'em',
			),
		)
	);

	$wp_customize->add_control( 'htc_font_control_h4_family',
		array(
			'type' => 'select',
			'description' => __( 'Family', $text_domain ),
			'section' => 'htc_font_h4_section',
			'settings' => 'htc_font_setting_h4_family',
			'choices' => $font_choices
		)
	);

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'htc_font_control_h4_color',
		array(
			'description' => __( 'Color', $text_domain ),
			'section' => 'htc_font_h4_section',
			'settings' => 'htc_font_setting_h4_color',
		)
	) );

	$wp_customize->add_control( 'htc_font_control_h5',
		array(
			'type' => 'number',
			'label' => __( 'H5', $text_domain ),
			'description' => __( 'Size', $text_domain ),
			'section' => 'htc_font_h5_section',
			'settings' => 'htc_font_setting_h5',
			'input_attrs' => array(
				'min' => 0,
				'step' => 1,
			),
		)
	);

	$wp_customize->add_control( 'htc_font_control_h5_type',
		array(
			'type' => 'select',
			'description' => __( 'Type', $text_domain ),
			'section' => 'htc_font_h5_section',
			'settings' => 'htc_font_setting_h5_type',
			'choices' => array(
				'px' => 'px',
				'em' => 'em',
			),
		)
	);

	$wp_customize->add_control( 'htc_font_control_h5_family',
		array(
			'type' => 'select',
			'description' => __( 'Family', $text_domain ),
			'section' => 'htc_font_h5_section',
			'settings' => 'htc_font_setting_h5_family',
			'choices' => $font_choices
		)
	);

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'htc_font_control_h5_color',
		array(
			'description' => __( 'Color', $text_domain ),
			'section' => 'htc_font_h5_section',
			'settings' => 'htc_font_setting_h5_color',
		)
	) );

	$wp_customize->add_control( 'htc_font_control_h6',
		array(
			'type' => 'number',
			'label' => __( 'H6', $text_domain ),
			'description' => __( 'Size', $text_domain ),
			'section' => 'htc_font_h6_section',
			'settings' => 'htc_font_setting_h6',
			'input_attrs' => array(
				'min' => 0,
				'step' => 1,
			),
		)
	);

	$wp_customize->add_control( 'htc_font_control_h6_type',
		array(
			'type' => 'select',
			'description' => __( 'Type', $text_domain ),
			'section' => 'htc_font_h6_section',
			'settings' => 'htc_font_setting_h6_type',
			'choices' => array(
				'px' => 'px',
				'em' => 'em',
			),
		)
	);

	$wp_customize->add_control( 'htc_font_control_h6_family',
		array(
			'type' => 'select',
			'description' => __( 'Family', $text_domain ),
			'section' => 'htc_font_h6_section',
			'settings' => 'htc_font_setting_h6_family',
			'choices' => $font_choices
		)
	);

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'htc_font_control_h6_color',
		array(
			'description' => __( 'Color', $text_domain ),
			'section' => 'htc_font_h6_section',
			'settings' => 'htc_font_setting_h6_color',
		)
	) );

	$wp_customize->add_control( 'htc_font_control_p',
		array(
			'type' => 'number',
			'description' => __( 'Size', $text_domain ),
			'section' => 'htc_font_ptag_section',
			'settings' => 'htc_font_setting_p',
			'input_attrs' => array(
				'min' => 0,
				'step' => 1,
			),
		)
	);

	$wp_customize->add_control( 'htc_font_control_p_type',
		array(
			'type' => 'select',
			'description' => __( 'Type', $text_domain ),
			'section' => 'htc_font_ptag_section',
			'settings' => 'htc_font_setting_p_type',
			'choices' => array(
				'px' => 'px',
				'em' => 'em',
			),
		)
	);

	$wp_customize->add_control( 'htc_font_control_p_family',
		array(
			'type' => 'select',
			'description' => __( 'Family', $text_domain ),
			'section' => 'htc_font_ptag_section',
			'settings' => 'htc_font_setting_p_family',
			'choices' => $font_choices
		)
	);

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'htc_font_control_p_color',
		array(
			'description' => __( 'Color', $text_domain ),
			'section' => 'htc_font_ptag_section',
			'settings' => 'htc_font_setting_p_color',
		)
	) );
	
	// Header hooks controls
	$wp_customize->add_control( new WP_Customize_Code_Editor_Control( $wp_customize, 'htc_header_box_control_ga',
		array(
			'description' => __( 'Google Analytics code', $text_domain ),
			'section' => 'htc_header_box_ga_section',
			'settings' => 'htc_header_box_setting_ga',
		)
	) );

	$wp_customize->add_control( new WP_Customize_Code_Editor_Control( $wp_customize, 'htc_header_box_control_wmt',
		array(
			'description' => __( 'Webmaster Tools', $text_domain ),
			'section' => 'htc_header_box_wmt_section',
			'settings' => 'htc_header_box_setting_wmt',
		)
	) );

	$wp_customize->add_control( new WP_Customize_Code_Editor_Control( $wp_customize, 'htc_header_box_control_extra',
		array(
			'description' => __( 'Additional codes here', $text_domain ),
			'section' => 'htc_header_box_extra_section',
			'settings' => 'htc_header_box_setting_extra',
		)
	) );

	// Footer hooks controls
	$wp_customize->add_control( new WP_Customize_Code_Editor_Control( $wp_customize, 'htc_footer_box_control_fbp',
		array(
			'description' => __( 'Facebook Pixel Code', $text_domain ),
			'section' => 'htc_footer_box_fbp_section',
			'settings' => 'htc_footer_box_setting_fbp',
		)
	) );

	$wp_customize->add_control( new WP_Customize_Code_Editor_Control( $wp_customize, 'htc_footer_box_control_extra',
		array(
			'description' => __( 'Additional codes here', $text_domain ),
			'section' => 'htc_footer_box_extra_section',
			'settings' => 'htc_footer_box_setting_extra',
		)
	) );

	// Custom JS controls
	$wp_customize->add_control( new WP_Customize_Code_Editor_Control( $wp_customize, 'htc_custom_js_control',
		array(
			'description' => __( 'Put Javascript/jQuery code here', $text_domain ),
			'section' => 'htc_custom_js_section',
			'settings' => 'htc_custom_js_setting',
		)
	) );
}