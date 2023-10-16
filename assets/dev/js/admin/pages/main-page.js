import { useState, useEffect, Fragment } from 'react';
import { store as noticesStore } from '@wordpress/notices';
import { dispatch, useDispatch, useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';
import api from '@wordpress/api';
import { Button, Panel, Placeholder, Spinner, SnackbarList } from '@wordpress/components';
import { SETTINGS } from './settings.js';
import { PanelThemeFeatures } from './panels/theme-features.js';
import { PanelHeadCleanup } from './panels/head-cleanup.js';
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
		const data = {};

		Object.values( SETTINGS ).forEach( ( value ) => data[ `${ settingsPrefix }${ value }` ] = settingsData[ value ] ? 'true' : '' );

		const settings = new api.models.Settings( data );

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

				const data = {};
				Object.values( SETTINGS ).forEach( ( value ) => data[ value ] = response[ `${ settingsPrefix }${ value }` ] );

				setSettingsData( data );
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
						<h1>{ __( 'Hello Theme Settings', 'hello-elementor' ) }</h1>
					</div>
				</div>
			</div>
			<div className="hello_elementor__main">
				<Panel>

					<PanelThemeFeatures { ...{ settingsData, updateSettings } } />

					<PanelHeadCleanup { ...{ settingsData, updateSettings } } />

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
