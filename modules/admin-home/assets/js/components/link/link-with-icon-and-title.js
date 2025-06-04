import Stack from '@elementor/ui/Stack';
import SublinksList from './sub-links-list';
import LinkTitleWithIcon from './link-title-with-icon';

export const LinkWithIconAndTitle = ( {
	title,
	link = null,
	icon = 'SettingsIcon',
	sublinks = [],
	onClick = () => {},
	target = '',
} ) => {
	return (
		<Stack direction="column">
			<LinkTitleWithIcon
				title={title}
				link={link}
				icon={icon}
				sublinks={sublinks}
				onClick={onClick}
				target={target}
			/>
			{ sublinks.length > 0 && <SublinksList sublinks={sublinks} target={target} /> }
		</Stack>
	);
};
