import { ReactComponent as ElementorLogo } from '../../images/ElementorLogo.svg';
import SvgIcon from '@elementor/ui/SvgIcon';

const BrandElementorIcon = () => {
	return (
		<SvgIcon sx={ { fontSize: '1rem' } } >
			<ElementorLogo />
		</SvgIcon>
	);
};

export default BrandElementorIcon;
