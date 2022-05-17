<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<main id="content" class="site-main" role="main">
	<?php if ( apply_filters( 'hello_elementor_page_title', true ) ) : ?>
		<header class="page-header">
			<h1 class="entry-title de-lugar-nenhum-404"> <?php echo("Oops! "); esc_html_e( 'The page can&rsquo;t be found.', 'hello-elementor' ); echo(".")?></h1>
		</header>
	<?php endif; ?>
	<div class="page-content">
		<p><?php echo( "Parece que a página que você está buscando não existe ou foi removida." ) ?></p>
		<p><?php echo( "Você pode buscar por outro destino abaixo: ");?></p>
		<?php get_search_form(); ?>
		<br />
		<p><?php echo( "Ou, se preferir, ler algum de nossos posts recentes:" ); ?></p>
		<h2 class="de-lugar-nenhum-posts-404">Posts Recentes</h2>
		<ul class="wp-block-latest-posts__list is-grid columns-4 has-dates aligncenter recent-posts-404 wp-block-latest-posts">
			<?php $posts = get_posts( 'orderby=date&numberposts=4'); 
		foreach($posts as $post) { ?>
			<li>		
				<div class="wp-block-latest-posts__featured-image aligncenter">
					<a href=<?php the_permalink();?>><?php the_post_thumbnail(); ?></a>
				</div>
				<h3 class="posts-related-content">
					<a href=<?php the_permalink(); ?>><?php the_title();?></a>	
				</h3>
				<div class="wp-block-latest-posts__post-excerpt"><?php the_excerpt(); ?></div>
				<?php
								 }
			wp_reset_postdata(); ?>
		</li>
	</ul>
	</div>
	<h2 class="de-lugar-nenhum-posts" id="h-fique-por-dentro">Fique por dentro</h2>
	<p>Inscreva-se na nossa newsletter e receba sempre em seu e-mail todas as novidades, promoções e dicas.<br>Basta digitar seu e-mail no campo abaixo e pronto!
	</p>
	<?php echo do_shortcode( '[mc4wp_form id="1458"]' ); ?>
	<p>© 2022 De Lugar Nenhum. Todos os direitos reservados.</p>
</main>
