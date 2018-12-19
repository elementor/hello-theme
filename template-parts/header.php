<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<header id="site-header" class="site-header" role="banner">

	<div id="logo">
		<?php the_custom_logo(); ?>
	</div>

	<h1 class="site-title">
		<a href="<?php echo esc_attr( home_url( '/' ) ); ?>" title="<?php echo esc_attr( __( 'Home', 'elementor-hello-theme' ) ); ?>" rel="home">
			<?php echo esc_html( get_bloginfo( 'name' ) ); ?>
		</a>
	</h1>

	<nav id="top-menu" role="navigation">
		<?php wp_nav_menu(); ?>
	</nav>

</header>
