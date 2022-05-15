<?php
/**
 * The template for displaying singular post-types: posts, pages and user-defined custom post types.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<?php
while ( have_posts() ) :
	the_post();
	?>

<main id="content" <?php post_class( 'site-main' ); ?> role="main">
	<?php if ( apply_filters( 'hello_elementor_page_title', true ) ) : ?>
	
	<?php
	if ( function_exists('yoast_breadcrumb') && ! is_front_page() && ! is_page('sobre') ) {
		yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
	}
	?>
	<header class="page-header">
		<?php if ( ! is_page( array ('sobre', 'descontos') ) ) {
	            the_title( '<h1 class="entry-title">', '</h1>' );
                }
		?>
	</header>
	<?php endif; ?>
	<div class="page-content">
		<?php if( has_post_thumbnail() ): echo get_the_post_thumbnail(); endif; ?>
		<?php the_content(); ?>
		<div class="post-tags">
			<?php the_tags( '<span class="tag-links">' . __( 'Tagged ', 'hello-elementor' ), null, '</span>' ); ?>
		</div>
		<?php wp_link_pages(); ?>
	</div>

	<?php comments_template(); ?>
	
	<?php
	if ( function_exists('yoast_breadcrumb') && is_page('sobre') ) {
		yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
	}
	?>
</main>

	<?php
endwhile;


