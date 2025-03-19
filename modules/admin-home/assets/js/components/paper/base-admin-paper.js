import Paper from '@elementor/ui/Paper';

export const BaseAdminPaper = ( { children, sx = { px: 4, py: 3 } } ) => {
	return (
		<Paper elevation={ 1 } sx={ sx }>
			{ children }
		</Paper>
	);
};
