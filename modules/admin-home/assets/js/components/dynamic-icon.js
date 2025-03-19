import React, { useState, useEffect } from 'react';

const componentMap = {
	BrandYoutubeIcon: () => import( '../icons/youtube' ),
	BrandElementorIcon: () => import( '../icons/elementor' ),
	ThemeBuilderIcon: () => import( '@elementor/icons/ThemeBuilderIcon' ),
	SettingsIcon: () => import( '@elementor/icons/SettingsIcon' ),
	BrandFacebookIcon: () => import( '@elementor/icons/BrandFacebookIcon' ),
	StarIcon: () => import( '@elementor/icons/StarIcon' ),
	HelpIcon: () => import( '@elementor/icons/HelpIcon' ),
	SpeakerphoneIcon: () => import( '@elementor/icons/SpeakerphoneIcon' ),
	TextIcon: () => import( '@elementor/icons/TextIcon' ),
	PhotoIcon: () => import( '@elementor/icons/PhotoIcon' ),
	AppsIcon: () => import( '@elementor/icons/AppsIcon' ),
	BrushIcon: () => import( '@elementor/icons/BrushIcon' ),
	UnderlineIcon: () => import( '@elementor/icons/UnderlineIcon' ),
	PagesIcon: () => import( '@elementor/icons/PagesIcon' ),
	PageTypeIcon: () => import( '@elementor/icons/PageTypeIcon' ),
};

const DynamicIcon = ( { componentName, ...rest } ) => {
    const [ Component, setComponent ] = useState( null );

	useEffect( () => {
		if ( componentMap[ componentName ] ) {
			componentMap[ componentName ]().then( ( module ) => {
				setComponent( () => module.default );
			} );
		}
	}, [ componentName ] );

    if ( ! Component ) {
        return null;
    }

    return <Component { ...rest } />;
};

export default DynamicIcon;
