import Stack from '@elementor/ui/Stack';
import Typography from '@elementor/ui/Typography';
import Link from '@elementor/ui/Link';
import SettingsIcon from '@elementor/icons/SettingsIcon';
import { __ } from '@wordpress/i18n';
import { decode } from 'html-entities';

export const LinkWithIconAndTitle = ( {
		title,
		linkTitle,
		link = '#',
		Icon = SettingsIcon,
		onClick = () => {},
	} ) => {
	const linkTitleText = linkTitle || __( 'Customize', 'hello-elementor' );

	return (
		<Stack direction="row" gap={ 1 } sx={ { alignContent: 'flex-start' } }>
			<Icon fontSize="tiny" color="secondary" sx={ { pt: 0.2 } } />
			<Stack direction="column">
				<Typography variant="subtitle1" sx={ { lineHeight: 'initial' } }>{ decode( title ) }</Typography>
				<Link color="secondary" underline="hover" onClick={ onClick } href={ link }>{ linkTitleText }</Link>
			</Stack>
		</Stack>
	);
};
