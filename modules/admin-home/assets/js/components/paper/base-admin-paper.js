import Paper from '@elementor/ui/Paper';

export const BaseAdminPaper = ( { children } ) => {
	return (
		<Paper elevation={ 1 } sx={ { px: 4, py: 3 } }>
			{ children }
		</Paper>
	);
};
