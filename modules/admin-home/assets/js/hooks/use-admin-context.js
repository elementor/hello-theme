import { useContext } from 'react';
import { AdminContext } from '../providers/admin-provider';

export const useAdminContext = () => {
	return useContext( AdminContext );
};
