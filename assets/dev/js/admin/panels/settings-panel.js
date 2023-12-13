import { __ } from '@wordpress/i18n';
import { PanelBody, ToggleControl, Notice, Dashicon } from '@wordpress/components';

export const SettingsPanel = ( { SETTINGS, settingsData, updateSettings } ) => {
	const protocol = window.location.protocol || 'https:';
	const hostname = window.location.hostname || 'example.com';
	const prefix = protocol + '//' + hostname;

	return (
		<PanelBody title={ __( 'Hello Theme Settings', 'hello-elementor' ) } >

			<Notice status="warning" isDismissible="false">
				<Dashicon icon="flag" />
				{ __( 'Be cautious, disabling some of the following options may break your website.', 'hello-elementor' ) }
			</Notice>

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
				label={ __( 'Disable site-wide header & footer', 'hello-elementor' ) }
				help={ __( 'Remove the header & footer sections from all pages, and their CSS/JS files.', 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.HEADER_FOOTER ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.HEADER_FOOTER, value ) }
			/>
			<code className="code-example"> &lt;header id=&quot;site-header&quot; class=&quot;site-header&quot;&gt; ... &lt;/header&gt; </code>
			<code className="code-example"> &lt;footer id=&quot;site-footer&quot; class=&quot;site-footer&quot;&gt; ... &lt;/footer&gt; </code>

			<ToggleControl
				label={ __( 'Disable page title', 'hello-elementor' ) }
				help={ __( 'Remove the section above the content that contains the main heading of the page.', 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.PAGE_TITLE ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.PAGE_TITLE, value ) }
			/>
			<code className="code-example"> &lt;header class=&quot;page-header&quot;&gt; &lt;h1 class=&quot;entry-title&quot;&gt; Post title &lt;/h1&gt; &lt;/header&gt; </code>

			<ToggleControl
				label={ __( 'Unregister Hello style.css', 'hello-elementor' ) }
				help={ __( "Disable Hello theme's style.css file which contains CSS reset rules for unified cross-browser view.", 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.HELLO_STYLE ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.HELLO_STYLE, value ) }
			/>
			<code className="code-example"> &lt;link rel=&quot;stylesheet&quot; href=&quot;{ prefix }/wp-content/themes/hello-elementor/style.min.css&quot; /&gt; </code>

			<ToggleControl
				label={ __( 'Unregister Hello theme.css', 'hello-elementor' ) }
				help={ __( "Disable Hello theme's theme.css file which contains CSS rules that style WordPress elements.", 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.HELLO_THEME ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.HELLO_THEME, value ) }
			/>
			<code className="code-example"> &lt;link rel=&quot;stylesheet&quot; href=&quot;{ prefix }/wp-content/themes/hello-elementor/theme.min.css&quot; /&gt; </code>

		</PanelBody>
	);
};
