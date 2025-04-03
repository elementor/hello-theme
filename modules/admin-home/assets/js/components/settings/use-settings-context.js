import { useContext } from 'react';
import { SettingsContext } from './settings-provider';

export const useSettingsContext = () => {
	return useContext( SettingsContext );
};
