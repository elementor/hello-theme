import Stack from '@elementor/ui/Stack';
import Typography from '@elementor/ui/Typography';
import Link from '@elementor/ui/Link';
import Box from '@elementor/ui/Box';
import { decode } from 'html-entities';
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
			<DynamicIcon componentName={ icon } fontSize="tiny" color="text.primary" sx={ { pt: 0.2 } } />
			<Stack direction="column">
				<Typography variant="subtitle1" color="text.primary">
					{
						link && ( 0 === sublinks.length ) ? (
							<Link color="inherit" underline="hover" onClick={ onClick } href={ link } target={ target } sx={ { lineHeight: 'initial', fontWeight: 'normal' } }>
								{ decode( title ) }
							</Link>
						) : (
							<span style={ { lineHeight: 'initial', fontWeight: 'normal' } }>
								{ decode( title ) }
							</span>
						)
					}
				</Typography>
				{ sublinks.length > 0 && (
				<Box sx={ { mt: 0.5 } }>
					<Typography variant="body2" color="text.secondary">
						{ sublinks.map( ( sublink, index ) => (
							<Box component="span" key={ index }>
								{ index > 0 && <span style={ { margin: '0 6px' } }>|</span> }
								<Link
									color="inherit"
									underline="hover"
									href={ sublink.link }
									target={ sublink.target || target }
									sx={ { lineHeight: 'initial', fontWeight: 'normal' } }
                                    >
									{ decode( sublink.title ) }
								</Link>
							</Box>
                            ) ) }
					</Typography>
				</Box>
                ) }
			</Stack>
		</Stack>
	);
};
