import { __ } from '@wordpress/i18n';
import { PanelBody, ToggleControl } from '@wordpress/components';

export const PanelScriptsStyles = ( { settingsData, updateSettings } ) => {
	return (
		<PanelBody title={ __( 'Scripts & styles', 'hello-elementor' ) } >

			<ToggleControl
				label={ __( 'Unregister Emoji scripts & styles', 'hello-elementor' ) }
				checked={ !! settingsData._emoji || false }
				onChange={ ( value ) => updateSettings( '_emoji', value ) }
			/>

			<ToggleControl
				label={ __( 'Unregister jQuery migrate script', 'hello-elementor' ) }
				checked={ !! settingsData._jquery_migrate || false }
				onChange={ ( value ) => updateSettings( '_jquery_migrate', value ) }
			/>

			<ToggleControl
				label={ __( 'Unregister oEmbed script', 'hello-elementor' ) }
				checked={ !! settingsData._oembed_script || false }
				onChange={ ( value ) => updateSettings( '_oembed_script', value ) }
			/>

			<ToggleControl
				label={ __( 'Unregister classic-theme styles', 'hello-elementor' ) }
				checked={ !! settingsData._classic_theme_styles || false }
				onChange={ ( value ) => updateSettings( '_classic_theme_styles', value ) }
			/>

			<ToggleControl
				label={ __( 'Unregister Gutenberg styles', 'hello-elementor' ) }
				checked={ !! settingsData._gutenberg || false }
				onChange={ ( value ) => updateSettings( '_gutenberg', value ) }
			/>

			<ToggleControl
				label={ __( 'Unregister Hello style.css', 'hello-elementor' ) }
				checked={ !! settingsData._hello_style || false }
				onChange={ ( value ) => updateSettings( '_hello_style', value ) }
			/>

			<ToggleControl
				label={ __( 'Unregister Hello theme.css', 'hello-elementor' ) }
				checked={ !! settingsData._hello_theme || false }
				onChange={ ( value ) => updateSettings( '_hello_theme', value ) }
			/>

		</PanelBody>
	);
};
