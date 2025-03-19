import { ReactComponent as ElementorLogo } from '../../images/ElementorLogo.svg';
import { SvgIcon } from '@elementor/ui';

export const BrandElementorIcon = () => {
	return (
		<SvgIcon fontSize={ 'small' } >
			<ElementorLogo />
		</SvgIcon>
	);
};
