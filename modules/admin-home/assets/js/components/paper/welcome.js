import Typography from '@elementor/ui/Typography';
import { __ } from '@wordpress/i18n';
import { useAdminContext } from '../../hooks/use-admin-context';
import Stack from '@elementor/ui/Stack';
import Button from '@elementor/ui/Button';
import { BaseAdminPaper } from './base-admin-paper';
import { useEffect, useRef, useState } from 'react';
import Box from '@elementor/ui/Box';

export const Welcome = ( { sx, dismissable = false } ) => {
	const { adminSettings: {
		config: { nonceInstall = '', disclaimer = '', slug = '' } = {},
		welcome: { title = '', text = '', buttons = [], image: { src = '', alt = '' } = {} } = {},
	} = {},
	} = useAdminContext();

	const [ isLoading, setIsLoading ] = useState( false );
	const [ visible, setVisible ] = useState( true );
	const [ imageWidth, setImageWidth ] = useState( 578 );
	const parentRef = useRef( null );

	useEffect( () => {
		const handleResize = () => {
			if ( parentRef.current ) {
				const parentWidth = parentRef.current.offsetWidth;
				setImageWidth( parentWidth < 800 ? 400 : 578 );
			}
		};

		handleResize();
		window.addEventListener( 'resize', handleResize );

		return () => {
			window.removeEventListener( 'resize', handleResize );
		};
	}, [] );

	if ( ! title || ! visible ) {
		return null;
	}

	return (
		<BaseAdminPaper sx={ sx }>
			{ dismissable && (
				<Box component="button" className="notice-dismiss" onClick={ async () => {
					try {
						await wp.ajax.post( 'ehe_dismiss_theme_notice', { nonce: window.ehe_cb.nonce } );
						setVisible( false );
					} catch ( e ) {
					}
				} }>
					<Box component="span" className="screen-reader-text">{ __( 'Dismiss this notice.', 'hello-elementor' ) }</Box>
				</Box>
			) }
			<Stack ref={ parentRef } direction={ { xs: 'column', md: 'row' } } alignItems="center" justifyContent="space-between" sx={ { width: '100%', gap: 9 } }>
				<Stack direction="column" sx={ { flex: 1 } }>
					<Typography variant="h6" sx={ { color: 'text.primary', fontWeight: 500 } }>{ title }</Typography>
					<Typography variant="body2" sx={ { mb: 3, color: 'text.secondary' } }>
						{ text }
					</Typography>
					<Stack gap={ 1 } direction="row" sx={ { mb: 2 } }>
						{
					buttons.map( ( { linkText, link, variant, color, target = '' } ) => {
						const onClick = async () => {
							if ( 'install' === link ) {
								try {
									const data = {
										_wpnonce: nonceInstall,
										slug,
									};

									setIsLoading( true );

									const response = await wp.ajax.post( 'ehe_install_elementor', data );

									if ( response.activateUrl ) {
										window.location.href = response.activateUrl;
									} else {
										throw new Error();
									}
								} catch ( error ) {
									// eslint-disable-next-line no-alert
									alert( __( 'Currently the plugin isn’t available. Please try again later. You can also contact our support at: wordpress.org/plugins/hello-plus', 'hello-elementor' ) );
								} finally {
									setIsLoading( false );
								}
							} else {
								window.open( link, target || '_self' );
							}
						};

						return (
							<Button key={ linkText } onClick={ onClick } variant={ variant } color={ color } >
								{ isLoading ? __( 'Installing Elementor', 'hello-elementor' ) : linkText }
							</Button>
						);
					} )
				}
					</Stack>
					{ disclaimer && ( <Typography variant="body2" sx={ { color: 'text.tertiary' } }>
						{ disclaimer }
					</Typography> ) }
				</Stack>
				{ src && ( <Box
					component="img"
					src={ src }
					sx={ {
						width: { sm: 350, md: 450, lg: imageWidth },
						aspectRatio: '289/98',
						flex: 1,
					} }
				/> ) }
			</Stack>
		</BaseAdminPaper>
	);
};
