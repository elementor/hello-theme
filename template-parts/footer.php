<?php
/**
 * The template for displaying footer.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$is_editor = isset( $_GET['elementor-preview'] );
$site_name = get_bloginfo( 'name' );
$tagline   = get_bloginfo( 'description', 'display' );
$footer_class = did_action( 'elementor/loaded' ) ? esc_attr( hello_get_footer_layout_class() ) : '';
?>
<footer id="site-footer" class="site-footer <?php echo $footer_class; ?>" role="contentinfo">
	<?php if ( did_action( 'elementor/loaded' ) ) : ?>
		<div class="site-branding show-<?php echo hello_elementor_get_setting( 'hello_footer_logo_type' ); ?>">
			<?php if ( has_custom_logo() && ( 'title' !== hello_elementor_get_setting( 'hello_footer_logo_type' ) || $is_editor ) ) : ?>
				<div class="site-logo <?php echo hello_show_or_hide( 'hello_footer_logo_display' ); ?>">
					<?php the_custom_logo(); ?>
				</div>
			<?php endif;

			if ( $site_name && ( 'logo' !== hello_elementor_get_setting( 'hello_footer_logo_type' ) ) || $is_editor ) : ?>
				<h4 class="site-title <?php echo hello_show_or_hide( 'hello_footer_logo_display' ); ?>">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr_e( 'Home', 'hello-elementor' ); ?>" rel="home">
						<?php echo esc_html( $site_name ); ?>
					</a>
				</h4>
			<?php endif;

			if ( $tagline || $is_editor ) : ?>
				<p class="site-description <?php echo hello_show_or_hide( 'hello_footer_tagline_display' ); ?>">
					<?php echo esc_html( $tagline ); ?>
				</p>
			<?php endif; ?>
		</div>

		<?php if ( wp_nav_menu( [ 'theme_location' => 'menu-2', 'fallback_cb' => false, 'echo' => false ] ) ) : ?>
			<nav class="site-navigation <?php echo hello_show_or_hide( 'hello_footer_menu_display' ); ?>" role="navigation">
				<?php wp_nav_menu( [ 'theme_location' => 'menu-2', 'fallback_cb' => false ] ); ?>
			</nav>
		<?php endif; ?>

		<?php if ( '' !== hello_elementor_get_setting( 'hello_footer_copyright_text' ) || $is_editor ) : ?>
			<div class="copyright <?php echo hello_show_or_hide( 'hello_footer_copyright_display' ); ?>">
				<p><?php echo hello_elementor_get_setting( 'hello_footer_copyright_text' ); ?></p>
			</div>
		<?php endif; ?>
	<?php endif; ?>
</footer>
