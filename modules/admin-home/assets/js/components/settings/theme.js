import Stack from '@elementor/ui/Stack';
import Typography from '@elementor/ui/Typography';
import { __ } from '@wordpress/i18n';
import { Setting } from './setting';
import { useSettingsContext } from './use-settings-context';
import { Spinner } from '@wordpress/components';
import Alert from '@elementor/ui/Alert';

export const Theme = () => {
	const {
		themeSettings: { HELLO_THEME: helloTheme, HELLO_STYLE: helloStyle },
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
				{ __( 'These settings allow you to change or remove default Hello Elementor theme styles.', 'hello-elementor' ) }
			</Typography>
			<Alert severity="warning" sx={ { mb: 2 } }>
				{ __( 'Be careful, disabling these settings could break your website.', 'hello-elementor' ) }
			</Alert>
			<Setting
				value={ helloStyle }
				label={ __( 'Deregister Hello style.css', 'hello-elementor' ) }
				onSwitchClick={ () => updateSetting( 'HELLO_STYLE', ! helloStyle ) }
				description={ __( 'What it does: Turns off CSS reset rules by disabling the theme’s primary stylesheet. CSS reset rules make sure your website looks the same in different browsers.', 'hello-elementor' ) }
				code={ `<link rel="stylesheet" href="${ window.location.origin }/wp-content/themes/hello-elementor/style.min.css" />` }
				tip={ __( 'Tip: Deregistering style.css can make your website load faster. Disable it only if you’re using another style reset method, such as with a child theme.', 'hello-elementor' ) }
			/>
			<Setting
				value={ helloTheme }
				label={ __( 'Deregister Hello theme.css', 'hello-elementor' ) }
				onSwitchClick={ () => updateSetting( 'HELLO_THEME', ! helloTheme ) }
				description={ __( 'What it does: Turns off CSS reset rules by disabling the theme’s primary stylesheet. CSS reset rules make sure your website looks the same in different browsers.', 'hello-elementor' ) }
				code={ `<link rel="stylesheet" href="${ window.location.origin }/wp-content/themes/hello-elementor/theme.min.css" />` }
				tip={ __( 'Tip: Deregistering theme.css can make your website load faster. Disable it only if you are not using any WordPress elements on your website, or if you want to style them yourself. Examples of WordPress elements include comments area, pagination box, and image align classes.', 'hello-elementor' ) }
			/>
		</Stack>
	);
};
