import Stack from '@elementor/ui/Stack';
import SublinksList from './sub-links-list';
import LinkOrTitle from './link-or-title';
import DynamicIcon from '../dynamic-icon';

export const LinkWithIconAndTitle = ( {
	title,
	link = null,
	icon = 'SettingsIcon',
	sublinks = [],
	onClick = () => {},
	target = '',
} ) => {
	return (
		<Stack direction="row" gap={ 1 } sx={ { alignContent: 'flex-start' } }>
			<DynamicIcon
				componentName={ icon }
				fontSize="tiny"
				color="text.primary"
				sx={ { pt: 0.2 } }
			/>
			<Stack direction="column">
				<LinkOrTitle
					title={ title }
					link={ link }
					icon={ icon }
					sublinks={ sublinks }
					onClick={ onClick }
					target={ target }
				/>
				{ sublinks.length > 0 && (
					<SublinksList sublinks={ sublinks } target={ target } />
				) }
			</Stack>
		</Stack>
	);
};
