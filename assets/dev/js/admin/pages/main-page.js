import { useState, useEffect, Fragment } from 'react';
import { store as noticesStore } from '@wordpress/notices';
import { dispatch, useDispatch, useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';
import api from '@wordpress/api';
import { Button, Panel, Placeholder, Spinner, SnackbarList } from '@wordpress/components';
import { SETTINGS } from './settings.js';
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
			[ settingsPrefix + SETTINGS.DESCRIPTION_META_TAG ]: settingsData[ SETTINGS.DESCRIPTION_META_TAG ] ? 'true' : '',
			[ settingsPrefix + SETTINGS.SKIP_LINK ]: settingsData[ SETTINGS.SKIP_LINK ] ? 'true' : '',
			[ settingsPrefix + SETTINGS.PAGE_TITLE ]: settingsData[ SETTINGS.PAGE_TITLE ] ? 'true' : '',
			[ settingsPrefix + SETTINGS.GENERATOR ]: settingsData[ SETTINGS.GENERATOR ] ? 'true' : '',
			[ settingsPrefix + SETTINGS.SHORTLINK ]: settingsData[ SETTINGS.SHORTLINK ] ? 'true' : '',
			[ settingsPrefix + SETTINGS.WLW ]: settingsData[ SETTINGS.WLW ] ? 'true' : '',
			[ settingsPrefix + SETTINGS.RSD ]: settingsData[ SETTINGS.RSD ] ? 'true' : '',
			[ settingsPrefix + SETTINGS.OEMBED ]: settingsData[ SETTINGS.OEMBED ] ? 'true' : '',
			[ settingsPrefix + SETTINGS.WP_SITEMAP ]: settingsData[ SETTINGS.WP_SITEMAP ] ? 'true' : '',
			[ settingsPrefix + SETTINGS.POST_PREV_NEXT ]: settingsData[ SETTINGS.POST_PREV_NEXT ] ? 'true' : '',
			[ settingsPrefix + SETTINGS.SITE_RSS ]: settingsData[ SETTINGS.SITE_RSS ] ? 'true' : '',
			[ settingsPrefix + SETTINGS.COMMENTS_RSS ]: settingsData[ SETTINGS.COMMENTS_RSS ] ? 'true' : '',
			[ settingsPrefix + SETTINGS.POST_COMMENTS_RSS ]: settingsData[ SETTINGS.POST_COMMENTS_RSS ] ? 'true' : '',
			[ settingsPrefix + SETTINGS.EMOJI ]: settingsData[ SETTINGS.EMOJI ] ? 'true' : '',
			[ settingsPrefix + SETTINGS.JQUERY_MIGRATE ]: settingsData[ SETTINGS.JQUERY_MIGRATE ] ? 'true' : '',
			[ settingsPrefix + SETTINGS.OEMBED_SCRIPT ]: settingsData[ SETTINGS.OEMBED_SCRIPT ] ? 'true' : '',
			[ settingsPrefix + SETTINGS.CLASSIC_THEME_STYLES ]: settingsData[ SETTINGS.CLASSIC_THEME_STYLES ] ? 'true' : '',
			[ settingsPrefix + SETTINGS.GUTENBERG ]: settingsData[ SETTINGS.GUTENBERG ] ? 'true' : '',
			[ settingsPrefix + SETTINGS.HELLO_STYLE ]: settingsData[ SETTINGS.HELLO_STYLE ] ? 'true' : '',
			[ settingsPrefix + SETTINGS.HELLO_THEME ]: settingsData[ SETTINGS.HELLO_THEME ] ? 'true' : '',
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
					[ SETTINGS.DESCRIPTION_META_TAG ]: response[ settingsPrefix + SETTINGS.DESCRIPTION_META_TAG ],
					[ SETTINGS.SKIP_LINK ]: response[ settingsPrefix + SETTINGS.SKIP_LINK ],
					[ SETTINGS.PAGE_TITLE ]: response[ settingsPrefix + SETTINGS.PAGE_TITLE ],
					[ SETTINGS.GENERATOR ]: response[ settingsPrefix + SETTINGS.GENERATOR ],
					[ SETTINGS.SHORTLINK ]: response[ settingsPrefix + SETTINGS.SHORTLINK ],
					[ SETTINGS.WLW ]: response[ settingsPrefix + SETTINGS.WLW ],
					[ SETTINGS.RSD ]: response[ settingsPrefix + SETTINGS.RSD ],
					[ SETTINGS.OEMBED ]: response[ settingsPrefix + SETTINGS.OEMBED ],
					[ SETTINGS.WP_SITEMAP ]: response[ settingsPrefix + SETTINGS.WP_SITEMAP ],
					[ SETTINGS.POST_PREV_NEXT ]: response[ settingsPrefix + SETTINGS.POST_PREV_NEXT ],
					[ SETTINGS.SITE_RSS ]: response[ settingsPrefix + SETTINGS.SITE_RSS ],
					[ SETTINGS.COMMENTS_RSS ]: response[ settingsPrefix + SETTINGS.COMMENTS_RSS ],
					[ SETTINGS.POST_COMMENTS_RSS ]: response[ settingsPrefix + SETTINGS.POST_COMMENTS_RSS ],
					[ SETTINGS.EMOJI ]: response[ settingsPrefix + SETTINGS.EMOJI ],
					[ SETTINGS.JQUERY_MIGRATE ]: response[ settingsPrefix + SETTINGS.JQUERY_MIGRATE ],
					[ SETTINGS.OEMBED_SCRIPT ]: response[ settingsPrefix + SETTINGS.OEMBED_SCRIPT ],
					[ SETTINGS.CLASSIC_THEME_STYLES ]: response[ settingsPrefix + SETTINGS.CLASSIC_THEME_STYLES ],
					[ SETTINGS.GUTENBERG ]: response[ settingsPrefix + SETTINGS.GUTENBERG ],
					[ SETTINGS.HELLO_STYLE ]: response[ settingsPrefix + SETTINGS.HELLO_STYLE ],
					[ SETTINGS.HELLO_THEME ]: response[ settingsPrefix + SETTINGS.HELLO_THEME ],
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

		fetchSettings();
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
