'use client';
import * as React from 'react';
import SvgIcon from '@elementor/ui/SvgIcon';

const BrandElementorIcon = React.forwardRef< SVGSVGElement, React.ComponentProps<typeof SvgIcon> >( ( props, ref ) => {
	return (
		<SvgIcon viewBox="0 0 24 24" { ...props } ref={ ref }>
			<path
				fillRule="evenodd"
				clipRule="evenodd"
				d="M12 21C6.47715 21 2 16.5228 2 11C2 5.47715 6.47715 1 12 1C17.5228 1 22 5.47715 22 11C22 16.5228 17.5228 21 12 21ZM12 3C7.58172 3 4 6.58172 4 11C4 15.4183 7.58172 19 12 19C16.4183 19 20 15.4183 20 11C20 6.58172 16.4183 3 12 3Z"
			/>
			<path d="M8.5 7H10V15H8.5V7Z" />
			<path d="M11.5 7H16V9H11.5V7Z" />
			<path d="M11.5 10H16V12H11.5V10Z" />
			<path d="M11.5 13H16V15H11.5V13Z" />
		</SvgIcon>
	);
} );

export default BrandElementorIcon;
