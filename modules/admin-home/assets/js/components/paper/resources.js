import { BaseAdminPaper } from './base-admin-paper';
import { __ } from '@wordpress/i18n';
import Stack from '@elementor/ui/Stack';
import { ColumnLinkGroup } from '../linkGroup/column-link-group';
import { useAdminContext } from '../../hooks/use-admin-context';

export const Resources = () => {
	const { adminSettings: { resourcesData: { community = [], resources = [] } = {} } = {} } = useAdminContext();

	return (
		<BaseAdminPaper>
			<Stack direction="row" gap={ 12 }>
				<ColumnLinkGroup
					title={ __( 'Community', 'hello-elementor' ) }
					links={ community }
					sx={ { minWidth: '25%' } }
				/>
				<ColumnLinkGroup
					title={ __( 'Resources', 'hello-elementor' ) }
					links={ resources }
					sx={ { minWidth: '25%' } }
				/>
			</Stack>
		</BaseAdminPaper>
	);
};
