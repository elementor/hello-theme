import { useState, useEffect, Fragment } from 'react';
import { store as noticesStore } from '@wordpress/notices';
import { dispatch, useDispatch, useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';
import api from '@wordpress/api';
import { Button, Panel, Placeholder, Spinner, SnackbarList } from '@wordpress/components';
import { PanelThemeFeatures } from './panels/theme-features.js';
import { PanelPageMetaData } from './panels/page-metadata.js';
import { PanelRssFeeds } from './panels/rss-feeds.js';
import { PanelScriptsStyles } from './panels/scripts-styles.js';

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
			[ settingsPrefix + '_classic_theme_styles' ]: settingsData._classic_theme_styles ? 'true' : '',
			[ settingsPrefix + '_gutenberg' ]: settingsData._gutenberg ? 'true' : '',
			[ settingsPrefix + '_hello_style' ]: settingsData._hello_style ? 'true' : '',
			[ settingsPrefix + '_hello_theme' ]: settingsData._hello_theme ? 'true' : '',
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
					_classic_theme_styles: response[ settingsPrefix + '_classic_theme_styles' ],
					_gutenberg: response[ settingsPrefix + '_gutenberg' ],
					_hello_style: response[ settingsPrefix + '_hello_style' ],
					_hello_theme: response[ settingsPrefix + '_hello_theme' ],
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

					<PanelThemeFeatures { ...{ settingsData, updateSettings } } />

					<PanelPageMetaData { ...{ settingsData, updateSettings } } />

					<PanelRssFeeds { ...{ settingsData, updateSettings } } />

					<PanelScriptsStyles { ...{ settingsData, updateSettings } } />

					<Button isPrimary onClick={ saveSettings }>
						{ __( 'Save Settings', 'hello-elementor' ) }
					</Button>

				</Panel>
			</div>
			<div className="hello_elementor__notices">
				<Notices />
			</div>
		</Fragment>
	);
};
