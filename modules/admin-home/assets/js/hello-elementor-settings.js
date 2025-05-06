import { createRoot } from 'react-dom/client';
import Container from '@elementor/ui/Container';
import Box from '@elementor/ui/Box';
import { ThemeProvider } from '@elementor/ui/styles';
import { SettingsPage } from './components/settings/settings-page';
import { SettingsProvider } from './components/settings/settings-provider';

const App = () => {
	return (
		<SettingsProvider>
			<ThemeProvider colorScheme="auto">
				<Box sx={ { pr: 1 } }>
					<Container
						disableGutters={ true }
						maxWidth="lg"
						sx={ { display: 'flex', flexDirection: 'row', justifyContent: 'center', pt: { xs: 2, md: 6 }, pb: 2 } }
					>
						<SettingsPage />
					</Container>
				</Box>
			</ThemeProvider>
		</SettingsProvider>
	);
};

document.addEventListener( 'DOMContentLoaded', () => {
	const container = document.getElementById( 'ehe-admin-settings' );

	if ( container ) {
		const root = createRoot( container );
		root.render( <App /> );
	}
} );

