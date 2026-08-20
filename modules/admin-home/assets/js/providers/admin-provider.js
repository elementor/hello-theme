import { createContext, useEffect } from 'react';
import apiFetch from '@wordpress/api-fetch';

export const AdminContext = createContext();

export const AdminProvider = ({ children, initialSettings = null }) => {
	const [isLoading, setIsLoading] = React.useState(!initialSettings);
	const [adminSettings, setAdminSettings] = React.useState(
		initialSettings || {},
	);

	useEffect(() => {
		if (initialSettings) {
			return;
		}

		apiFetch({ path: '/elementor-hello-elementor/v1/admin-settings' })
			.then((settings) => {
				setAdminSettings(settings.config);
			})
			.finally(() => {
				setIsLoading(false);
			});
	}, [initialSettings]);

	return (
		<AdminContext.Provider
			value={{
				adminSettings,
				isLoading,
			}}
		>
			{children}
		</AdminContext.Provider>
	);
};
