import { createRoot } from 'react-dom/client';
import { ThemeProvider } from '@elementor/ui/styles';
import { Welcome } from './components/paper/welcome';
import { AdminProvider } from './providers/admin-provider';
import Box from '@elementor/ui/Box';

const App = () => {
	return (
		<ThemeProvider colorScheme="auto">
			<AdminProvider>
				<Box sx={ { pt: 2, pr: 2, pb: 1 } }>
					<Welcome sx={ { width: '100%', px: 4, py: 3, position: 'relative' } } dismissable />
				</Box>
			</AdminProvider>
		</ThemeProvider>
	);
};

document.addEventListener( 'DOMContentLoaded', () => {
	const container = document.getElementById( 'ehe-admin-cb' );

	if ( container ) {
		let headerEnd = document.querySelector( '.wp-header-end' );

		if ( ! headerEnd ) {
			headerEnd = document.querySelector( '.wrap h1, .wrap h2' );
		}

		if ( headerEnd ) {
			if ( window.ehe_cb.beforeWrap ) {
				const wrapElement = document.querySelector( '.wrap' );
				if ( wrapElement ) {
					wrapElement.insertAdjacentElement( 'beforebegin', container );
				}
			} else {
				headerEnd.insertAdjacentElement( 'afterend', container );
			}
		}

		const root = createRoot( container );
		root.render( <App /> );
	}
} );

