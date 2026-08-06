import { createContext, useEffect } from 'react';
import apiFetch from '@wordpress/api-fetch';

export const AdminContext = createContext();

export const AdminProvider = ({ children }) => {
	const [isLoading, setIsLoading] = React.useState(true);
	const [adminSettings, setAdminSettings] = React.useState({});

	useEffect(() => {
		apiFetch({ path: '/elementor-hello-elementor/v1/admin-settings' })
			.then((settings) => {
				setAdminSettings(settings.config);
			})
			.finally(() => {
				setIsLoading(false);
			});
	}, []);

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
