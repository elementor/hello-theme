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
	<div class="wp-block-columns">
		<div class="wp-block-column de-lugar-nenhum-posts" style="flex-basis:66.66%">
			<header class="page-header">
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
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
		</div>
		<div class="wp-block-column" style="flex-basis:33.33%">
			<h2 class="has-text-align-left home-page" id="h-navegue">Navegue</h2>
		</div>
	</div>
	<?php comments_template(); ?>
	<h2 class="has-text-align-center de-lugar-nenhum-posts">Posts Relacionados</h2>
	<?php
	$query = get_max_related_posts();
	if ( $query ) {
		while ( $query->have_posts() ) {
			$query->the_post(); ?>
	        <h3>
				<a href=<?php the_permalink(); ?>><?php the_title();?></a>
			</h3>
		    <?php the_post_thumbnail(); ?>
	        <?php the_excerpt(); ?>
	<?php
	    } wp_reset_postdata();
	}
	?>
</main>

	<?php
endwhile;

