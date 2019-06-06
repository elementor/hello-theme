<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$site_name = get_bloginfo( 'name' );
$tagline = get_bloginfo( 'description', 'display' );
?>
<header id="site-header" class="site-header" role="banner">

	<div id="logo">
		<?php if ( has_custom_logo() ) {
			the_custom_logo();
		} elseif ( $site_name ) { ?>
		<h1 class="site-title">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr_e( 'Home', 'hello-elementor' ); ?>" rel="home">
				<?php echo $site_name; ?>
			</a>
		</h1>
		<?php } ?>
		<div id="tagline">
			<?php if ( $tagline ) {
				echo $tagline;
			} ?>
		</div>
	</div>
	<nav id="top-menu" role="navigation">
		<?php wp_nav_menu( array( 'theme_location' => 'menu-1' ) ); ?>
	</nav>

</header>
