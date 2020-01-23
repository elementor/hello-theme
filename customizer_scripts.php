<?php
// Front end scripts and styles
// Customizer settings output
if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'wp_head', 'custom_hello_theme_mods_styles' );
function custom_hello_theme_mods_styles() {
	$custom_mods = get_theme_mods();
	$font_family = 'Arial, sans-serif';
	$page_content_width = get_theme_mod('htc_gen_setting_content_width', '1140px');
	$bodybg_color = get_theme_mod('htc_gen_setting_body_color', '#FFFFFF');
	$bodybg_imgmod = get_theme_mod('htc_gen_setting_body_img', '');
	$bodybg_rep = get_theme_mod('htc_gen_setting_body_bgrep', 'no-repeat');
	$bodybg_pos = get_theme_mod('htc_gen_setting_body_bgpos', 'center top');
	$bodybg_size = get_theme_mod('htc_gen_setting_body_bgsize', 'cover');
	$bodybg_img = !empty($bodybg_imgmod) ? 'url('. $bodybg_imgmod .')' : 'none';
	$line_height = get_theme_mod('htc_gen_setting_line_height', '1.5em');
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
	$phead_fontfamily_mod = ( get_theme_mod('htc_gen_setting_phead_fontfamily') == "default" ) ? 'inherit' : get_theme_mod('htc_gen_setting_phead_fontfamily');
	$phead_fontfamily_name = ( !empty($phead_fontfamily_mod) ) ? explode(":", $phead_fontfamily_mod) : 'inherit';
	$phead_fontfamily = ( !empty($phead_fontfamily_mod) ) ? $phead_fontfamily_name[0] : 'inherit';
	$phead_fontcolor = get_theme_mod('htc_gen_setting_phead_fontcolor', '#444444');
	$a_default = get_theme_mod('htc_font_setting_a_default', '#333333');
	$a_hover = get_theme_mod('htc_font_setting_a_hover', '#888888');
	$a_decor = get_theme_mod('htc_font_setting_a_decor', 'none');
	$button_bg = get_theme_mod('htc_button_setting_bg_def', '#444444');
	$button_bg_hover = get_theme_mod('htc_button_setting_bg_hov', '#222222');
	$button_text = get_theme_mod('htc_button_setting_text_def', '#FFFFFF');
	$button_text_hover = get_theme_mod('htc_button_setting_text_hov', '#FFFFFF');
	$button_borw = get_theme_mod('htc_button_setting_borw', '1');
	$button_borc = get_theme_mod('htc_button_setting_borc_def', '#444444');
	$button_borc_hover = get_theme_mod('htc_button_setting_borc_hov', '#222222');
	$button_pad = get_theme_mod('htc_button_setting_pad', '10px');
	$gform_bg = get_theme_mod('htc_gen_setting_gform_bg', 'none');
	$gform_pad = get_theme_mod('htc_gen_setting_gform_padding', '0');
	$gform_mar = get_theme_mod('htc_gen_setting_gform_margin', '0');
	$gform_bor = get_theme_mod('htc_gen_setting_gform_border', '0');
	$gform_fontsize = get_theme_mod('htc_gen_setting_gform_fsize', '16px');
	$gform_fontfamily_mod = ( get_theme_mod('htc_gen_setting_gform_ffamily') == "default" ) ? 'inherit' : get_theme_mod('htc_gen_setting_gform_ffamily');
	$gform_fontfamily_name = ( !empty($gform_fontfamily_mod) ) ? explode(":", $gform_fontfamily_mod) : 'inherit';
	$gform_fontfamily = ( !empty($gform_fontfamily_mod) ) ? $gform_fontfamily_name[0] : 'inherit';
	$gform_label_color = get_theme_mod('htc_gen_setting_gform_lcolor', '#444444');
	$gform_field_color = get_theme_mod('htc_gen_setting_gform_fcolor', '#444444');
	$gform_placeholder_color = get_theme_mod('htc_gen_setting_gform_pcolor', '#888888');
	$gform_text_bg = get_theme_mod('htc_gen_setting_gform_text_bg', '#FFFFFF');
	$gform_text_pad = get_theme_mod('htc_gen_setting_gform_text_pad', '5px');
	$gform_text_mar = get_theme_mod('htc_gen_setting_gform_text_mar', '5px 0px');
	$gform_text_bor = get_theme_mod('htc_gen_setting_gform_text_bor', '1px solid #555555');
	$gform_sel_bg = get_theme_mod('htc_gen_setting_gform_sel_bg', '#FFFFFF');
	$gform_sel_pad = get_theme_mod('htc_gen_setting_gform_sel_pad', '5px');
	$gform_sel_mar = get_theme_mod('htc_gen_setting_gform_sel_mar', '5px 0px');
	$gform_sel_bor = get_theme_mod('htc_gen_setting_gform_sel_bor', '1px solid #555555');
	$gform_texta_bg = get_theme_mod('htc_gen_setting_gform_texta_bg', '#FFFFFF');
	$gform_texta_pad = get_theme_mod('htc_gen_setting_gform_texta_pad', '5px');
	$gform_texta_mar = get_theme_mod('htc_gen_setting_gform_texta_mar', '5px 0px');
	$gform_texta_bor = get_theme_mod('htc_gen_setting_gform_texta_bor', '1px solid #555555');
	$gform_texta_hei = get_theme_mod('htc_gen_setting_gform_texta_hei', '150px');
	$gform_but_bg = get_theme_mod('htc_gen_setting_gform_but_bg', '#555555');
	$gform_but_color = get_theme_mod('htc_gen_setting_gform_but_color', '#FFFFFF');
	$gform_but_fsize = get_theme_mod('htc_gen_setting_gform_but_fsize', '15px');
	$gform_but_pad = get_theme_mod('htc_gen_setting_gform_but_pad', '10px');
	$gform_but_mar = get_theme_mod('htc_gen_setting_gform_but_mar', '0');
	$gform_but_bor = get_theme_mod('htc_gen_setting_gform_but_bor', '1px solid #555555');
	$gform_but_borr = get_theme_mod('htc_gen_setting_gform_but_borr', '5px');
	$gform_but_ali = get_theme_mod('htc_gen_setting_gform_but_ali', 'left');

	echo '<style type="text/css">';
	printf( "body{background-color: %s;background-image: %s;background-repeat: %s;background-position: %s;background-size: %s;line-height: %s;}\n", $bodybg_color, $bodybg_img, $bodybg_rep, $bodybg_pos, $bodybg_size, $line_height );
	printf( "a, .elementor-text-editor a{color: %s; text-decoration: %s;}\n", $a_default, $a_decor );
	printf( "a:hover, .elementor-text-editor a:hover{color: %s;}\n", $a_hover );
	printf( ".button, button, input[type=button]{background-color: %s;color: %s;border-width: %spx;border-color: %s;border-style: solid;padding: %s;}\n", $button_bg, $button_text, $button_borw, $button_borc, $button_pad );
	printf( ".button:hover, button:hover, input[type=button]:hover{background-color: %s;color: %s;border-width: %spx;border-color: %s;border-style: solid;padding: %s;}\n", $button_bg_hover, $button_text_hover, $button_borw, $button_borc_hover, $button_pad );
	printf( ".page-header{background-color: %s;background-image: %s;background-repeat: %s;background-position: %s;background-size: %s;width: %s;text-align:%s;%s}\n", $pheadbg_color, $pheadbg_img, $pheadbg_rep, $pheadbg_pos, $pheadbg_size, $phead_width, $phead_align, $phead_enabled );
	printf( ".page-header-inner{max-width: %s;padding: %s;}\n", $page_content_width, $phead_pad );
	printf( ".page-header .entry-title{font-size: %s%s;color: %s;font-family: \"%s\";}\n", $phead_fontsize, $phead_fonttype, $phead_fontcolor, $phead_fontfamily );

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

		printf( "h%s{font-size: %s;color: %s;font-family: \"%s\";}\n", $i, $fontSize, $fontColor, $fontFamily );
	}

	$pfontSize = get_theme_mod('htc_font_setting_p', '14');
	$pfontType = get_theme_mod('htc_font_setting_p_type', 'px');
	$pfontFamilymod = ( get_theme_mod('htc_font_setting_p_family') == "default" ) ? $font_family : get_theme_mod('htc_font_setting_p_family');
	$pfontFamilyName = ( !empty($pfontFamilymod) ) ? explode(":", $pfontFamilymod) : $font_family;
	$pfontFamily = ( !empty($pfontFamilymod) ) ? $pfontFamilyName[0] : $font_family;
	$pfontColor = get_theme_mod('htc_font_setting_p_color', '#444444');

	printf( "body{font-size: %s%s;color: %s;font-family: \"%s\";}\n", $pfontSize, $pfontType, $pfontColor, $pfontFamily );
	printf( ".page-content{max-width: %s;}\n", $page_content_width );
	printf( "div.gform_wrapper form{background: %s;padding: %s;margin: %s;border: %s;color: %s;font-family: \"%s\";font-size: %s;}\n", $gform_bg, $gform_pad, $gform_mar, $gform_bor, $gform_field_color, $gform_fontfamily, $gform_fontsize );
	printf( ".gform_wrapper form ::placeholder{color: %s;}\n", $gform_placeholder_color );
	printf( ".gform_wrapper form ::-webkit-input-placeholder{color: %s;}\n", $gform_placeholder_color );
	printf( ".gform_wrapper form ::-moz-placeholder{color: %s;}\n", $gform_placeholder_color );
	printf( ".gform_wrapper form :-ms-input-placeholder{color: %s;}\n", $gform_placeholder_color );
	printf( ".gform_wrapper form .gform_body .gform_fields .gfield label.gfield_label{color: %s;}\n", $gform_label_color );
	printf( ".gform_wrapper form .gform_body .gform_fields .gfield input[type=text], .gform_wrapper form .gform_body .gform_fields .gfield input[type=email], .gform_wrapper form .gform_body .gform_fields .gfield input[type=number]{background: %s;padding: %s !important;margin: %s;border: %s;color: %s;}\n", $gform_text_bg, $gform_text_pad, $gform_text_mar, $gform_text_bor, $gform_field_color );
	printf( ".gform_wrapper form .gform_body .gform_fields .gfield select{background: %s;padding: %s !important;margin: %s;border: %s;color: %s;}\n", $gform_sel_bg, $gform_sel_pad, $gform_sel_mar, $gform_sel_bor, $gform_field_color );
	printf( ".gform_wrapper form .gform_body .gform_fields .gfield textarea{background: %s;padding: %s !important;margin: %s;border: %s;color: %s;height: %s;}\n", $gform_texta_bg, $gform_texta_pad, $gform_texta_mar, $gform_texta_bor, $gform_field_color, $gform_texta_hei );
	printf( ".gform_wrapper form .gform_footer{text-align: %s;margin: %s;}", $gform_but_ali, $gform_but_mar );
	printf( "div.gform_wrapper form .gform_footer .gform_button{background: %s;border: %s;border-radius: %s;padding: %s;margin: %s;color: %s;font-size: %s;}", $gform_but_bg, $gform_but_bor, $gform_but_borr, $gform_but_pad, $gform_but_mar, $gform_but_color, $gform_but_fsize );
	echo "</style>\n";

	echo ( !empty($custom_mods['htc_header_box_setting_ga']) ) ? $custom_mods['htc_header_box_setting_ga'] . "\n" : "";
	echo ( !empty($custom_mods['htc_header_box_setting_wmt']) ) ? $custom_mods['htc_header_box_setting_wmt'] . "\n" : "";
	echo ( !empty($custom_mods['htc_header_box_setting_extra']) ) ? $custom_mods['htc_header_box_setting_extra'] . "\n" : "";
}

