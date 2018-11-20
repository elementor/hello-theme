<?php
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
	</div>

	<div class="page-comments">
		<?php comments_template(); ?>
	</div>
</main>

<?php endwhile;
