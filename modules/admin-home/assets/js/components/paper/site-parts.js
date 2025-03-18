import { BaseAdminPaper } from './base-admin-paper';
import Stack from '@elementor/ui/Stack';
import { ColumnLinkGroup } from '../linkGroup/column-link-group';
import { __ } from '@wordpress/i18n';
import { useAdminContext } from '../../hooks/use-admin-context';

export const SiteParts = () => {
	const { adminSettings: { siteParts: { siteParts = [], sitePages = [], general = [] } = {} } = {} } = useAdminContext();

	return (
		<BaseAdminPaper>
			<Stack direction="row" gap={ 12 }>
				<ColumnLinkGroup
					title={ __( 'Site Parts', 'hello-elementor' ) }
					links={ siteParts }
					noLinksMessage={ __( 'The kit you imported doesn\'t have an Header or a Footer.', 'hello-elementor' ) }
				/>
				<ColumnLinkGroup
					title={ __( 'Recent Pages', 'hello-elementor' ) }
					links={ sitePages }
				/>
				<ColumnLinkGroup
					title={ __( 'General', 'hello-elementor' ) }
					links={ general }
				/>
			</Stack>
		</BaseAdminPaper>
	);
};
