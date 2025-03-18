import Box from '@elementor/ui/Box';

import { ThemeProvider } from '@elementor/ui/styles';

import { GridWithActionLinks } from '../layouts/grids/grid-with-action-links';
import Stack from '@elementor/ui/Stack';
import { QuickLinks } from '../components/paper/quick-links';
import { Welcome } from '../components/paper/welcome';
import { SiteParts } from '../components/paper/site-parts';

export const AdminPage = () => {
	return (
		<ThemeProvider colorScheme="auto">
			<Box className="hello_plus__notices" component="div">
			</Box>
			<Box>
				<GridWithActionLinks>
					<Stack direction="column" gap={ 2 }>
						<Welcome />
						<QuickLinks />
						<SiteParts />
					</Stack>
				</GridWithActionLinks>
			</Box>
		</ThemeProvider>
	);
};
