<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$gtm_code = get_theme_mod( 'htc_header_box_setting_gtm' );
$gtmn_code = get_theme_mod( 'htc_header_box_setting_gtmn' );
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php echo ( !empty($gtm_code) ) ? $gtm_code : ''; ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php echo ( !empty($gtmn_code) ) ? $gtmn_code : '';

htc_body_open_hook(); //wp_body_open hook

if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) {
	get_template_part( 'template-parts/header' );
}
