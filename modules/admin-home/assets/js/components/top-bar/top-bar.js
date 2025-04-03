import AppBar from '@elementor/ui/AppBar';
import { TopBarContent } from './top-bar-content';

export const TopBar = () => {
	return (
		<AppBar position="absolute" sx={ { width: 'calc(100% - 160px)', top: 0, right: 0, height: 50, minHeight: 50, backgroundColor: 'background.default' } }>
			<TopBarContent />
		</AppBar>
	);
};
