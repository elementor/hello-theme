import { useState, useEffect, Fragment } from 'react';
import { store as noticesStore } from '@wordpress/notices';
import { dispatch, useDispatch, useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';
import api from '@wordpress/api';
import {
	Button,
	Panel,
	PanelBody,
	Placeholder,
	Spinner,
	ToggleControl,
	SnackbarList,
} from '@wordpress/components';

const Notices = () => {
	const notices = useSelect(
		( select ) =>
			select( noticesStore )
				.getNotices()
				.filter( ( notice ) => 'snackbar' === notice.type ),
		[],
	);

	const { removeNotice } = useDispatch( noticesStore );

	return (
		<SnackbarList
			className="edit-site-notices"
			notices={ notices }
			onRemove={ removeNotice }
		/>
	);
};
export const MainPage = () => {
	const [ hasLoaded, setHasLoaded ] = useState( false );
	const [ settingsData, setSettingsData ] = useState( {} );

	const settingsPrefix = 'hello_elementor_settings';

	/**
	 * Update settings data.
	 *
	 * @param {string} settingsName
	 * @param {string} settingsValue
	 */
	const updateSettings = ( settingsName, settingsValue ) => {
		setSettingsData( {
			...settingsData,
			[ settingsName ]: settingsValue,
		} );
	};

	/**
	 * Save settings to server.
	 */
	const saveSettings = () => {
		const settings = new api.models.Settings( {
			[ settingsPrefix + '_description_meta_tag' ]: settingsData._description_meta_tag ? 'true' : '',
			[ settingsPrefix + '_skip_link' ]: settingsData._skip_link ? 'true' : '',
			[ settingsPrefix + '_page_title' ]: settingsData._page_title ? 'true' : '',
			[ settingsPrefix + '_generator' ]: settingsData._generator ? 'true' : '',
			[ settingsPrefix + '_shortlink' ]: settingsData._shortlink ? 'true' : '',
			[ settingsPrefix + '_wlw' ]: settingsData._wlw ? 'true' : '',
			[ settingsPrefix + '_rsd' ]: settingsData._rsd ? 'true' : '',
			[ settingsPrefix + '_oembed' ]: settingsData._oembed ? 'true' : '',
			[ settingsPrefix + '_wp_sitemap' ]: settingsData._wp_sitemap ? 'true' : '',
			[ settingsPrefix + '_post_prev_next' ]: settingsData._post_prev_next ? 'true' : '',
			[ settingsPrefix + '_site_rss' ]: settingsData._site_rss ? 'true' : '',
			[ settingsPrefix + '_comments_rss' ]: settingsData._comments_rss ? 'true' : '',
			[ settingsPrefix + '_post_comments_rss' ]: settingsData._post_comments_rss ? 'true' : '',
			[ settingsPrefix + '_emoji' ]: settingsData._emoji ? 'true' : '',
			[ settingsPrefix + '_jquery_migrate' ]: settingsData._jquery_migrate ? 'true' : '',
			[ settingsPrefix + '_oembed_script' ]: settingsData._oembed_script ? 'true' : '',
			[ settingsPrefix + '_gutenberg' ]: settingsData._gutenberg ? 'true' : '',
		} );

		settings.save();

		dispatch( 'core/notices' ).createNotice(
			'success',
			__( 'Settings Saved', 'hello-elementor' ),
			{
				type: 'snackbar',
				isDismissible: true,
			},
		);
	};

	useEffect( () => {
		const fetchSettings = async () => {
			try {
				await api.loadPromise;
				const settings = new api.models.Settings();
				const response = await settings.fetch();
				setSettingsData( {
					_description_meta_tag: response[ settingsPrefix + '_description_meta_tag' ],
					_skip_link: response[ settingsPrefix + '_skip_link' ],
					_page_title: response[ settingsPrefix + '_page_title' ],
					_generator: response[ settingsPrefix + '_generator' ],
					_shortlink: response[ settingsPrefix + '_shortlink' ],
					_wlw: response[ settingsPrefix + '_wlw' ],
					_rsd: response[ settingsPrefix + '_rsd' ],
					_oembed: response[ settingsPrefix + '_oembed' ],
					_wp_sitemap: response[ settingsPrefix + '_wp_sitemap' ],
					_post_prev_next: response[ settingsPrefix + '_post_prev_next' ],
					_site_rss: response[ settingsPrefix + '_site_rss' ],
					_comments_rss: response[ settingsPrefix + '_comments_rss' ],
					_post_comments_rss: response[ settingsPrefix + '_post_comments_rss' ],
					_emoji: response[ settingsPrefix + '_emoji' ],
					_jquery_migrate: response[ settingsPrefix + '_jquery_migrate' ],
					_oembed_script: response[ settingsPrefix + '_oembed_script' ],
					_gutenberg: response[ settingsPrefix + '_gutenberg' ],
				} );
				setHasLoaded( true );
			} catch ( error ) {
				// eslint-disable-next-line no-console
				console.error( error );
			}
		};

		if ( hasLoaded ) {
			return;
		}

		// eslint-disable-next-line no-console
		fetchSettings().catch( console.error );
	}, [ settingsData ] );

	if ( ! hasLoaded ) {
		return (
			<Placeholder>
				<Spinner />
			</Placeholder>
		);
	}

	return (
		<Fragment>
			<div className="hello_elementor__header">
				<div className="hello_elementor__container">
					<div className="hello_elementor__title">
						<h1>{ __( 'Hello Elementor Settings', 'hello-elementor' ) }</h1>
					</div>
				</div>
			</div>
			<div className="hello_elementor__main">
				<Panel>

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
							checked={ settingsData._description_meta_tag || false }
							onChange={ ( value ) => updateSettings( '_description_meta_tag', value ) }
						/>

						<ToggleControl
							label={ __( 'Disable skip link', 'hello-elementor' ) }
							help={ __( 'A link to the main content used by screen-reader users.', 'hello-elementor' ) }
							checked={ settingsData._skip_link || false }
							onChange={ ( value ) => updateSettings( '_skip_link', value ) }
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
							checked={ settingsData._page_title || false }
							onChange={ ( value ) => updateSettings( '_page_title', value ) }
						/>

					</PanelBody>

					<PanelBody title={ __( 'Clean page metadata', 'hello-elementor' ) } >

						<ToggleControl
							label={ __( 'Remove generator tag', 'hello-elementor' ) }
							help={ __( 'A meta tag that contains the WordPress version.', 'hello-elementor' ) }
							checked={ settingsData._generator || false }
							onChange={ ( value ) => updateSettings( '_generator', value ) }
						/>
						<code className="code-example"> &lt;meta name=&quot;generator&quot; content=&quot;WordPress x.x.x&quot; /&gt; </code>

						<ToggleControl
							label={ __( 'Remove WordPress shortlink', 'hello-elementor' ) }
							help={ __( 'A link tag that contains the page URL in a short format.', 'hello-elementor' ) }
							checked={ settingsData._shortlink || false }
							onChange={ ( value ) => updateSettings( '_shortlink', value ) }
						/>
						<code className="code-example"> &lt;link rel=&quot;shortlink&quot; href=&quot;https://example.com/?p=1&quot; /&gt; </code>

						<ToggleControl
							label={ __( 'Remove WLW link', 'hello-elementor' ) }
							help={ __( 'A link tag that contains the WLW endpoint which provides access to external systems to publish content on the website.', 'hello-elementor' ) }
							checked={ settingsData._wlw || false }
							onChange={ ( value ) => updateSettings( '_wlw', value ) }
						/>
						<code className="code-example"> &lt;link rel=&quot;wlwmanifest&quot; type=&quot;application/wlwmanifest+xml&quot; href=&quot;https://example.com//wp-includes/wlwmanifest.xml&quot; /&gt; </code>

						<ToggleControl
							label={ __( 'Remove RSD link', 'hello-elementor' ) }
							help={ __( 'A link tag that contains the RSD endpoint which provides access to external systems to publish content on the website.', 'hello-elementor' ) }
							checked={ settingsData._rsd || false }
							onChange={ ( value ) => updateSettings( '_rsd', value ) }
						/>
						<code className="code-example"> &lt;link rel=&quot;EditURI&quot; type=&quot;application/rsd+xml&quot; title=&quot;RSD&quot; href=&quot;https://example.com/xmlrpc.php?rsd&quot; /&gt; </code>

						<ToggleControl
							label={ __( 'Remove oEmbed link', 'hello-elementor' ) }
							help={ __( 'A link tag that contains the oEmbed endpoint which provides the discovery link for embedding your content on other websites.', 'hello-elementor' ) }
							checked={ settingsData._oembed || false }
							onChange={ ( value ) => updateSettings( '_oembed', value ) }
						/>
						<code className="code-example"> &lt;link rel=&quot;alternate&quot; type=&quot;application/json+oembed&quot; href=&quot;https://example.com/wp-json/oembed/1.0/embed?url=...&quot; /&gt; </code>

						<ToggleControl
							label={ __( 'Remove WordPress sitemap link', 'hello-elementor' ) }
							help={ __( 'A link tag that contains the sitemap endpoint.', 'hello-elementor' ) }
							checked={ settingsData._wp_sitemap || false }
							onChange={ ( value ) => updateSettings( '_wp_sitemap', value ) }
						/>
						<code className="code-example"> &lt;link rel=&quot;sitemap&quot; href=&quot;https://example.com/wp-sitemap.xml&quot; /&gt; </code>

						<ToggleControl
							label={ __( 'Remove post relational links', 'hello-elementor' ) }
							help={ __( 'Link tags in single posts that contain URLs for the next & previous posts.', 'hello-elementor' ) }
							checked={ settingsData._post_prev_next || false }
							onChange={ ( value ) => updateSettings( '_post_prev_next', value ) }
						/>
						<code className="code-example"> &lt;link rel=&quot;next&quot; title=&quot;Next Post&quot; href=&quot;https://example.com/...&quot; /&gt; </code>
						<code className="code-example"> &lt;link rel=&quot;prev&quot; title=&quot;Previous Post&quot; href=&quot;https://example.com/...&quot; /&gt; </code>

					</PanelBody>

					<PanelBody title={ __( 'RSS feeds', 'hello-elementor' ) } >

						<ToggleControl
							label={ __( 'Remove site RSS feed', 'hello-elementor' ) }
							help={ __( 'A link tag that contains the RSS feed endpoint for website\'s content.', 'hello-elementor' ) }
							checked={ settingsData._site_rss || false }
							onChange={ ( value ) => updateSettings( '_site_rss', value ) }
						/>
						<code className="code-example"> &lt;link rel=&quot;alternate&quot; type=&quot;application/rss+xml&quot; title=&quot;Feed&quot; href=&quot;https://example.com/feed/&quot; /&gt; </code>

						<ToggleControl
							label={ __( 'Remove site comments RSS feed', 'hello-elementor' ) }
							help={ __( 'A link tag that contains the RSS feed endpoint for website\'s comments.', 'hello-elementor' ) }
							checked={ settingsData._comments_rss || false }
							onChange={ ( value ) => updateSettings( '_comments_rss', value ) }
						/>
						<code className="code-example"> &lt;link rel=&quot;alternate&quot; type=&quot;application/rss+xml&quot; title=&quot;Comments Feed&quot; href=&quot;https://example.com/comments/feed/&quot; /&gt; </code>

						<ToggleControl
							label={ __( 'Remove post comments RSS feed', 'hello-elementor' ) }
							help={ __( 'A link tag that contains the RSS feed endpoint for post\'s comments.', 'hello-elementor' ) }
							checked={ settingsData._post_comments_rss || false }
							onChange={ ( value ) => updateSettings( '_post_comments_rss', value ) }
						/>
						<code className="code-example"> &lt;link rel=&quot;alternate&quot; type=&quot;application/rss+xml&quot; title=&quot;Post Comments Feed&quot; href=&quot;https://example.com//post-name/feed/&quot; /&gt; </code>

					</PanelBody>

					<PanelBody title={ __( 'Unregister scripts & styles', 'hello-elementor' ) } >

						<ToggleControl
							label={ __( 'Unregister Emoji scripts & styles', 'hello-elementor' ) }
							checked={ settingsData._emoji || false }
							onChange={ ( value ) => updateSettings( '_emoji', value ) }
						/>

						<ToggleControl
							label={ __( 'Unregister jQuery migrate script', 'hello-elementor' ) }
							checked={ settingsData._jquery_migrate || false }
							onChange={ ( value ) => updateSettings( '_jquery_migrate', value ) }
						/>

						<ToggleControl
							label={ __( 'Unregister oEmbed script', 'hello-elementor' ) }
							checked={ settingsData._oembed_script || false }
							onChange={ ( value ) => updateSettings( '_oembed_script', value ) }
						/>

						<ToggleControl
							label={ __( 'Unregister Gutenberg scripts & styles', 'hello-elementor' ) }
							checked={ settingsData._gutenberg || false }
							onChange={ ( value ) => updateSettings( '_gutenberg', value ) }
						/>

					</PanelBody>

					<Button isPrimary onClick={ saveSettings }>
						{ __( 'Save', 'hello-elementor' ) }
					</Button>

				</Panel>
			</div>
			<div className="hello_elementor__notices">
				<Notices />
			</div>
		</Fragment>
	);
};
