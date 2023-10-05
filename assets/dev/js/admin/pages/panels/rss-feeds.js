import { __ } from '@wordpress/i18n';
import { PanelBody, ToggleControl } from '@wordpress/components';

export const PanelRssFeeds = ( { settingsData, updateSettings } ) => {
	return (
		<PanelBody title={ __( 'RSS feeds', 'hello-elementor' ) } >

			<ToggleControl
				label={ __( 'Remove site RSS feed', 'hello-elementor' ) }
				help={ __( 'A link tag that contains the RSS feed endpoint for website\'s content.', 'hello-elementor' ) }
				checked={ !! settingsData._site_rss || false }
				onChange={ ( value ) => updateSettings( '_site_rss', value ) }
			/>
			<code className="code-example"> &lt;link rel=&quot;alternate&quot; type=&quot;application/rss+xml&quot; title=&quot;Feed&quot; href=&quot;https://example.com/feed/&quot; /&gt; </code>

			<ToggleControl
				label={ __( 'Remove site comments RSS feed', 'hello-elementor' ) }
				help={ __( 'A link tag that contains the RSS feed endpoint for website\'s comments.', 'hello-elementor' ) }
				checked={ !! settingsData._comments_rss || false }
				onChange={ ( value ) => updateSettings( '_comments_rss', value ) }
			/>
			<code className="code-example"> &lt;link rel=&quot;alternate&quot; type=&quot;application/rss+xml&quot; title=&quot;Comments Feed&quot; href=&quot;https://example.com/comments/feed/&quot; /&gt; </code>

			<ToggleControl
				label={ __( 'Remove post comments RSS feed', 'hello-elementor' ) }
				help={ __( 'A link tag that contains the RSS feed endpoint for post\'s comments.', 'hello-elementor' ) }
				checked={ !! settingsData._post_comments_rss || false }
				onChange={ ( value ) => updateSettings( '_post_comments_rss', value ) }
			/>
			<code className="code-example"> &lt;link rel=&quot;alternate&quot; type=&quot;application/rss+xml&quot; title=&quot;Post Comments Feed&quot; href=&quot;https://example.com//post-name/feed/&quot; /&gt; </code>

		</PanelBody>
	);
};
