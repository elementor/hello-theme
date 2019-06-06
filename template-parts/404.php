<?php
/**
 * The template for displaying 404 pages (not found).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<main class="site-main" role="main">

	<header class="page-header">
		<?php if ( apply_filters( 'hello_elementor_page_title', true ) ) : ?>
		<h1 class="entry-title"><?php esc_html_e( 'The page can&rsquo;t be found.', 'hello-elementor' ); ?></h1>
		<?php endif; ?>
	</header>

	<div class="page-content">
		<p><?php esc_html_e( 'It looks like nothing was found at this location.', 'hello-elementor' ); ?></p>
	</div>

</main>
