import Stack from '@elementor/ui/Stack';
import Typography from '@elementor/ui/Typography';
import { __ } from '@wordpress/i18n';
import { Setting } from './setting';
import { useSettingsContext } from './use-settings-context';
import { Spinner } from '@wordpress/components';

export const Structure = () => {
	const {
		themeSettings: { HEADER_FOOTER: headerFooter, PAGE_TITLE: pageTitle },
		updateSetting,
		isLoading,

	} = useSettingsContext();

	if ( isLoading ) {
		return <Spinner />;
	}

	return (
		<Stack gap={ 2 }>
			<Typography
				variant="subtitle2">
				{ __( 'These settings relate to the structure of your pages.', 'hello-elementor' ) }
			</Typography>
			<Setting
				value={ headerFooter }
				label={ __( 'Disable theme header and footer', 'hello-elementor' ) }
				onSwitchClick={ () => updateSetting( 'HEADER_FOOTER', ! headerFooter ) }
				description={ __( 'What it does: Removes the theme’s default header and footer sections from every page, along with their associated CSS/JS files.', 'hello-elementor' ) }
				code={ '<header id="site-header" class="site-header"> ... </header>\n' +
					'<footer id="site-footer" class="site-footer"> ... </footer>' }
				tip={ __( 'Tip: If you use a plugin like Elementor Pro for your headers and footers, disable the theme header and footer to improve performance.', 'hello-elementor' ) }
			/>
			<Setting
				value={ pageTitle }
				label={ __( 'Hide page title', 'hello-elementor' ) }
				onSwitchClick={ () => updateSetting( 'PAGE_TITLE', ! pageTitle ) }
				description={ __( 'What it does: Removes the main page title above your page content.', 'hello-elementor' ) }
				code={ '<div class="page-header"><h1 class="entry-title">Post title</h1></div>' }
				tip={ __( 'Tip: If you do not want to display page titles or are using Elementor widgets to display your page titles, hide the page title.', 'hello-elementor' ) }
			/>
		</Stack>
	);
};
