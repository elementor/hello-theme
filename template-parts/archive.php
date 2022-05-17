<?php
/**
 * The template for displaying archive pages.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<main id="content" class="site-main" role="main">

	<?php if ( apply_filters( 'hello_elementor_page_title', true ) ) : ?>
	<?php
	if ( function_exists('yoast_breadcrumb') ) {
		yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
	}
	?>
	<header class="page-header">
		<?php
		the_archive_title( '<h1 class="entry-title archive-title">', '</h1>' );
		the_archive_description( '<p class="archive-description">', '</p>' );
		?>
	</header>
	<?php endif; ?>
	<div class="page-content">
		<ul class="wp-block-latest-posts__list is-grid columns-3 has-dates aligncenter wp-block-latest-posts">
		<?php
			global $wp;
			$s_array = array( 'posts_per_page' => 6 ); 
			$new_query = array_merge( $s_array, (array) $wp->query_vars );
			$the_query = new WP_Query( $new_query );
			while ( $the_query -> have_posts() ) {
				$the_query -> the_post();
				$post_link = get_permalink();
			?>
			<li>	
			<article class="post">
				<div class="post-card-de-lugar-nenhum">
				<?php printf( '<a class="post__thumbmail" href="%s">%s</a>', esc_url( $post_link ), get_the_post_thumbnail( $post, 'large' ) );?>
					<div class="post__badge">
						<?php get_first_category_of_a_post () ?>
					</div>
					<div class="post__text">
						<?php printf( '<h2 class="%s"><a href="%s">%s</a></h2>', 'entry-title', esc_url( $post_link ), esc_html( get_the_title() ) );
				the_excerpt(); ?>
					</div>
					<div class="post__meta-data">
						<span class="post__date"><?php $published_date = wp_date( 'd/m/Y', date ( get_the_date('U') ) ); echo ( $published_date );?></span>
						<span class="post__comments"><?php total_comments_number () ?></span>
					</div>
				</div>
				</article>
			</li>
		<?php } ?>
			</ul>
	</div>

	<?php wp_link_pages(); ?>

	<?php
	global $wp_query;
	if ( $wp_query->max_num_pages > 1 ) :
		?>
		<nav class="pagination" role="navigation">
			<?php /* Translators: HTML arrow */ ?>
			<?php  if ( function_exists( 'numeric_posts_nav' ) ) { numeric_posts_nav(); } ?>
		</nav>
	<?php endif; ?>
	<h2 class="has-text-align-center de-lugar-nenhum-posts" id="h-fique-por-dentro">Fique por dentro</h2>
	<p>Inscreva-se na nossa newsletter e receba sempre em seu e-mail todas as novidades, promoções e dicas.<br>Basta digitar seu e-mail no campo abaixo e pronto!
	</p>
	<?php echo do_shortcode( '[mc4wp_form id="1458"]' ); ?>
	<p>© 2022 De Lugar Nenhum. Todos os direitos reservados.</p>
</main>
