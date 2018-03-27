<main id="main" class="site-main" role="main">

	<header class="page-header">
		<h1 class="entry-title"><?php the_archive_title(); ?></h1>
	</header>

	<div class="page-content">
		<?php
		while ( have_posts() ) : the_post();
			the_title();			
			the_post_thumbnail();
			the_excerpt();
		endwhile;
		?>
	</div>

</main>