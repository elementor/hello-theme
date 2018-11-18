<?php
// Front end scripts and styles
// Customizer settings output
if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'wp_head', 'custom_hello_theme_mods_styles' );
function custom_hello_theme_mods_styles() {
	$custom_mods = get_theme_mods();
	$font_family = 'Arial, sans-serif';
	$elementor_content_width = get_option('elementor_container_width');
	$bodybg_color = get_theme_mod('htc_gen_setting_body_color', '#FFFFFF');
	$bodybg_imgmod = get_theme_mod('htc_gen_setting_body_img', '');
	$bodybg_rep = get_theme_mod('htc_gen_setting_body_bgrep', 'no-repeat');
	$bodybg_pos = get_theme_mod('htc_gen_setting_body_bgpos', 'center top');
	$bodybg_size = get_theme_mod('htc_gen_setting_body_bgsize', 'cover');
	$bodybg_img = !empty($bodybg_imgmod) ? 'url('. $bodybg_imgmod .')' : 'none';
	$phead_enable = get_theme_mod('htc_gen_setting_phead_enable', 'yes');
	$phead_enabled = ("yes" == $phead_enable) ? 'display: block;' : '';
	$phead_width = get_theme_mod('htc_gen_setting_phead_width', '100%');
	$phead_pad = get_theme_mod('htc_gen_setting_phead_pad', '20px');
	$pheadbg_color = get_theme_mod('htc_gen_setting_phead_color', '#FFFFFF');
	$pheadbg_imgmod = get_theme_mod('htc_gen_setting_phead_img', '');
	$pheadbg_rep = get_theme_mod('htc_gen_setting_phead_bgrep', 'no-repeat');
	$pheadbg_pos = get_theme_mod('htc_gen_setting_phead_bgpos', 'center top');
	$pheadbg_size = get_theme_mod('htc_gen_setting_phead_bgsize', 'cover');
	$pheadbg_img = !empty($pheadbg_imgmod) ? 'url('. $pheadbg_imgmod .')' : 'none';
	$phead_align = get_theme_mod('htc_gen_setting_phead_align', 'center');
	$phead_fontsize = get_theme_mod('htc_gen_setting_phead_fontsize', '40');
	$phead_fonttype = get_theme_mod('htc_gen_setting_phead_fonttype', 'px');
	$phead_fontfamily_mod = ( get_theme_mod('htc_gen_setting_phead_fontfamily') == "default" ) ? $font_family : get_theme_mod('htc_gen_setting_phead_fontfamily');
	$phead_fontfamily_name = ( !empty($phead_fontfamily_mod) ) ? explode(":", $phead_fontfamily_mod) : $font_family;
	$phead_fontfamily = ( !empty($phead_fontfamily_mod) ) ? $phead_fontfamily_name[0] : $font_family;
	$phead_fontcolor = get_theme_mod('htc_gen_setting_phead_fontcolor', '#444444');

	echo '<style type="text/css">';
	printf( "body{background-color: %s;background-image: %s;background-repeat: %s;background-position: %s;background-size: %s;}\n", $bodybg_color, $bodybg_img, $bodybg_rep, $bodybg_pos, $bodybg_size );
	printf( ".page-header{background-color: %s;background-image: %s;background-repeat: %s;background-position: %s;background-size: %s;width: %s;text-align:%s;%s}\n", $pheadbg_color, $pheadbg_img, $pheadbg_rep, $pheadbg_pos, $pheadbg_size, $phead_width, $phead_align, $phead_enabled );
	printf( ".page-header-inner{max-width: %spx;padding: %s;}\n", $elementor_content_width, $phead_pad );
	printf( ".page-header .entry-title{font-size: %s%s;color: %s;font-family: %s;}\n", $phead_fontsize, $phead_fonttype, $phead_fontcolor, $phead_fontfamily );

	for($i = 1; $i <= 6; $i++) {
		switch ($i) {
			case 1: $fontSizeNumDefault = '40'; break;
			case 2: $fontSizeNumDefault = '32'; break;
			case 3: $fontSizeNumDefault = '24'; break;
			case 4: $fontSizeNumDefault = '20'; break;
			case 5: $fontSizeNumDefault = '18'; break;
			case 6: $fontSizeNumDefault = '16'; break;
		}

		$fontSizeNum = get_theme_mod('htc_font_setting_h'. $i, $fontSizeNumDefault);
		$fontType = get_theme_mod('htc_font_setting_h'. $i .'_type', 'px');
		$fontFamilymod = ( get_theme_mod('htc_font_setting_h'. $i .'_family') == "default" ) ? $font_family : get_theme_mod('htc_font_setting_h'. $i .'_family');
		$fontFamilyName = ( !empty($fontFamilymod) ) ? explode(":", $fontFamilymod) : $font_family;
		$fontFamily = ( !empty($fontFamilymod) ) ? $fontFamilyName[0] : $font_family;
		$fontColor = get_theme_mod('htc_font_setting_h'. $i .'_color', '#000000');
		$fontSize = $fontSizeNum . $fontType;

		printf( "h%s{font-size: %s;color: %s;font-family: %s;}\n", $i, $fontSize, $fontColor, $fontFamily );
	}

	$pfontSize = get_theme_mod('htc_font_setting_p', '14');
	$pfontType = get_theme_mod('htc_font_setting_p_type', 'px');
	$pfontFamilymod = ( get_theme_mod('htc_font_setting_p_family') == "default" ) ? $font_family : get_theme_mod('htc_font_setting_p_family');
	$pfontFamilyName = ( !empty($pfontFamilymod) ) ? explode(":", $pfontFamilymod) : $font_family;
	$pfontFamily = ( !empty($pfontFamilymod) ) ? $pfontFamilyName[0] : $font_family;
	$pfontColor = get_theme_mod('htc_font_setting_p_color', '#444444');

	printf( "body{font-size: %s%s;color: %s;font-family: %s;}\n", $pfontSize, $pfontType, $pfontColor, $pfontFamily );
	printf( ".page-content{max-width: %spx;}\n", $elementor_content_width );
	echo "</style>\n";

	echo $custom_mods['htc_header_box_setting_ga'] . "\n";
	echo $custom_mods['htc_header_box_setting_wmt'] . "\n";
	echo $custom_mods['htc_header_box_setting_extra'] . "\n";
}

