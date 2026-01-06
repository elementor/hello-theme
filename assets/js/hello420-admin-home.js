/**
 * Hello 420 – Admin Home (minimal React-less build)
 */
( function ( wp ) {
	if ( ! wp || ! wp.element ) {
		return;
	}

	const el = wp.element.createElement;
	const { useEffect, useState } = wp.element;
	const { render } = wp.element;

	const root = document.getElementById( 'hello420-admin-home' );
	if ( ! root ) return;

	function fetchJSON( path ) {
		if ( wp.apiFetch ) {
			return wp.apiFetch( { path } );
		}

		return fetch( window.HELLO420.restUrl.replace( /\/$/, '' ) + path, {
			credentials: 'same-origin',
			headers: { 'X-WP-Nonce': window.HELLO420.nonce }
		} ).then( ( r ) => r.json() );
	}

	function Card( props ) {
		return el(
			'div',
			{ style: { border: '1px solid #dcdcde', borderRadius: '8px', padding: '14px', background: '#fff' } },
			props.children
		);
	}

	function LinkList( { items } ) {
		if ( ! Array.isArray( items ) || ! items.length ) return null;
		return el(
			'ul',
			{ style: { margin: 0, paddingLeft: '18px' } },
			items.map( ( item, i ) => el(
				'li',
				{ key: i },
				el( 'a', { href: item.link }, item.title )
			) )
		);
	}

	function Home() {
		const [ state, setState ] = useState( { loading: true, error: null, config: null } );

		useEffect( () => {
			fetchJSON( '/hello420/v1/admin-settings' )
				.then( ( res ) => setState( { loading: false, error: null, config: res?.config || null } ) )
				.catch( ( e ) => setState( { loading: false, error: e?.message || String( e ), config: null } ) );
		}, [] );

		if ( state.loading ) {
			return el( 'p', null, 'Loading…' );
		}

		if ( state.error ) {
			return el( 'p', { style: { color: '#b32d2e' } }, state.error );
		}

		const cfg = state.config || {};
		const quick = cfg.quickLinks ? Object.values( cfg.quickLinks ) : [];
		const parts = cfg.siteParts?.siteParts || [];
		const pages = cfg.siteParts?.sitePages || [];
		const general = cfg.siteParts?.general || [];
		const resources = cfg.resourcesData?.resources || [];

		return el(
			'div',
			{ style: { maxWidth: '1100px', margin: '18px 0' } },
			el( 'h1', null, 'Hello 420' ),
			el( 'p', null, 'Minimal admin home for theme shortcuts (no build step).' ),
			el(
				'div',
				{ style: { display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(260px, 1fr))', gap: '14px' } },
				el( Card, null, el( 'h2', null, 'Quick Links' ), el( LinkList, { items: quick } ) ),
				el( Card, null, el( 'h2', null, 'Site Parts' ), el( LinkList, { items: parts } ) ),
				el( Card, null, el( 'h2', null, 'General' ), el( LinkList, { items: general } ) ),
				el( Card, null, el( 'h2', null, 'Recent Pages' ), el( LinkList, { items: pages } ) ),
				el( Card, null, el( 'h2', null, 'Resources' ), el( LinkList, { items: resources } ) )
			)
		);
	}

	render( el( Home ), root );
} )( window.wp );
