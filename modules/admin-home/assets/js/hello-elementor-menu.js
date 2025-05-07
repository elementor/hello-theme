document.addEventListener( 'DOMContentLoaded', () => {
	const links = document.querySelectorAll( 'a[href="admin.php?page=hello-elementor-ai-site-planner"], a[href="admin.php?page=hello-elementor-theme-builder"]' );
	links.forEach( ( link ) => {
		link.setAttribute( 'target', '_blank' );
	} );
} );

