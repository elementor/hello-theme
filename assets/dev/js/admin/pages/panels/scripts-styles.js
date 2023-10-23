import { __ } from '@wordpress/i18n';
import { SETTINGS } from '../settings.js';
import { PanelBody, ToggleControl, Notice, Dashicon } from '@wordpress/components';

export const PanelScriptsStyles = ( { settingsData, updateSettings } ) => {
	const protocol = window.location.protocol || 'https:';
	const domain = window.location.hostname || 'example.com';

	return (
		<PanelBody title={ __( 'Scripts & Styles', 'hello-elementor' ) } >

			<Notice status="warning" isDismissible="false">
				<Dashicon icon="flag" />
				{ __( 'Be cautious, disabling some of the following options may break your website.', 'hello-elementor' ) }
			</Notice>

			<ToggleControl
				label={ __( 'Unregister Emoji scripts & styles', 'hello-elementor' ) }
				help={ __( 'Disable emoji-related scripts and styles.', 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.EMOJI ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.EMOJI, value ) }
			/>

			<ToggleControl
				label={ __( 'Unregister wp-embed script', 'hello-elementor' ) }
				help={ __( 'Disable the script which is responsible for embedding external resources.', 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.WP_EMBED_SCRIPT ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.WP_EMBED_SCRIPT, value ) }
			/>
			<code className="code-example"> &lt;script type=&quot;text/javascript&quot; src=&quot;{ protocol }//{ domain }/wp-includes/js/wp-embed.min.js&quot; /&gt; </code>

			<ToggleControl
				label={ __( 'Unregister classic-theme styles', 'hello-elementor' ) }
				help={ __( "Disable the styles associated with classic themes that don't use Gutenberg.", 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.CLASSIC_THEME_STYLES ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.CLASSIC_THEME_STYLES, value ) }
			/>
			<code className="code-example"> &lt;link rel=&quot;stylesheet&quot; href=&quot;{ protocol }//{ domain }/wp-includes/css/classic-themes.min.css&quot; /&gt; </code>

			<ToggleControl
				label={ __( 'Unregister Gutenberg styles', 'hello-elementor' ) }
				help={ __( 'Disable all Gutenberg-related CSS, both static and inline styles.', 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.GUTENBERG ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.GUTENBERG, value ) }
			/>
			<code className="code-example"> &lt;link rel=&quot;stylesheet&quot; href=&quot;{ protocol }//{ domain }/wp-includes/css/dist/block-library/style.css&quot; /&gt; </code>

			<ToggleControl
				label={ __( 'Unregister Hello style.css', 'hello-elementor' ) }
				help={ __( "Disable Hello theme's style.css file which contains CSS reset rules for unified cross-browser view.", 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.HELLO_STYLE ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.HELLO_STYLE, value ) }
			/>
			<code className="code-example"> &lt;link rel=&quot;stylesheet&quot; href=&quot;{ protocol }//{ domain }/wp-content/themes/hello-elementor/style.min.css&quot; /&gt; </code>

			<ToggleControl
				label={ __( 'Unregister Hello theme.css', 'hello-elementor' ) }
				help={ __( "Disable Hello theme's theme.css file which contains CSS rules that style WordPress elements.", 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.HELLO_THEME ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.HELLO_THEME, value ) }
			/>
			<code className="code-example"> &lt;link rel=&quot;stylesheet&quot; href=&quot;{ protocol }//{ domain }/wp-content/themes/hello-elementor/theme.min.css&quot; /&gt; </code>

		</PanelBody>
	);
};
