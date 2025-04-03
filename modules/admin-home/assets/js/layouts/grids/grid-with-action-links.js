import Grid from '@elementor/ui/Grid';
import { PromotionsList } from '../../components/promotions/list';
import useMediaQuery from '@elementor/ui/useMediaQuery';

export const GridWithActionLinks = ( { children } ) => {
	const isSmallScreen = useMediaQuery( ( theme ) => theme.breakpoints.down( 'sm' ) );

	return (
		<Grid container spacing={ 2 } >
			<Grid item sx={ { p: 0 } } xs={ 12 } sm={ isSmallScreen ? 12 : true } md={ isSmallScreen ? 12 : true } lg={ isSmallScreen ? 12 : true } xl={ isSmallScreen ? 12 : true }>
				{ children }
			</Grid>
			{ ! isSmallScreen && (
				<Grid item sx={ { p: 0 } } xs={ 12 } sm={ 12 } md={ 12 } lg={ 3 } xl={ 3 } style={ { maxWidth: 300 } }>
					<PromotionsList />
				</Grid>
			) }
		</Grid>
	);
};
