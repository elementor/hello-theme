import { __ } from '@wordpress/i18n';
import { SETTINGS } from '../settings.js';
import { PanelBody, ToggleControl } from '@wordpress/components';

export const PanelThemeFeatures = ( { settingsData, updateSettings } ) => {
	return (
		<PanelBody title={ __( 'Hello Theme Features', 'hello-elementor' ) } >

			<ToggleControl
				label={ __( 'Disable description meta tag', 'hello-elementor' ) }
				help={ __( 'Remove the description meta tag in singular content pages that contain an excerpt.', 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.DESCRIPTION_META_TAG ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.DESCRIPTION_META_TAG, value ) }
			/>
			<code className="code-example"> &lt;meta name=&quot;description&quot; content=&quot;...&quot; /&gt; </code>

			<ToggleControl
				label={ __( 'Disable skip link', 'hello-elementor' ) }
				help={ __( 'Remove the "Skip to content" link used by screen-readers and users navigating with a keyboard.', 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.SKIP_LINK ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.SKIP_LINK, value ) }
			/>
			<code className="code-example"> &lt;a class=&quot;skip-link screen-reader-text&quot; href=&quot;#content&quot;&gt; Skip to content &lt;/a&gt; </code>

			<ToggleControl
				label={ __( 'Disable page title', 'hello-elementor' ) }
				help={ __( 'Remove the section above the content that contains the main heading of the page.', 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.PAGE_TITLE ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.PAGE_TITLE, value ) }
			/>
			<code className="code-example"> &lt;header class=&quot;page-header&quot;&gt; &lt;h1 class=&quot;entry-title&quot;&gt; Post title &lt;/h1&gt; &lt;/header&gt; </code>

			<ToggleControl
				label={ __( 'Disable WordPress sitemap', 'hello-elementor' ) }
				help={ __( 'Remove the WordPress sitemap that contains the site pages.', 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.WP_SITEMAP ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.WP_SITEMAP, value ) }
			/>
			<code className="code-example"> &lt;link rel=&quot;sitemap&quot; href=&quot;https://{ window.location.hostname }/wp-sitemap.xml&quot; /&gt; </code>

		</PanelBody>
	);
};
