import { BaseAdminPaper } from './base-admin-paper';
import Typography from '@elementor/ui/Typography';
import { __ } from '@wordpress/i18n';
import Stack from '@elementor/ui/Stack';
import { ColumnLinkGroup } from '../linkGroup/column-link-group';
import { useAdminContext } from '../../hooks/use-admin-context';

export const QuickLinks = () => {
	const { adminSettings: { quickLinks = [] } = {} } = useAdminContext();

	return (
		<BaseAdminPaper>
			<Typography variant="h6" sx={ { color: 'text.primary' } }>{ __( 'Quick Links', 'hello-elementor' ) }</Typography>
			<Typography variant="body2" sx={ { mb: 3, color: 'text.secondary' } }>
				{ __( 'These quick actions will get your site airborne in a flash.', 'hello-elementor' ) }
			</Typography>
			<Stack direction="row" gap={ 9 }>
				{ Object.keys( quickLinks ).map( ( key ) => {
					return (
						<ColumnLinkGroup key={ key } links={ [ { ...quickLinks[ key ] } ] } />
					);
				} ) }

			</Stack>
		</BaseAdminPaper>
	);
};
