import Stack from '@elementor/ui/Stack';
import CheckedCircleIcon from '@elementor/icons/CheckedCircleIcon';
import Typography from '@elementor/ui/Typography';

export const Feature = ( { text } ) => {
	return (
		<Stack direction="row" gap={ 1 } alignItems="center">
			<CheckedCircleIcon color="promotion" />
			<Typography variant="body2">
				{ text }
			</Typography>
		</Stack>
	);
};
