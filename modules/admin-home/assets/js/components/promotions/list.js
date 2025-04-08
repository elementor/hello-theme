import { PromotionLink } from '../link/promotion-link';
import { useAdminContext } from '../../hooks/use-admin-context';
import Stack from '@elementor/ui/Stack';

export const PromotionsList = () => {
	const { promotionsLinks } = useAdminContext();

	return (
		<Stack direction="column" gap={ 2 }>
			{ promotionsLinks.map( ( link, i ) => {
				return <PromotionLink key={ i } { ...link } />;
			} ) }
		</Stack>
	);
};
