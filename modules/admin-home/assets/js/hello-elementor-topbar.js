import { createRoot } from 'react-dom/client';
import { ThemeProvider } from '@elementor/ui/styles';
import { TopBar } from './components/top-bar/top-bar';

const App = () => {
	return (
		<ThemeProvider colorScheme="auto">
			<TopBar />
		</ThemeProvider>
	);
};

document.addEventListener('DOMContentLoaded', () => {
	const container = document.getElementById('ehe-admin-top-bar-root');

	if (container) {
		const root = createRoot(container);
		root.render(<App />);
	}
});
