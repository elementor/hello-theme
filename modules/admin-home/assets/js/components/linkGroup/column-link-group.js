import Stack from '@elementor/ui/Stack';
import { LinkWithIconAndTitle } from '../link/link-with-icon-and-title';
import Typography from '@elementor/ui/Typography';

export const ColumnLinkGroup = ( { links = [], title = '', noLinksMessage, sx = {} } ) => {
	if ( ! links.length ) {
		return null;
	}

	return (
		<Stack direction="column" gap={ 1 } sx={ { ...sx } } >
			{ title && ( <Typography variant="h6">{ title }</Typography> ) }
			{ links.map( ( link ) => {
				return ( <LinkWithIconAndTitle key={ link.title } { ...link } /> );
			} ) }

			{ ! links.length && noLinksMessage && ( <Typography variant="body2">{ noLinksMessage }</Typography> ) }
		</Stack>
	);
};
