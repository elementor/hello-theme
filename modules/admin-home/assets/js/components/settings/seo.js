import Stack from '@elementor/ui/Stack';
import Typography from '@elementor/ui/Typography';
import { __ } from '@wordpress/i18n';
import { Setting } from './setting';
import { useSettingsContext } from './use-settings-context';
import { Spinner } from '@wordpress/components';

export const Seo = () => {
	const {
		themeSettings: { SKIP_LINK: skipLink, DESCRIPTION_META_TAG: descriptionMetaTag },
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
				{ __( 'These settings affect how search engines and assistive technologies interact with your website.', 'hello-elementor' ) }
			</Typography>
			<Setting
				value={ descriptionMetaTag }
				label={ __( 'Disable description meta tag', 'hello-elementor' ) }
				onSwitchClick={ () => updateSetting( 'DESCRIPTION_META_TAG', ! descriptionMetaTag ) }
				description={ __( 'What it does: Removes the description meta tag code from singular content pages.', 'hello-elementor' ) }
				code={ '<meta name="description" content="..." />' }
				tip={ __( 'Tip: If you use an SEO plugin that handles meta descriptions, like Yoast or Rank Math, disable this option to prevent duplicate meta tags.', 'hello-elementor' ) }
			/>
			<Setting
				value={ skipLink }
				label={ __( 'Disable skip links', 'hello-elementor' ) }
				onSwitchClick={ () => updateSetting( 'SKIP_LINK', ! skipLink ) }
				description={ __( 'What it does: Removes the "Skip to content" link that helps screen reader users and keyboard navigators jump directly to the main content.', 'hello-elementor' ) }
				code={ '<a class="skip-link screen-reader-text" href="#content">Skip to content</a>' }
				tip={ __( 'Tip: If you use an accessibility plugin that adds a "skip to content" link, disable this option to prevent duplications.', 'hello-elementor' ) }
			/>
		</Stack>
	);
};
