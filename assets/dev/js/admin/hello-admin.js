import './hello-admin.scss';
import { render } from '@wordpress/element';
import { SettingsPage } from './pages/settings-page.js';

const App = () => {
	return <SettingsPage />;
};

document.addEventListener( 'DOMContentLoaded', () => {
	const rootElement = document.getElementById( 'hello-elementor-settings' );

	if ( rootElement ) {
		render(
			<App />,
			rootElement,
		);
	}
} );
