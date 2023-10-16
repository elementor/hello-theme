import { __ } from '@wordpress/i18n';
import { SETTINGS } from '../settings.js';
import { PanelBody, ToggleControl } from '@wordpress/components';

export const PanelScriptsStyles = ( { settingsData, updateSettings } ) => {
	return (
		<PanelBody title={ __( 'Scripts & Styles', 'hello-elementor' ) } >

			<ToggleControl
				label={ __( 'Unregister Emoji scripts & styles', 'hello-elementor' ) }
				help={ __( 'Scripts and styles required to display Emojis.', 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.EMOJI ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.EMOJI, value ) }
			/>

			<ToggleControl
				label={ __( 'Unregister oEmbed script', 'hello-elementor' ) }
				help={ __( 'oEmbed-specific JavaScript that loads embeded elements from external recources.', 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.OEMBED_SCRIPT ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.OEMBED_SCRIPT, value ) }
			/>
			<code className="code-example"> &lt;script type=&quot;text/javascript&quot; src=&quot;https://{ window.location.hostname }/wp-includes/js/wp-embeds.min.js&quot; /&gt; </code>

			<ToggleControl
				label={ __( 'Unregister classic-theme styles', 'hello-elementor' ) }
				help={ __( "Styles associated with the classic themes that don't use Gutenberg.", 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.CLASSIC_THEME_STYLES ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.CLASSIC_THEME_STYLES, value ) }
			/>
			<code className="code-example"> &lt;link rel=&quot;stylesheet&quot; href=&quot;https://{ window.location.hostname }/wp-includes/css/classic-themes.min.css&quot; /&gt; </code>

			<ToggleControl
				label={ __( 'Unregister Gutenberg styles', 'hello-elementor' ) }
				help={ __( 'Gutenberg styles for a cleaner look and enhanced website performance.', 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.GUTENBERG ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.GUTENBERG, value ) }
			/>

			<ToggleControl
				label={ __( 'Unregister Hello style.css', 'hello-elementor' ) }
				help={ __( "Hello theme's style.css file which contains CSS reset rules.", 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.HELLO_STYLE ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.HELLO_STYLE, value ) }
			/>
			<code className="code-example"> &lt;link rel=&quot;stylesheet&quot; href=&quot;http://{ window.location.hostname }/wp-content/themes/hello-theme/style.min.css&quot; /&gt; </code>

			<ToggleControl
				label={ __( 'Unregister Hello theme.css', 'hello-elementor' ) }
				help={ __( "Hello theme's theme.css file which contains CSS rules that style WordPress elements.", 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.HELLO_THEME ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.HELLO_THEME, value ) }
			/>
			<code className="code-example"> &lt;link rel=&quot;stylesheet&quot; href=&quot;http://{ window.location.hostname }/wp-content/themes/hello-theme/theme.min.css&quot; /&gt; </code>

		</PanelBody>
	);
};
