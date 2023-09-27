import './hello-admin.scss';
import { render } from '@wordpress/element';
import { MainPage } from './pages/main-page.js';

const App = () => {
	return <MainPage />;
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
