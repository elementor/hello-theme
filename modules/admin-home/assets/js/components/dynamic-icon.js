import React, { useState, useEffect } from 'react';
import { BrandYoutubeIcon } from '../icons/youtube';
import { BrandElementorIcon } from '../icons/elementor';

const componentMap = {
	BrandYoutubeIcon,
	BrandElementorIcon,
};

const DynamicIcon = ( { componentName, ...rest } ) => {
    const [ Component, setComponent ] = useState( null );

    useEffect( () => {
		if ( componentMap[ componentName ] ) {
			setComponent( () => componentMap[ componentName ] );
			return;
		}

        import( `@elementor/icons/${ componentName }` ).then( ( module ) => {
            setComponent( () => module.default );
        } ).catch( ( error ) => {
            console.error( `Error loading component ${ componentName }:`, error );
        } );
    }, [ componentName ] );

    if ( ! Component ) {
        return null;
    }

    return <Component { ...rest } />;
};

export default DynamicIcon;
