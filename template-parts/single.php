<?php while ( have_posts() ) : the_post(); ?>

<main id="main" class="site-main" role="main">

	<header class="page-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header>

	<div class="page-content">
		<?php the_content(); ?>
	</div>

</main>

<?php endwhile;
