/**
 * Hello 420 – Admin top bar (minimal, no build step)
 */
( function ( wp ) {
	if ( ! wp || ! wp.element ) {
		return;
	}

	const el = wp.element.createElement;
	const { render } = wp.element;
	const root = document.getElementById( 'hello420-admin-top-bar-root' );
	if ( ! root ) return;

	function TopBar() {
		return el(
			'div',
			{ style: { display: 'flex', alignItems: 'center', justifyContent: 'space-between', gap: '12px', padding: '10px 12px' } },
			el( 'strong', null, 'Hello 420' ),
			el(
				'div',
				{ style: { display: 'flex', gap: '10px', alignItems: 'center' } },
				el( 'a', { href: window.HELLO420?.adminUrl + 'admin.php?page=hello420' }, 'Home' ),
				el( 'a', { href: window.HELLO420?.adminUrl + 'admin.php?page=hello420-settings' }, 'Settings' )
			)
		);
	}

	render( el( TopBar ), root );
} )( window.wp );
