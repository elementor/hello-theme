import { __ } from '@wordpress/i18n';
import { SETTINGS } from '../settings.js';
import { PanelBody, ToggleControl } from '@wordpress/components';

export const PanelScriptsStyles = ( { settingsData, updateSettings } ) => {
	return (
		<PanelBody title={ __( 'Scripts & styles', 'hello-elementor' ) } >

			<ToggleControl
				label={ __( 'Unregister Emoji scripts & styles', 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.EMOJI ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.EMOJI, value ) }
			/>

			<ToggleControl
				label={ __( 'Unregister jQuery migrate script', 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.JQUERY_MIGRATE ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.JQUERY_MIGRATE, value ) }
			/>

			<ToggleControl
				label={ __( 'Unregister oEmbed script', 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.OEMBED_SCRIPT ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.OEMBED_SCRIPT, value ) }
			/>

			<ToggleControl
				label={ __( 'Unregister classic-theme styles', 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.CLASSIC_THEME_STYLES ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.CLASSIC_THEME_STYLES, value ) }
			/>

			<ToggleControl
				label={ __( 'Unregister Gutenberg styles', 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.GUTENBERG ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.GUTENBERG, value ) }
			/>

			<ToggleControl
				label={ __( 'Unregister Hello style.css', 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.HELLO_STYLE ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.HELLO_STYLE, value ) }
			/>

			<ToggleControl
				label={ __( 'Unregister Hello theme.css', 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.HELLO_THEME ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.HELLO_THEME, value ) }
			/>

		</PanelBody>
	);
};
