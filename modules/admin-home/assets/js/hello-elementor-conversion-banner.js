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
        const { beforeWrap = false } = window.ehe_cb;
        const { selector, before = false } = window.ehe_cb.data;
		const headerEnd = document.querySelector( selector );

		if ( headerEnd ) {
			if ( beforeWrap ) {
				const wrapElement = document.querySelector( '.wrap' );
				if ( wrapElement ) {
					wrapElement.insertAdjacentElement( 'beforebegin', container );
				}
			} else if ( before ) {
                headerEnd.insertAdjacentElement( 'beforebegin', container );
            } else {
                headerEnd.insertAdjacentElement( 'afterend', container );
            }
		}

		const root = createRoot( container );
		root.render( <App /> );
	}
} );

