import SvgIcon from '@elementor/ui/SvgIcon';
import { ReactComponent as Icon } from '../../../images/plus.svg';

export const PlusIcon = ( props ) => {
	return (
		<SvgIcon viewBox="0 0 24 24" { ...props }>
			<Icon />
		</SvgIcon>
	);
};
