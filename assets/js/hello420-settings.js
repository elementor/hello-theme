/**
 * Hello 420 – Settings UI (minimal, no build step)
 */
( function ( wp ) {
	if ( ! wp || ! wp.element ) {
		return;
	}

	const el = wp.element.createElement;
	const { useEffect, useState } = wp.element;
	const { render } = wp.element;

	const root = document.getElementById( 'hello420-admin-settings' );
	if ( ! root ) return;

	function api( path, options = {} ) {
		if ( wp.apiFetch ) {
			return wp.apiFetch( { path, ...options } );
		}

		const url = window.HELLO420.restUrl.replace( /\/$/, '' ) + path;
		return fetch( url, {
			method: options.method || 'GET',
			credentials: 'same-origin',
			headers: {
				'Content-Type': 'application/json',
				'X-WP-Nonce': window.HELLO420.nonce,
			},
			body: options.data ? JSON.stringify( options.data ) : undefined,
		} ).then( ( r ) => r.json() );
	}

	function ToggleRow( { label, value, onChange } ) {
		return el(
			'label',
			{ style: { display: 'flex', alignItems: 'center', justifyContent: 'space-between', gap: '12px', padding: '10px 0', borderBottom: '1px solid #f0f0f1' } },
			el( 'span', null, label ),
			el( 'input', { type: 'checkbox', checked: !! value, onChange: ( e ) => onChange( e.target.checked ) } )
		);
	}

	function Settings() {
		const [ state, setState ] = useState( { loading: true, error: null, saving: false, settings: {} } );

		useEffect( () => {
			api( '/hello420/v1/theme-settings' )
				.then( ( res ) => setState( ( s ) => ( { ...s, loading: false, settings: res?.settings || {} } ) ) )
				.catch( ( e ) => setState( ( s ) => ( { ...s, loading: false, error: e?.message || String( e ) } ) ) );
		}, [] );

		function setSetting( key, value ) {
			setState( ( s ) => ( { ...s, settings: { ...s.settings, [ key ]: value } } ) );
		}

		function save() {
			setState( ( s ) => ( { ...s, saving: true, error: null } ) );
			api( '/hello420/v1/theme-settings', { method: 'POST', data: { settings: state.settings } } )
				.then( () => setState( ( s ) => ( { ...s, saving: false } ) ) )
				.catch( ( e ) => setState( ( s ) => ( { ...s, saving: false, error: e?.message || String( e ) } ) ) );
		}

		if ( state.loading ) {
			return el( 'p', null, 'Loading…' );
		}

		return el(
			'div',
			{ style: { maxWidth: '780px', marginTop: '18px' } },
			el( 'h1', null, 'Hello 420 Settings' ),
			state.error ? el( 'p', { style: { color: '#b32d2e' } }, state.error ) : null,
			el( 'div', { style: { border: '1px solid #dcdcde', borderRadius: '8px', padding: '14px', background: '#fff' } },
				el( ToggleRow, { label: 'Disable description meta tag', value: state.settings.description_meta_tag, onChange: ( v ) => setSetting( 'description_meta_tag', v ) } ),
				el( ToggleRow, { label: 'Disable skip link', value: state.settings.skip_link, onChange: ( v ) => setSetting( 'skip_link', v ) } ),
				el( ToggleRow, { label: 'Disable header & footer', value: state.settings.header_footer, onChange: ( v ) => setSetting( 'header_footer', v ) } ),
				el( ToggleRow, { label: 'Disable page title', value: state.settings.page_title, onChange: ( v ) => setSetting( 'page_title', v ) } ),
				el( ToggleRow, { label: 'Disable reset.css', value: state.settings.hello_style, onChange: ( v ) => setSetting( 'hello_style', v ) } ),
				el( ToggleRow, { label: 'Disable theme.css', value: state.settings.hello_theme, onChange: ( v ) => setSetting( 'hello_theme', v ) } )
			),
			el( 'p', null,
				el( 'button', { className: 'button button-primary', onClick: save, disabled: state.saving }, state.saving ? 'Saving…' : 'Save changes' )
			)
		);
	}

	render( el( Settings ), root );
} )( window.wp );
