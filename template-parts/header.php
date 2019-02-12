<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<header id="site-header" class="site-header" role="banner">

	<div id="logo">
		<?php the_custom_logo(); ?>
	</div>

	<?php if ( is_front_page() && is_home() ) : ?>
		<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr_e( 'Home', 'hello-elementor' ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
	<?php else : ?>
		<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr_e( 'Home', 'hello-elementor' ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
	<?php endif; ?>

	<nav id="top-menu" role="navigation">
		<?php wp_nav_menu( array( 'theme_location' => 'menu-1' ) ); ?>
	</nav>

</header>
