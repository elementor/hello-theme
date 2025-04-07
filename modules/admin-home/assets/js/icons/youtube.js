import { ReactComponent as YoutubeIcon } from '../../images/BrandYoutube.svg';
import SvgIcon from '@elementor/ui/SvgIcon';

const BrandYoutubeIcon = () => {
	return (
		<SvgIcon sx={ { fontSize: '1rem' } } >
			<YoutubeIcon />
		</SvgIcon>
	);
};

export default BrandYoutubeIcon;
