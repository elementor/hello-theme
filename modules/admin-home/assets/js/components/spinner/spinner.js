import CircularProgress from '@elementor/ui/CircularProgress';
import Box from '@elementor/ui/Box';

const Spinner = () => {
	const style = {
		position: 'fixed',
		top: 0,
		left: 0,
		width: '100%',
		height: '100%',
		display: 'flex',
		justifyContent: 'center',
		alignItems: 'center',
		background: 'rgba(255, 255, 255, 0.8)', // Optional: to add a semi-transparent background
		zIndex: 1000, // Optional: to ensure the spinner is on top
	};

	return (
		<Box style={ style }>
			<CircularProgress />
		</Box>
	);
};

export default Spinner;
