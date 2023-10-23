import { __ } from '@wordpress/i18n';
import { SETTINGS } from '../settings.js';
import { PanelBody, ToggleControl } from '@wordpress/components';

export const PanelHeadCleanup = ( { settingsData, updateSettings } ) => {
	const protocol = window.location.protocol || 'https:';
	const domain = window.location.hostname || 'example.com';

	return (
		<PanelBody title={ __( 'Head Cleanup', 'hello-elementor' ) } >

			<ToggleControl
				label={ __( 'Remove generator tag', 'hello-elementor' ) }
				help={ __( 'Omit the meta tag that contains the WordPress version, enhancing security by concealing version information.', 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.GENERATOR ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.GENERATOR, value ) }
			/>
			<code className="code-example"> &lt;meta name=&quot;generator&quot; content=&quot;WordPress x.x.x&quot; /&gt; </code>

			<ToggleControl
				label={ __( 'Remove WordPress shortlink', 'hello-elementor' ) }
				help={ __( 'Omit the link tag that contains the short-format page URL, enhancing website privacy and security.', 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.SHORTLINK ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.SHORTLINK, value ) }
			/>
			<code className="code-example"> &lt;link rel=&quot;shortlink&quot; href=&quot;{ protocol }//{ domain }/?p=1&quot; /&gt; </code>

			<ToggleControl
				label={ __( 'Remove WLW link', 'hello-elementor' ) }
				help={ __( 'Omit the link tag that contains the WLW endpoint, which provides access to external systems to publish content on the website.', 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.WLW ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.WLW, value ) }
			/>
			<code className="code-example"> &lt;link rel=&quot;wlwmanifest&quot; type=&quot;application/wlwmanifest+xml&quot; href=&quot;{ protocol }//{ domain }/wp-includes/wlwmanifest.xml&quot; /&gt; </code>

			<ToggleControl
				label={ __( 'Remove RSD link', 'hello-elementor' ) }
				help={ __( 'Omit the link tag that contains the RSD endpoint, which provides access to external systems to publish content on the website.', 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.RSD ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.RSD, value ) }
			/>
			<code className="code-example"> &lt;link rel=&quot;EditURI&quot; type=&quot;application/rsd+xml&quot; title=&quot;RSD&quot; href=&quot;{ protocol }//{ domain }/xmlrpc.php?rsd&quot; /&gt; </code>

			<ToggleControl
				label={ __( 'Remove oEmbed link', 'hello-elementor' ) }
				help={ __( 'Omit the link tag that contains the oEmbed endpoint, which provides the discovery link for embedding your content on other websites.', 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.OEMBED ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.OEMBED, value ) }
			/>
			<code className="code-example"> &lt;link rel=&quot;alternate&quot; type=&quot;application/json+oembed&quot; href=&quot;{ protocol }//{ domain }/wp-json/oembed/1.0/embed?url=...&quot; /&gt; </code>

			<ToggleControl
				label={ __( 'Remove post relational links', 'hello-elementor' ) }
				help={ __( 'Omit the link tags in single posts that contain URLs for the next & previous posts.', 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.POST_PREV_NEXT ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.POST_PREV_NEXT, value ) }
			/>
			<code className="code-example"> &lt;link rel=&quot;next&quot; title=&quot;Next Post&quot; href=&quot;{ protocol }//{ domain }/...&quot; /&gt; </code>
			<code className="code-example"> &lt;link rel=&quot;prev&quot; title=&quot;Previous Post&quot; href=&quot;{ protocol }//{ domain }/...&quot; /&gt; </code>

			<ToggleControl
				label={ __( 'Remove site RSS feed', 'hello-elementor' ) }
				help={ __( 'Omit the link tag that contains the RSS feed endpoint for the website\'s content.', 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.SITE_RSS ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.SITE_RSS, value ) }
			/>
			<code className="code-example"> &lt;link rel=&quot;alternate&quot; type=&quot;application/rss+xml&quot; href=&quot;{ protocol }//{ domain }/feed/&quot; /&gt; </code>

			<ToggleControl
				label={ __( 'Remove site comments RSS feed', 'hello-elementor' ) }
				help={ __( 'Omit the link tag that contains the RSS feed endpoint for the website\'s comments.', 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.COMMENTS_RSS ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.COMMENTS_RSS, value ) }
			/>
			<code className="code-example"> &lt;link rel=&quot;alternate&quot; type=&quot;application/rss+xml&quot; href=&quot;{ protocol }//{ domain }/comments/feed/&quot; /&gt; </code>

			<ToggleControl
				label={ __( 'Remove post comments RSS feed', 'hello-elementor' ) }
				help={ __( 'Omit the link tag that contains the RSS feed endpoint for the post\'s comments.', 'hello-elementor' ) }
				checked={ !! settingsData[ SETTINGS.POST_COMMENTS_RSS ] || false }
				onChange={ ( value ) => updateSettings( SETTINGS.POST_COMMENTS_RSS, value ) }
			/>
			<code className="code-example"> &lt;link rel=&quot;alternate&quot; type=&quot;application/rss+xml&quot; href=&quot;{ protocol }//{ domain }/post-name/feed/&quot; /&gt; </code>

		</PanelBody>
	);
};
