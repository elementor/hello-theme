import Stack from '@elementor/ui/Stack';
import Typography from '@elementor/ui/Typography';
import Link from '@elementor/ui/Link';
import { decode } from 'html-entities';

const LinkOrTitle = ( { title, link, sublinks, onClick, target } ) => (
	<Stack direction="column">
		<Typography variant="subtitle1" color="text.primary">
			{ link && 0 === sublinks.length ? (
				<Link
					color="inherit"
					underline="hover"
					onClick={ onClick }
					href={ link }
					target={ target }
					sx={ { lineHeight: 'initial', fontWeight: 'normal' } }
				>
					{ decode( title ) }
				</Link>
			) : (
				<span style={ { lineHeight: 'initial', fontWeight: 'normal' } }>
					{ decode( title ) }
				</span>
			) }
		</Typography>
	</Stack>
);

export default LinkOrTitle;
