import Button from '@elementor/ui/Button';
import CrownIcon from '@elementor/icons/CrownIcon';
import { __ } from '@wordpress/i18n';

export const UpgradeButton = () => {
	const upgradeUrl = window.ehpTopBarConfig?.upgradeUrl;

	if (!upgradeUrl) {
		return null;
	}

	return (
		<Button
			href={upgradeUrl}
			target="_blank"
			rel="noopener noreferrer"
			color="promotion"
			size="small"
			startIcon={<CrownIcon />}
		>
			{__('Upgrade Now', 'hello-elementor')}
		</Button>
	);
};
