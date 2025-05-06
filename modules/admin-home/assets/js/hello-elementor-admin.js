import { createRoot } from 'react-dom/client';
import { AdminProvider } from './providers/admin-provider';
import { AdminPage } from './pages/admin-page';
import Box from '@elementor/ui/Box';
import Container from '@elementor/ui/Container';

const App = () => {
	return (
		<AdminProvider>
			<Box sx={ { pr: 1 } }>
				<Container disableGutters={ true } maxWidth="lg" sx={ { display: 'flex', flexDirection: 'column', pt: { xs: 2, md: 6 }, pb: 2 } }>
					<AdminPage />
				</Container>
			</Box>
		</AdminProvider>
	);
};

document.addEventListener( 'DOMContentLoaded', () => {
	const container = document.getElementById( 'ehe-admin-home' );

	if ( container ) {
		const root = createRoot( container );
		root.render( <App /> );
	}
} );

