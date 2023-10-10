import { __ } from '@wordpress/i18n';
import { SETTINGS } from '../settings.js';
import { PanelBody, ToggleControl } from '@wordpress/components';

export const PanelThemeFeatures = ( { settingsData, updateSettings } ) => {
	return (
		<PanelBody title={ __( 'Hello Elementor features', 'hello-elementor' ) } >

			<ToggleControl
				label={ __( 'Disable description meta tag', 'hello-elementor' ) }
				help={
					sprintf(
						/* translators: %s: The <head> tag. */
						__( 'A meta tag that contains the post/page excerpt, in the %s.', 'hello-elementor' ),
						'<head>',
					)
				}
				checked={ !! settingsData[ SETTINGS.DESCRIPTION_META_TAG ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.DESCRIPTION_META_TAG, value ) }
			/>

			<ToggleControl
				label={ __( 'Disable skip link', 'hello-elementor' ) }
				help={ __( 'A link to the main content used by screen-reader users.', 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.SKIP_LINK ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.SKIP_LINK, value ) }
			/>

			<ToggleControl
				label={ __( 'Disable page title', 'hello-elementor' ) }
				help={
					sprintf(
						/* translators: %s: The <h1> tag. */
						__( 'A section above the content containing the %s heading of the page.', 'hello-elementor' ),
						'<h1>',
					)
				}
				checked={ !! settingsData[ SETTINGS.PAGE_TITLE ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.PAGE_TITLE, value ) }
			/>

		</PanelBody>
	);
};