add_action( 'wp_footer', 'custom_hello_theme_mods_scripts' );
function custom_hello_theme_mods_scripts() {
	$custom_mods = get_theme_mods();
	$fontsArr = array();
	$googleFontApi = '//fonts.googleapis.com/css';

	for($i = 1; $i <= 6; $i++) {
		$fontGoogleFamily = get_theme_mod('htc_font_setting_h'. $i .'_family');
		if( $fontGoogleFamily && ($fontGoogleFamily != "default") ) {
			if( in_array($fontGoogleFamily, $fontsArr) || $i == 1 ) {
				wp_register_style( 'custom-hello-theme-mods-style', $googleFontApi .'?family='. $fontGoogleFamily );
				wp_enqueue_style( 'custom-hello-theme-mods-style' );
			}
			else{
				wp_enqueue_style( 'custom-hello-theme-mods-style-'. $i, $googleFontApi .'?family='. $fontGoogleFamily );
			}
			$fontsArr[] = $fontGoogleFamily;
		}
	}

	$pfontGoogleFamily = get_theme_mod('htc_font_setting_p_family');
	if( $pfontGoogleFamily && ($pfontGoogleFamily != "default") ) {
		if( ! in_array($pfontGoogleFamily, $fontsArr) ) {
			wp_enqueue_style( 'custom-hello-theme-mods-style-p', $googleFontApi .'?family='. $pfontGoogleFamily );
		}
	}

	$pheadfontGoogleFamily = get_theme_mod('htc_gen_setting_phead_fontfamily');
	if( $pheadfontGoogleFamily && ($pheadfontGoogleFamily != "default") ) {
		if( ! in_array($pheadfontGoogleFamily, $fontsArr) ) {
			wp_enqueue_style( 'custom-hello-theme-mods-style-phead', $googleFontApi .'?family='. $pheadfontGoogleFamily );
		}
	}

	echo $custom_mods['htc_footer_box_setting_fbp'] . "\n";
	echo $custom_mods['htc_footer_box_setting_extra'] . "\n";
	echo "<script type='text/javascript'>" . ( sanitize_text_field($custom_mods['htc_custom_js_setting']) ) . "</script>\n";
}