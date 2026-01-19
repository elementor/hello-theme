'use client';
import * as React from 'react';
import SvgIcon from '@elementor/ui/SvgIcon';

const BrandElementorIcon = React.forwardRef< SVGSVGElement, React.ComponentProps<typeof SvgIcon> >( ( props, ref ) => {
	return (
		<SvgIcon viewBox="0 0 21 20" { ...props } ref={ ref }>
			<path d="M10.0429 0C4.49418 0 0 4.475 0 10C0 15.525 4.49418 20 10.0429 20C15.5915 20 20.0857 15.525 20.0857 10C20.0857 4.475 15.5915 0 10.0429 0ZM7.03 15H5.02143V5H7.03V15ZM15.0643 15H9.03857V13H15.0643V15ZM15.0643 11H9.03857V9H15.0643V11ZM15.0643 7H9.03857V5H15.0643V7Z" fill="black" />
		</SvgIcon>
	);
} );

export default BrandElementorIcon;
