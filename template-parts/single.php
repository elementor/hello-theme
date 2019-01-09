<?php
/**
 * The template for displaying singular post-types: posts, pages and user-defined custom post types.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<?php while ( have_posts() ) : the_post(); ?>

<main id="main" class="site-main <?php post_class(); ?>" role="main">

	<header class="page-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header>

	<div class="page-content">
		<?php the_content(); ?>
		<div class="post-tags">
			<?php the_tags( '<span class="tag-links">' . __( 'Tagged ', 'elementor-hello-theme' ), null, '</span>' ); ?>
		</div>
	</div>

	<?php comments_template(); ?>
</main>

<?php endwhile;
