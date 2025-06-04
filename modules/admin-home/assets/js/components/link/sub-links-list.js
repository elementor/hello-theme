import Box from '@elementor/ui/Box';
import Typography from '@elementor/ui/Typography';
import Link from '@elementor/ui/Link';
import { decode } from 'html-entities';

const SublinksList = ( { sublinks, target } ) => (
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
);

export default SublinksList;
