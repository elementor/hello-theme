import Stack from '@elementor/ui/Stack';
import DynamicIcon from '../dynamic-icon';
import Typography from '@elementor/ui/Typography';
import { __ } from '@wordpress/i18n';

export const TopBarContent = ( { sx = {}, iconSize = 'medium' } ) => {
	return (
		<Stack direction="row" sx={ { alignItems: 'center', height: 50, px: 2, backgroundColor: 'background.default', justifyContent: 'space-between', color: 'text.primary', ...sx } }>
			<Stack direction="row" spacing={ 1 } alignItems="center">
				<DynamicIcon
					componentName="BrandElementorIcon"
					fontSize={ iconSize }
				/>
				<Typography variant="subtitle1">{ __( 'Hello', 'hello-elementor' ) }</Typography>
			</Stack>
		</Stack>
	);
};
