import Box from '@elementor/ui/Box';
import Typography from '@elementor/ui/Typography';

export default function Update( { title, description } ) {
	const parser = new DOMParser();
	const doc = parser.parseFromString( description, 'text/html' );
	const listItems = doc.querySelectorAll( 'li' );

	const extractedContent = Array.from( listItems ).map( ( item ) => item.textContent.trim() );
	const descriptionToShow = extractedContent.join( '\n' );
    return (
	<Box sx={ { py: 2, px: 3 } }>
		<Typography variant={ 'subtitle1' } sx={ { pb: 0.75 } }>{ title }</Typography>
		<Typography variant={ 'body2' } sx={ { whiteSpace: 'pre-line' } }>{ descriptionToShow }</Typography>
	</Box>
    );
}
