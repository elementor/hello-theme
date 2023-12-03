<?php
// WP Theme Customizer
if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'customize_controls_enqueue_scripts', 'hello_theme_clone_customize_scripts' );
function hello_theme_clone_customize_scripts(){
	wp_enqueue_style( 'wp-customize-styles', get_template_directory_uri() . '/assets/htc-customize-styles.css' );
}

add_action( 'customize_register', 'hello_theme_child_customize_register' );
function hello_theme_child_customize_register( $wp_customize ) {
	$text_domain = 'hello-theme-child';
	// General Panel
	$wp_customize->add_panel( 'htc_general_panel', array(
		'title' => __( 'General Settings' ),
		'priority' => 25,
	) );

	// Theme Styles Panel
	$wp_customize->add_panel( 'htc_themestyles_panel', array(
		'title' => __( 'Theme Styles' ),
		'priority' => 28,
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

	$wp_customize->add_section( 'htc_gen_gform_section', array(
	    'title' => __( 'Gravity Form', $text_domain ),
	    'panel' => 'htc_general_panel'
	) );

	$wp_customize->add_section( 'htc_login_screen_section', array(
	    'title' => __( 'Login Screen', $text_domain ),
	    'panel' => 'htc_general_panel'
	) );

	$wp_customize->add_section( 'htc_dashboard_cleanup_section', array(
	    'title' => __( 'Dashboard', $text_domain ),
	    'panel' => 'htc_general_panel'
	) );

	$wp_customize->add_section( 'htc_comments_section', array(
	    'title' => __( 'Comments', $text_domain ),
	    'panel' => 'htc_general_panel'
	) );

	$wp_customize->add_section( 'htc_gbg_section', array(
	    'title' => __( 'Gutenberg', $text_domain ),
	    'panel' => 'htc_general_panel'
	) );

	$wp_customize->add_section( 'htc_updates_email_section', array(
	    'title' => __( 'Updates Email', $text_domain ),
	    'panel' => 'htc_general_panel'
	) );

	// Theme Styles Section
	$wp_customize->add_section( 'htc_themestyles_gl_section', array(
	    'title' => __( 'Global Styles', $text_domain ),
	    'panel' => 'htc_themestyles_panel'
	) );

	$wp_customize->add_section( 'htc_themestyles_gf_section', array(
	    'title' => __( 'Gravity Forms', $text_domain ),
	    'panel' => 'htc_themestyles_panel'
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

	$wp_customize->add_section( 'htc_font_atag_section', array(
	    'title' => __( 'Links', $text_domain ),
	    'priority' => 50,
	    'panel' => 'htc_font_panel'
	) );

	$wp_customize->add_section( 'htc_button_section', array(
	    'title' => __( 'Buttons', $text_domain ),
	    'priority' => 50,
	    'panel' => 'htc_font_panel'
	) );

	// Header hooks Section
	$wp_customize->add_section( 'htc_header_box_ga_section', array(
	    'title' => __( 'Google Analytics', $text_domain ),
	    'priority' => 10,
	    'panel' => 'htc_header_box_panel'
	) );

	$wp_customize->add_section( 'htc_header_box_gtm_section', array(
	    'title' => __( 'Google Tag Manager', $text_domain ),
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

	$wp_customize->add_setting( 'htc_gen_setting_content_width', array(
	    'default' => '1140px'
	) );

	$wp_customize->add_setting( 'htc_gen_setting_line_height', array(
	    'default' => '1.5em'
	) );

	$wp_customize->add_setting( 'htc_gen_setting_phead_enable', array(
	    'default' => 'no'
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

	$wp_customize->add_setting( 'htc_gen_setting_phead_fontsize', array(
	    'default' => '40'
	) );

	$wp_customize->add_setting( 'htc_gen_setting_phead_fonttype', array(
	    'default' => 'px'
	) );

	$wp_customize->add_setting( 'htc_gen_setting_phead_fontfamily', array(
	    'default' => 'default'
	) );

	$wp_customize->add_setting( 'htc_gen_setting_phead_fontcolor', array(
	    'default' => '#000000'
	) );

	$wp_customize->add_setting( 'htc_gen_setting_phead_align', array(
	    'default' => 'center'
	) );

	$wp_customize->add_setting( 'htc_gen_setting_gform_bg', array(
	    'default' => ''
	) );

	$wp_customize->add_setting( 'htc_gen_setting_gform_ffamily', array(
	    'default' => 'default'
	) );

	$wp_customize->add_setting( 'htc_gen_setting_gform_fsize', array(
	    'default' => '16px'
	) );

	$wp_customize->add_setting( 'htc_gen_setting_gform_lcolor', array(
	    'default' => '#444444'
	) );

	$wp_customize->add_setting( 'htc_gen_setting_gform_fcolor', array(
	    'default' => '#444444'
	) );

	$wp_customize->add_setting( 'htc_gen_setting_gform_pcolor', array(
	    'default' => '#888888'
	) );

	$wp_customize->add_setting( 'htc_gen_setting_gform_border', array(
	    'default' => ''
	) );

	$wp_customize->add_setting( 'htc_gen_setting_gform_padding', array(
	    'default' => ''
	) );

	$wp_customize->add_setting( 'htc_gen_setting_gform_margin', array(
	    'default' => ''
	) );

	$wp_customize->add_setting( 'htc_gen_setting_gform_text_bg', array(
	    'default' => ''
	) );

	$wp_customize->add_setting( 'htc_gen_setting_gform_text_bor', array(
	    'default' => ''
	) );

	$wp_customize->add_setting( 'htc_gen_setting_gform_text_pad', array(
	    'default' => ''
	) );

	$wp_customize->add_setting( 'htc_gen_setting_gform_text_mar', array(
	    'default' => ''
	) );

	$wp_customize->add_setting( 'htc_gen_setting_gform_sel_bg', array(
	    'default' => ''
	) );

	$wp_customize->add_setting( 'htc_gen_setting_gform_sel_bor', array(
	    'default' => ''
	) );

	$wp_customize->add_setting( 'htc_gen_setting_gform_sel_pad', array(
	    'default' => ''
	) );

	$wp_customize->add_setting( 'htc_gen_setting_gform_sel_mar', array(
	    'default' => ''
	) );

	$wp_customize->add_setting( 'htc_gen_setting_gform_texta_bg', array(
	    'default' => ''
	) );

	$wp_customize->add_setting( 'htc_gen_setting_gform_texta_bor', array(
	    'default' => ''
	) );

	$wp_customize->add_setting( 'htc_gen_setting_gform_texta_pad', array(
	    'default' => ''
	) );

	$wp_customize->add_setting( 'htc_gen_setting_gform_texta_mar', array(
	    'default' => ''
	) );

	$wp_customize->add_setting( 'htc_gen_setting_gform_texta_hei', array(
	    'default' => ''
	) );

	$wp_customize->add_setting( 'htc_gen_setting_gform_but_bg', array(
	    'default' => ''
	) );

	$wp_customize->add_setting( 'htc_gen_setting_gform_but_color', array(
	    'default' => '#FFFFFF'
	) );

	$wp_customize->add_setting( 'htc_gen_setting_gform_but_fsize', array(
	    'default' => '15px'
	) );

	$wp_customize->add_setting( 'htc_gen_setting_gform_but_bor', array(
	    'default' => ''
	) );

	$wp_customize->add_setting( 'htc_gen_setting_gform_but_borr', array(
	    'default' => '5px'
	) );

	$wp_customize->add_setting( 'htc_gen_setting_gform_but_pad', array(
	    'default' => ''
	) );

	$wp_customize->add_setting( 'htc_gen_setting_gform_but_mar', array(
	    'default' => ''
	) );

	$wp_customize->add_setting( 'htc_gen_setting_gform_but_ali', array(
	    'default' => 'left'
	) );

	$wp_customize->add_setting( 'htc_loginsc_bg_setting', array(
	    'default' => '#F1F1F1',
	    'transport' => 'postMessage'
	) );

	$wp_customize->add_setting( 'htc_logo_enable_setting', array(
	    'default' => 'yes',
	    'transport' => 'postMessage'
	) );

	$wp_customize->add_setting( 'htc_logo_height_setting', array(
	    'default' => '100',
	    'transport' => 'postMessage'
	) );

	$wp_customize->add_setting( 'htc_logo_width_setting', array(
	    'default' => '320',
	    'transport' => 'postMessage'
	) );

	$wp_customize->add_setting( 'htc_logo_bg_setting', array(
	    'default' => '',
	    'transport' => 'postMessage'
	) );

	$wp_customize->add_setting( 'htc_dashboard_cleanup_setting', array(
	    'default' => 'yes',
	    'transport' => 'postMessage'
	) );

	$wp_customize->add_setting( 'htc_comments_setting', array(
	    'default' => 'yes',
	    'transport' => 'postMessage'
	) );

	$wp_customize->add_setting( 'htc_gbg_post_setting', array(
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'htc_sanitize_checkbox',
		'transport' => 'postMessage'
	) );

	// Theme Styles settings
	$wp_customize->add_setting( 'htc_themestyles_gl_setting', array(
	    'default' => 'no',
	    'transport' => 'postMessage'
	) );

	$wp_customize->add_setting( 'htc_themestyles_gf_setting', array(
	    'default' => 'no',
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

	$wp_customize->add_setting( 'htc_font_setting_a_default', array(
	    'default' => '#333333',
	) );

	$wp_customize->add_setting( 'htc_font_setting_a_hover', array(
	    'default' => '#888888',
	) );

	$wp_customize->add_setting( 'htc_font_setting_a_decor', array(
	    'default' => 'none',
	) );

	$wp_customize->add_setting( 'htc_button_setting_bg_def', array(
	    'default' => '#444444',
	) );

	$wp_customize->add_setting( 'htc_button_setting_bg_hov', array(
	    'default' => '#222222',
	) );

	$wp_customize->add_setting( 'htc_button_setting_text_def', array(
	    'default' => '#FFFFFF',
	) );

	$wp_customize->add_setting( 'htc_button_setting_text_hov', array(
	    'default' => '#FFFFFF',
	) );

	$wp_customize->add_setting( 'htc_button_setting_borw', array(
	    'default' => '1',
	) );

	$wp_customize->add_setting( 'htc_button_setting_borc_def', array(
	    'default' => '#444444',
	) );

	$wp_customize->add_setting( 'htc_button_setting_borc_hov', array(
	    'default' => '#222222',
	) );

	$wp_customize->add_setting( 'htc_button_setting_pad', array(
	    'default' => '10px',
	) );

	// Header hooks settings
	$wp_customize->add_setting( 'htc_header_box_setting_ga', array(
	    'default' => '',
	    'transport' => 'postMessage'
	) );

	$wp_customize->add_setting( 'htc_header_box_setting_gtm', array(
	    'default' => '',
	    'transport' => 'postMessage'
	) );

	$wp_customize->add_setting( 'htc_header_box_setting_gtmn', array(
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
		'Abril Fatface' => 'Abril Fatface',
		'Arimo:400,700,400italic,700italic' => 'Arimo',
		'Arvo:400,700,400italic,700italic' => 'Arvo',
		'Average' => 'Average',
		'Baloo Thambi 2:400,700,800' => 'Baloo Thambi 2',
		'Barlow:400,700' => 'Barlow',
		'Basic' => 'Basic',
		'Bitter:400,700,400italic' => 'Bitter',
		'Cabin:400,700,400italic' => 'Cabin',
		'Cairo:400,700' => 'Cairo',
		'Crimson Text:400,400i,700,700i' => 'Crimson Text',
		'DM Sans:400,700' => 'DM Sans',
		'Dosis:400,700' => 'Dosis',
		'Droid Sans:400,700' => 'Droid Sans',
		'Droid Serif:400,700,400italic,700italic' => 'Droid Serif',
		'EB Garamond:400,500,700' => 'EB Garamond',
		'Encode Sans:400,700' => 'Encode Sans',
		'Enriqueta:400,700' => 'Enriqueta',
		'Exo:400,700' => 'Exo',
		'Fjalla One:400' => 'Fjalla One',
		'Francois One:400' => 'Francois One',
		'Gilda Display' => 'Gilda Display',
		'Gotu' => 'Gotu',
		'Gravitas One' => 'Gravitas One',
		'Josefin Sans:400,300,600,700' => 'Josefin Sans',
		'Lato:400,700,400italic,700italic' => 'Lato',
		'Libre Baskerville:400,400italic,700' => 'Libre Baskerville',
		'Lora:400,700,400italic,700italic' => 'Lora',
		'Merriweather:400,300italic,300,400italic,700,700italic' => 'Merriweather',
		'Montserrat:400,700' => 'Montserrat',
		'Old Standard TT:400,400i,700' => 'Old Standard TT',
		'Open Sans:400italic,700italic,400,700' => 'Open Sans',
		'Open Sans Condensed:700,300italic,300' => 'Open Sans Condensed',
		'Orbitron:400,700' => 'Orbitron',
		'Oswald:400,700' => 'Oswald',
		'Oxygen:400,300,700' => 'Oxygen',
		'Playfair Display:400,700,400italic' => 'Playfair Display',
		'Poppins:300,400,700' => 'Poppins',
		'Prata' => 'Prata',
		'PT Mono' => 'PT Mono',
		'PT Serif:400,700' => 'PT Serif',
		'PT Sans:400,700,400italic,700italic' => 'PT Sans',
		'PT Sans Narrow:400,700' => 'PT Sans Narrow',
		'Quicksand:300,400,700' => 'Quicksand',
		'Raleway:400,700' => 'Raleway',
		'Roboto:400,400italic,700,700italic' => 'Roboto',
		'Roboto Condensed:400italic,700italic,400,700' => 'Roboto Condensed',
		'Roboto Slab:400,700' => 'Roboto Slab',
		'Rokkitt:400' => 'Rokkitt',
		'Source Sans Pro:400,700,400italic,700italic' => 'Source Sans Pro',
		'Ubuntu:400,700,400italic,700italic' => 'Ubuntu',
		'Vollkorn:400,400i,700' => 'Vollkorn',
		'Work Sans:300,400,700' => 'Work Sans',
		'Yanone Kaffeesatz:400,700' => 'Yanone Kaffeesatz',
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

	$wp_customize->add_control( 'htc_gen_control_content_width',
		array(
			'type' => 'text',
			'label' => __( 'Page Content', $text_domain ),
			'description' => __( 'Width (accepts "%" or "px")', $text_domain ),
			'section' => 'htc_gen_body_bg_section',
			'settings' => 'htc_gen_setting_content_width'
		)
	);

	$wp_customize->add_control( 'htc_gen_control_content_width',
		array(
			'type' => 'text',
			'label' => __( 'Line Height', $text_domain ),
			'description' => __( 'Accepts "em" or "px"', $text_domain ),
			'section' => 'htc_gen_body_bg_section',
			'settings' => 'htc_gen_setting_line_height'
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

	$wp_customize->add_control( 'htc_gen_control_phead_align',
		array(
			'type' => 'select',
			'label' => __( 'Alignment', $text_domain ),
			'section' => 'htc_gen_page_header_section',
			'settings' => 'htc_gen_setting_phead_align',
			'choices' => array(
				'left' => 'left',
				'center' => 'center',
				'right' => 'right'
			),
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

	$wp_customize->add_control( 'htc_gen_control_phead_fontsize',
		array(
			'type' => 'number',
			'label' => __( 'Title', $text_domain ),
			'description' => __( 'Font size', $text_domain ),
			'section' => 'htc_gen_page_header_section',
			'settings' => 'htc_gen_setting_phead_fontsize',
			'input_attrs' => array(
				'min' => 0,
				'step' => 1,
			),
		)
	);

	$wp_customize->add_control( 'htc_gen_control_phead_fonttype',
		array(
			'type' => 'select',
			'description' => __( 'Type', $text_domain ),
			'section' => 'htc_gen_page_header_section',
			'settings' => 'htc_gen_setting_phead_fonttype',
			'choices' => array(
				'px' => 'px',
				'em' => 'em',
			),
		)
	);

	$wp_customize->add_control( 'htc_gen_control_phead_fontfamily',
		array(
			'type' => 'select',
			'description' => __( 'Family', $text_domain ),
			'section' => 'htc_gen_page_header_section',
			'settings' => 'htc_gen_setting_phead_fontfamily',
			'choices' => $font_choices
		)
	);

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'htc_gen_control_phead_fontcolor',
		array(
			'description' => __( 'Color', $text_domain ),
			'section' => 'htc_gen_page_header_section',
			'settings' => 'htc_gen_setting_phead_fontcolor',
		)
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'htc_gen_control_gform_bg',
		array(
			'label' => __( 'General styles', $text_domain ),
			'description' => __( 'Background color', $text_domain ),
			'section' => 'htc_gen_gform_section',
			'settings' => 'htc_gen_setting_gform_bg',
		)
	) );

	$wp_customize->add_control( 'htc_gen_control_gform_padding',
		array(
			'type' => 'text',
			'description' => __( 'Padding (eg. 10px)', $text_domain ),
			'section' => 'htc_gen_gform_section',
			'settings' => 'htc_gen_setting_gform_padding',
		)
	);

	$wp_customize->add_control( 'htc_gen_control_gform_margin',
		array(
			'type' => 'text',
			'description' => __( 'Margin (eg. 10px)', $text_domain ),
			'section' => 'htc_gen_gform_section',
			'settings' => 'htc_gen_setting_gform_margin'
		)
	);

	$wp_customize->add_control( 'htc_gen_control_gform_border',
		array(
			'type' => 'text',
			'description' => __( 'Border (eg. 1px solid #000000)', $text_domain ),
			'section' => 'htc_gen_gform_section',
			'settings' => 'htc_gen_setting_gform_border',
		)
	);

	$wp_customize->add_control( 'htc_gen_control_gform_ffamily',
		array(
			'type' => 'select',
			'description' => __( 'Font family', $text_domain ),
			'section' => 'htc_gen_gform_section',
			'settings' => 'htc_gen_setting_gform_ffamily',
			'choices' => $font_choices
		)
	);

	$wp_customize->add_control( 'htc_gen_control_gform_fsize',
		array(
			'type' => 'text',
			'description' => __( 'Font size (eg. 16px)', $text_domain ),
			'section' => 'htc_gen_gform_section',
			'settings' => 'htc_gen_setting_gform_fsize',
		)
	);

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'htc_gen_control_gform_lcolor',
		array(
			'description' => __( 'Label color', $text_domain ),
			'section' => 'htc_gen_gform_section',
			'settings' => 'htc_gen_setting_gform_lcolor',
		)
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'htc_gen_control_gform_fcolor',
		array(
			'description' => __( 'Field font color', $text_domain ),
			'section' => 'htc_gen_gform_section',
			'settings' => 'htc_gen_setting_gform_fcolor',
		)
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'htc_gen_control_gform_pcolor',
		array(
			'description' => __( 'Placeholder font color', $text_domain ),
			'section' => 'htc_gen_gform_section',
			'settings' => 'htc_gen_setting_gform_pcolor',
		)
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'htc_gen_control_gform_text_bg',
		array(
			'label' => __( 'Input field (Text, Email)', $text_domain ),
			'description' => __( 'Background color', $text_domain ),
			'section' => 'htc_gen_gform_section',
			'settings' => 'htc_gen_setting_gform_text_bg',
		)
	) );

	$wp_customize->add_control( 'htc_gen_control_gform_text_pad',
		array(
			'type' => 'text',
			'description' => __( 'Padding', $text_domain ),
			'section' => 'htc_gen_gform_section',
			'settings' => 'htc_gen_setting_gform_text_pad',
		)
	);

	$wp_customize->add_control( 'htc_gen_control_gform_text_mar',
		array(
			'type' => 'text',
			'description' => __( 'Margin', $text_domain ),
			'section' => 'htc_gen_gform_section',
			'settings' => 'htc_gen_setting_gform_text_mar',
		)
	);

	$wp_customize->add_control( 'htc_gen_control_gform_text_bor',
		array(
			'type' => 'text',
			'description' => __( 'Border (eg. 1px solid #000000)', $text_domain ),
			'section' => 'htc_gen_gform_section',
			'settings' => 'htc_gen_setting_gform_text_bor',
		)
	);

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'htc_gen_control_gform_sel_bg',
		array(
			'label' => __( 'Select field (Dropdown)', $text_domain ),
			'description' => __( 'Background color', $text_domain ),
			'section' => 'htc_gen_gform_section',
			'settings' => 'htc_gen_setting_gform_sel_bg',
		)
	) );

	$wp_customize->add_control( 'htc_gen_control_gform_sel_pad',
		array(
			'type' => 'text',
			'description' => __( 'Padding', $text_domain ),
			'section' => 'htc_gen_gform_section',
			'settings' => 'htc_gen_setting_gform_sel_pad',
		)
	);

	$wp_customize->add_control( 'htc_gen_control_gform_sel_mar',
		array(
			'type' => 'text',
			'description' => __( 'Margin', $text_domain ),
			'section' => 'htc_gen_gform_section',
			'settings' => 'htc_gen_setting_gform_sel_mar',
		)
	);

	$wp_customize->add_control( 'htc_gen_control_gform_sel_bor',
		array(
			'type' => 'text',
			'description' => __( 'Border (eg. 1px solid #000000)', $text_domain ),
			'section' => 'htc_gen_gform_section',
			'settings' => 'htc_gen_setting_gform_sel_bor',
		)
	);

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'htc_gen_control_gform_texta_bg',
		array(
			'label' => __( 'Textarea field', $text_domain ),
			'description' => __( 'Background color', $text_domain ),
			'section' => 'htc_gen_gform_section',
			'settings' => 'htc_gen_setting_gform_texta_bg',
		)
	) );

	$wp_customize->add_control( 'htc_gen_control_gform_texta_pad',
		array(
			'type' => 'text',
			'description' => __( 'Padding', $text_domain ),
			'section' => 'htc_gen_gform_section',
			'settings' => 'htc_gen_setting_gform_texta_pad',
		)
	);

	$wp_customize->add_control( 'htc_gen_control_gform_texta_mar',
		array(
			'type' => 'text',
			'description' => __( 'Margin', $text_domain ),
			'section' => 'htc_gen_gform_section',
			'settings' => 'htc_gen_setting_gform_texta_mar',
		)
	);

	$wp_customize->add_control( 'htc_gen_control_gform_texta_bor',
		array(
			'type' => 'text',
			'description' => __( 'Border (eg. 1px solid #000000)', $text_domain ),
			'section' => 'htc_gen_gform_section',
			'settings' => 'htc_gen_setting_gform_texta_bor',
		)
	);

	$wp_customize->add_control( 'htc_gen_control_gform_texta_hei',
		array(
			'type' => 'text',
			'description' => __( 'Height (eg. 150px)', $text_domain ),
			'section' => 'htc_gen_gform_section',
			'settings' => 'htc_gen_setting_gform_texta_hei',
		)
	);

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'htc_gen_control_gform_but_bg',
		array(
			'label' => __( 'Button (default)', $text_domain ),
			'description' => __( 'Background color', $text_domain ),
			'section' => 'htc_gen_gform_section',
			'settings' => 'htc_gen_setting_gform_but_bg',
		)
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'htc_gen_control_gform_but_color',
		array(
			'description' => __( 'Font color', $text_domain ),
			'section' => 'htc_gen_gform_section',
			'settings' => 'htc_gen_setting_gform_but_color',
		)
	) );

	$wp_customize->add_control( 'htc_gen_control_gform_but_fsize',
		array(
			'type' => 'text',
			'description' => __( 'Font size', $text_domain ),
			'section' => 'htc_gen_gform_section',
			'settings' => 'htc_gen_setting_gform_but_fsize',
		)
	);

	$wp_customize->add_control( 'htc_gen_control_gform_but_pad',
		array(
			'type' => 'text',
			'description' => __( 'Padding', $text_domain ),
			'section' => 'htc_gen_gform_section',
			'settings' => 'htc_gen_setting_gform_but_pad',
		)
	);

	$wp_customize->add_control( 'htc_gen_control_gform_but_mar',
		array(
			'type' => 'text',
			'description' => __( 'Margin', $text_domain ),
			'section' => 'htc_gen_gform_section',
			'settings' => 'htc_gen_setting_gform_but_mar',
		)
	);

	$wp_customize->add_control( 'htc_gen_control_gform_but_bor',
		array(
			'type' => 'text',
			'description' => __( 'Border (eg. 1px solid #000000)', $text_domain ),
			'section' => 'htc_gen_gform_section',
			'settings' => 'htc_gen_setting_gform_but_bor',
		)
	);

	$wp_customize->add_control( 'htc_gen_control_gform_but_borr',
		array(
			'type' => 'text',
			'description' => __( 'Border radius (eg. 5px)', $text_domain ),
			'section' => 'htc_gen_gform_section',
			'settings' => 'htc_gen_setting_gform_but_borr',
		)
	);

	$wp_customize->add_control( 'htc_gen_control_gform_but_ali',
		array(
			'type' => 'select',
			'description' => __( 'Alignment', $text_domain ),
			'section' => 'htc_gen_gform_section',
			'settings' => 'htc_gen_setting_gform_but_ali',
			'choices' => array(
				'left' => 'Left',
				'center' => 'Center',
				'right' => 'Right'
			)
		)
	);

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'htc_loginsc_bg_control',
		array(
			'description' => __( 'Login page background color', $text_domain ),
			'section' => 'htc_login_screen_section',
			'settings' => 'htc_loginsc_bg_setting',
		)
	) );

	$wp_customize->add_control( 'htc_logo_enable_control',
		array(
			'type' => 'radio',
			'description' => __( 'Enable site logo in login screen?', $text_domain ),
			'section' => 'htc_login_screen_section',
			'settings' => 'htc_logo_enable_setting',
			'choices' => array(
				'yes' => 'Yes',
				'no' => 'No'
			)
		)
	);

	$wp_customize->add_control( 'htc_logo_height_control',
		array(
			'type' => 'number',
			'description' => __( 'Logo Height (px)', $text_domain ),
			'section' => 'htc_login_screen_section',
			'settings' => 'htc_logo_height_setting',
			'input_attrs' => array(
				'min' => 0,
				'step' => 1,
			),
		)
	);

	$wp_customize->add_control( 'htc_logo_width_control',
		array(
			'type' => 'number',
			'description' => __( 'Logo Width (px)', $text_domain ),
			'section' => 'htc_login_screen_section',
			'settings' => 'htc_logo_width_setting',
			'input_attrs' => array(
				'min' => 0,
				'step' => 1,
			),
		)
	);

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'htc_logo_bg_control',
		array(
			'description' => __( 'Site Logo background color', $text_domain ),
			'section' => 'htc_login_screen_section',
			'settings' => 'htc_logo_bg_setting',
		)
	) );

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

	$wp_customize->add_control( 'htc_gbg_post_control',
		array(
			'type' => 'checkbox',
			'label' => __( 'Disable Gutenberg editor', $text_domain ),
			'section' => 'htc_gbg_section',
			'settings' => 'htc_gbg_post_setting',
		)
	);

	// Font Controls
	$wp_customize->add_control( 'htc_themestyles_gl_control',
		array(
			'type' => 'radio',
			'description' => __( 'Disable Jello global styles?', $text_domain ),
			'section' => 'htc_themestyles_gl_section',
			'settings' => 'htc_themestyles_gl_setting',
			'choices' => array(
				'yes' => 'Yes',
				'no' => 'No'
			)
		)
	);

	$wp_customize->add_control( 'htc_themestyles_gf_control',
		array(
			'type' => 'radio',
			'description' => __( 'Disable Gravity Forms styles?', $text_domain ),
			'section' => 'htc_themestyles_gf_section',
			'settings' => 'htc_themestyles_gf_setting',
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

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'htc_font_control_a_default',
		array(
			'description' => __( 'Default link color', $text_domain ),
			'section' => 'htc_font_atag_section',
			'settings' => 'htc_font_setting_a_default',
		)
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'htc_font_control_a_hover',
		array(
			'description' => __( 'Hover link color', $text_domain ),
			'section' => 'htc_font_atag_section',
			'settings' => 'htc_font_setting_a_hover',
		)
	) );

	$wp_customize->add_control( 'htc_font_control_a_decor',
		array(
			'type' => 'select',
			'description' => __( 'Text decoration', $text_domain ),
			'section' => 'htc_font_atag_section',
			'settings' => 'htc_font_setting_a_decor',
			'choices' => array(
				'none' => 'none',
				'underline' => 'underline'
			)
		)
	);
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'htc_button_control_bg_def',
		array(
			'label' => __( 'Background Color', $text_domain ),
			'description' => __( 'Default', $text_domain ),
			'section' => 'htc_button_section',
			'settings' => 'htc_button_setting_bg_def',
		)
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'htc_button_control_bg_hov',
		array(
			'description' => __( 'Hover', $text_domain ),
			'section' => 'htc_button_section',
			'settings' => 'htc_button_setting_bg_hov',
		)
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'htc_button_control_text_def',
		array(
			'label' => __( 'Text Color', $text_domain ),
			'description' => __( 'Default', $text_domain ),
			'section' => 'htc_button_section',
			'settings' => 'htc_button_setting_text_def',
		)
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'htc_button_control_text_hov',
		array(
			'description' => __( 'Hover', $text_domain ),
			'section' => 'htc_button_section',
			'settings' => 'htc_button_setting_text_hov',
		)
	) );

	$wp_customize->add_control( 'htc_button_control_borw',
		array(
			'type' => 'number',
			'label' => __( 'Border', $text_domain ),
			'description' => __( 'Width', $text_domain ),
			'section' => 'htc_button_section',
			'settings' => 'htc_button_setting_borw',
			'input_attrs' => array(
				'min' => 0,
				'step' => 1,
			),
		)
	);

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'htc_button_control_borc_def',
		array(
			'description' => __( 'Color (default)', $text_domain ),
			'section' => 'htc_button_section',
			'settings' => 'htc_button_setting_borc_def',
		)
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'htc_button_control_borc_hov',
		array(
			'description' => __( 'Color (hover)', $text_domain ),
			'section' => 'htc_button_section',
			'settings' => 'htc_button_setting_borc_hov',
		)
	) );

	$wp_customize->add_control( 'htc_button_control_pad',
		array(
			'type' => 'text',
			'label' => __( 'Padding', $text_domain ),
			'section' => 'htc_button_section',
			'settings' => 'htc_button_setting_pad',
		)
	);

	// Header hooks controls
	$wp_customize->add_control( new WP_Customize_Code_Editor_Control( $wp_customize, 'htc_header_box_control_ga',
		array(
			'description' => __( 'Google Analytics code', $text_domain ),
			'section' => 'htc_header_box_ga_section',
			'settings' => 'htc_header_box_setting_ga',
		)
	) );

	$wp_customize->add_control( new WP_Customize_Code_Editor_Control( $wp_customize, 'htc_header_box_control_gtm',
		array(
			'description' => __( 'GTM code', $text_domain ),
			'section' => 'htc_header_box_gtm_section',
			'settings' => 'htc_header_box_setting_gtm',
		)
	) );

	$wp_customize->add_control( new WP_Customize_Code_Editor_Control( $wp_customize, 'htc_header_box_control_gtmn',
		array(
			'description' => __( 'GTM code (noscript)', $text_domain ),
			'section' => 'htc_header_box_gtm_section',
			'settings' => 'htc_header_box_setting_gtmn',
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

	function htc_sanitize_checkbox( $checked ) {
	  return ( ( isset( $checked ) && true == $checked ) ? true : false );
	}
}