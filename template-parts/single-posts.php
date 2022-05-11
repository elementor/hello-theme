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
				<?php the_title( '<h1 class="entry-title de-lugar-nenhum-posts">', '</h1>' ); ?>
	        </header>
			<?php endif; ?>
	    <div class="page-content">
			<div class="post-meta-description">
				<ul>
					<li>
						<a href="https://delugarnenhum.com/sobre/" target= "_blank"><?php
							$author = get_the_author_meta('display_name', $author_id);
							echo ( "Escrito por " . $author );?></a>
					</li>
					<li>
						<a href="<?php $current_url = home_url();
								 echo ( $current_url ); ?>"target="_blank">
							<?php
							$published_date = wp_date( 'd/m/Y', date ( get_the_date('U') ) );
							echo ( "em " . $published_date );
							?>
						</a>
					</li>
					<?php
					$custom_content = get_the_modified_date('U');
					if ( date('Ymd', $custom_content) > date('Ymd', get_the_date('U')) ) { 
						$value = "Atualizado em " . wp_date( 'd/m/Y', $custom_content);
					} else {
						$value = false;
					}
					if ( $value ) { ?>
					<li>	
						<a href="<?php
								   $current_url = home_url();
								   echo ( $current_url ); ?>";
						   target="_blank"><?php echo ( $value ); ?>
						</a>
					</li>
					<?php }  ?>
				</ul>
			</div>
			<?php if( has_post_thumbnail() ): echo get_the_post_thumbnail(); endif; ?>
			<?php the_content(); ?>
			<div class="post-tags">
				<?php the_tags( '<span class="tag-links">' . __( 'Tagged ', 'hello-elementor' ), null, '</span>' ); ?>
			</div>
			<?php wp_link_pages(); ?>
			</div>
			<?php comments_template(); ?>
		</div>
		<div class="wp-block-column" style="flex-basis:33.33%">
			<h2 class="has-text-align-left home-page" id="h-navegue">Navegue</h2>
		</div>
	</div>
	<h2 class="has-text-align-center de-lugar-nenhum-posts">Posts Relacionados</h2>
	<ul class="wp-block-latest-posts__list is-grid columns-4 has-dates aligncenter recent-posts-home wp-block-latest-posts">
		<?php
		$query = get_max_related_posts();
		if ( $query ) {
			while ( $query->have_posts() ) {
				$query->the_post(); ?>
		<li>		
			<div class="wp-block-latest-posts__featured-image aligncenter">
				<a href=<?php the_permalink();?>><?php the_post_thumbnail(); ?></a>
			</div>
			<h3 class="posts-related-content">
				<a href=<?php the_permalink(); ?>><?php the_title();?></a>	
			</h3>
			<div class="wp-block-latest-posts__post-excerpt"><?php the_excerpt(); ?></div>
	<?php
	    } wp_reset_postdata();
	}
	?>
		</li>
	</ul>
	<div class="wp-container-4 wp-block-buttons" style="display: flex;
														gap: 0.5em;
														flex-wrap: wrap;
														align-items: center;
														align-items: center;
														justify-content: center;">
		<div class="wp-block-button"><a class="wp-block-button__link has-background"
										href="https://qa.delugarnenhum.com/categoria/viagens/"
										style="border-radius:4px;background-color:#ea3974"
										target="_blank" rel="noreferrer noopener">Mais Dicas de Viagem
			</a>
		</div>
	</div>
	<br />
	<h2 class="has-text-align-center de-lugar-nenhum-posts" id="h-fique-por-dentro">Fique por dentro</h2>
	<p>Inscreva-se na nossa newsletter e receba sempre em seu e-mail todas as novidades, promoções e dicas.<br>Basta digitar seu e-mail no campo abaixo e pronto!
	</p>
	<?php echo do_shortcode( '[mc4wp_form id="1458"]' ); ?>
	<p>© 2022 De Lugar Nenhum. Todos os direitos reservados.</p>
</main>

	<?php
endwhile;

