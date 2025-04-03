import { createContext, useEffect } from 'react';
import apiFetch from '@wordpress/api-fetch';

export const AdminContext = createContext();

export const AdminProvider = ( { children } ) => {
	const [ isLoading, setIsLoading ] = React.useState( true );
	const [ promotionsLinks, setPromotionsLinks ] = React.useState( [] );
	const [ adminSettings, setAdminSettings ] = React.useState( {} );

	useEffect( () => {
		Promise.all( [
			apiFetch( { path: '/elementor-hello-elementor/v1/promotions' } ),
			apiFetch( { path: '/elementor-hello-elementor/v1/admin-settings' } ),
		] ).then( ( [ links, settings ] ) => {
			setPromotionsLinks( links.links );
			setAdminSettings( settings.config );
		} ).finally( () => {
			setIsLoading( false );
		} );
	}, [] );

	return (
		<AdminContext.Provider value={ {
			promotionsLinks,
			adminSettings,
			isLoading,
		} }>
			{ children }
		</AdminContext.Provider>
	);
};
