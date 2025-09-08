import Dialog from '@elementor/ui/Dialog';
import DialogContent from '@elementor/ui/DialogContent';
import DialogHeader from '@elementor/ui/DialogHeader';
import Typography from '@elementor/ui/Typography';
import { __ } from '@wordpress/i18n';
import Stack from '@elementor/ui/Stack';
import Update from './update';
import Divider from '@elementor/ui/Divider';
import { PlusIcon } from './plus-icon';
import { Fragment } from 'react';

export const ChangelogDialog = ( { open, onClose, whatsNew } ) => {
	return (
		<Dialog
			open={ open }
			onClose={ onClose }
			maxWidth="sm"
			fullWidth
		>
			<DialogHeader
				onClose={ onClose }
				variant="outlined"
				logo={ <PlusIcon /> }
			>
				<Typography variant="overline" sx={ { textTransform: 'uppercase', fontWeight: 400, color: 'text.primary' } }>
					{ __( 'Changelog', 'hello-elementor' ) }
				</Typography>
			</DialogHeader>

			<DialogContent sx={ { p: 0 } }>
				<Stack direction={ 'column' } >
					{ whatsNew.map( ( item, index ) => {
							return (
								<Fragment key={ item.id } >
									<Update { ...item } />
									{ index !== whatsNew.length - 1 && <Divider /> }
								</Fragment>
							);
						} ) }
				</Stack>
			</DialogContent>
		</Dialog>
	);
};
