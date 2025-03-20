import Stack from '@elementor/ui/Stack';
import Box from '@elementor/ui/Box';
import Typography from '@elementor/ui/Typography';
import Switch from '@elementor/ui/Switch';

export const Setting = ( { label, value, onSwitchClick, code, description, tip } ) => {
	return (
		<Stack direction="column" spacing={ 2 }>
			<Stack direction="row" spacing={ 2 }>
				<Box sx={ { minWidth: 80, height: 38 } }>
					<Box display="inline-flex" alignItems="center" justifyContent="center" height="100%">
						<Switch onClick={ onSwitchClick } checked={ value } />
					</Box>
				</Box>
				<Box sx={ { height: 38, width: '100%' } }>
					<Box display="flex" alignItems="center" justifyContent="flex-start" height="100%" width="fit-content">
						<Typography variant="subtitle1" sx={ { fontWeight: 700 } }>{ label }</Typography>
					</Box>
				</Box>
			</Stack>
			<Stack direction="row" spacing={ 2 }>
				<Box sx={ { minWidth: 80 } }>
					<Box height="100%" />
				</Box>
				<Box sx={ { width: '100%' } }>
					<Box height="100%">
						<Typography variant="body1" sx={ { py: 1, fontWeight: 500 } }>{ description }</Typography>
						<Typography variant="body2" sx={ { py: 1, fontWeight: 400, mb: 2 } }>{ tip }</Typography>
						<Typography component="code" color="text.tertiary" variant="body2" sx={ { fontFamily: 'Courier New' } }>
							{ code }
						</Typography>
					</Box>
				</Box>
			</Stack>
		</Stack>
	);
};
