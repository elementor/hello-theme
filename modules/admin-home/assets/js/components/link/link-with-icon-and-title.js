import Stack from '@elementor/ui/Stack';
import Typography from '@elementor/ui/Typography';
import Link from '@elementor/ui/Link';
import { decode } from 'html-entities';
import DynamicIcon from '../dynamic-icon';

export const LinkWithIconAndTitle = ( {
		title,
		link = '#',
		icon = 'SettingsIcon',
		onClick = () => {},
        target = '',
	} ) => {
	return (
		<Stack direction="row" gap={ 1 } sx={ { alignContent: 'flex-start' } }>
			<DynamicIcon componentName={ icon } fontSize="tiny" color="secondary" sx={ { pt: 0.2 } } />
			<Stack direction="column">
				<Typography variant="subtitle1" color="text.primary" sx={ { fontWeight: 400 } }>
					<Link color="inherit" underline="hover" onClick={ onClick } href={ link } target={ target } sx={ { lineHeight: 'initial' } }>
						{ decode( title ) }
					</Link>
				</Typography>
			</Stack>
		</Stack>
	);
};