add_action( 'wp_footer', 'custom_hello_theme_mods_fonts' );
function custom_hello_theme_mods_fonts() {
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

	$gformfontGoogleFamily = get_theme_mod('htc_gen_setting_gform_ffamily');
	if( $gformfontGoogleFamily && ($gformfontGoogleFamily != "default") ) {
		if( ! in_array($gformfontGoogleFamily, $fontsArr) ) {
			wp_enqueue_style( 'custom-hello-theme-mods-style-phead', $googleFontApi .'?family='. $gformfontGoogleFamily );
		}
	}
}

add_action( 'wp_footer', 'custom_hello_theme_mods_scripts', 99 );
function custom_hello_theme_mods_scripts() {
	$custom_mods = get_theme_mods();
	echo ( !empty($custom_mods['htc_footer_box_setting_fbp']) ) ? $custom_mods['htc_footer_box_setting_fbp'] . "\n" : "";
	echo ( !empty($custom_mods['htc_footer_box_setting_extra']) ) ? $custom_mods['htc_footer_box_setting_extra'] . "\n" : "";
	echo ( !empty($custom_mods['htc_custom_js_setting']) ) ? "<script type=\"text/javascript\">\n" . $custom_mods['htc_custom_js_setting'] . "\n</script>\n" : "";
}