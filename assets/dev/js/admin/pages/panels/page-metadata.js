import { __ } from '@wordpress/i18n';
import { SETTINGS } from '../settings.js';
import { PanelBody, ToggleControl } from '@wordpress/components';

export const PanelPageMetaData = ( { settingsData, updateSettings } ) => {
	return (
		<PanelBody title={ __( 'Page metadata', 'hello-elementor' ) } >

			<ToggleControl
				label={ __( 'Remove generator tag', 'hello-elementor' ) }
				help={ __( 'A meta tag that contains the WordPress version.', 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.GENERATOR ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.GENERATOR, value ) }
			/>
			<code className="code-example"> &lt;meta name=&quot;generator&quot; content=&quot;WordPress x.x.x&quot; /&gt; </code>

			<ToggleControl
				label={ __( 'Remove WordPress shortlink', 'hello-elementor' ) }
				help={ __( 'A link tag that contains the page URL in a short format.', 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.SHORTLINK ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.SHORTLINK, value ) }
			/>
			<code className="code-example"> &lt;link rel=&quot;shortlink&quot; href=&quot;https://example.com/?p=1&quot; /&gt; </code>

			<ToggleControl
				label={ __( 'Remove WLW link', 'hello-elementor' ) }
				help={ __( 'A link tag that contains the WLW endpoint which provides access to external systems to publish content on the website.', 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.WLW ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.WLW, value ) }
			/>
			<code className="code-example"> &lt;link rel=&quot;wlwmanifest&quot; type=&quot;application/wlwmanifest+xml&quot; href=&quot;https://example.com//wp-includes/wlwmanifest.xml&quot; /&gt; </code>

			<ToggleControl
				label={ __( 'Remove RSD link', 'hello-elementor' ) }
				help={ __( 'A link tag that contains the RSD endpoint which provides access to external systems to publish content on the website.', 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.RSD ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.RSD, value ) }
			/>
			<code className="code-example"> &lt;link rel=&quot;EditURI&quot; type=&quot;application/rsd+xml&quot; title=&quot;RSD&quot; href=&quot;https://example.com/xmlrpc.php?rsd&quot; /&gt; </code>

			<ToggleControl
				label={ __( 'Remove oEmbed link', 'hello-elementor' ) }
				help={ __( 'A link tag that contains the oEmbed endpoint which provides the discovery link for embedding your content on other websites.', 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.OEMBED ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.OEMBED, value ) }
			/>
			<code className="code-example"> &lt;link rel=&quot;alternate&quot; type=&quot;application/json+oembed&quot; href=&quot;https://example.com/wp-json/oembed/1.0/embed?url=...&quot; /&gt; </code>

			<ToggleControl
				label={ __( 'Remove WordPress sitemap link', 'hello-elementor' ) }
				help={ __( 'A link tag that contains the sitemap endpoint.', 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.WP_SITEMAP ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.WP_SITEMAP, value ) }
			/>
			<code className="code-example"> &lt;link rel=&quot;sitemap&quot; href=&quot;https://example.com/wp-sitemap.xml&quot; /&gt; </code>

			<ToggleControl
				label={ __( 'Remove post relational links', 'hello-elementor' ) }
				help={ __( 'Link tags in single posts that contain URLs for the next & previous posts.', 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.POST_PREV_NEXT ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.POST_PREV_NEXT, value ) }
			/>
			<code className="code-example"> &lt;link rel=&quot;next&quot; title=&quot;Next Post&quot; href=&quot;https://example.com/...&quot; /&gt; </code>
			<code className="code-example"> &lt;link rel=&quot;prev&quot; title=&quot;Previous Post&quot; href=&quot;https://example.com/...&quot; /&gt; </code>

		</PanelBody>
	);
};
