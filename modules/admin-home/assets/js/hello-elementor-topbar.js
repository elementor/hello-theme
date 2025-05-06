import { createRoot } from 'react-dom/client';
import { TopBar } from './components/top-bar/top-bar';

const App = () => {
	return (
		<TopBar />
	);
};

document.addEventListener( 'DOMContentLoaded', () => {
	const container = document.getElementById( 'ehe-admin-top-bar-root' );

	if ( container ) {
		const root = createRoot( container );
		root.render( <App /> );
	}
} );

