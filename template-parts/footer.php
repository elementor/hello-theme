<?php
/**
 * The template for displaying footer.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$footer_nav_menu = wp_nav_menu( [
	'theme_location' => 'menu-2',
	'fallback_cb' => false,
	'echo' => false,
] );
?>
<footer id="site-footer" class="site-footer" role="contentinfo">
	<?php if ( $footer_nav_menu ) : ?>
		<nav class="site-navigation" role="navigation">
			<?php echo $footer_nav_menu; ?>
		</nav>
	<?php endif; ?>
</footer>
