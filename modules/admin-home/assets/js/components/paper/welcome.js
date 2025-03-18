import Typography from '@elementor/ui/Typography';
import { __ } from '@wordpress/i18n';
import { useAdminContext } from '../../hooks/use-admin-context';
import Stack from '@elementor/ui/Stack';
import Button from '@elementor/ui/Button';
import { BaseAdminPaper } from './base-admin-paper';
import { useState } from 'react';

export const Welcome = () => {
	const { adminSettings: {
		config: { nonceInstall = '', showText = false } = {},
		welcome: { text = '', buttons = [] } = {},
	} = {},
	} = useAdminContext();

	const [ isLoading, setIsLoading ] = useState( false );

	return (
		<BaseAdminPaper>
			<Typography variant="h6" sx={ { color: 'text.primary', fontWeight: 500 } }>{ __( 'Welcome to Hello Biz', 'hello-elementor' ) }</Typography>
			<Typography variant="body2" sx={ { mb: 3, color: 'text.secondary' } }>
				{ text }
			</Typography>
			<Stack gap={ 1 } direction="row" sx={ { mb: 2 } }>
				{
					buttons.map( ( { title, link, variant, color } ) => {
						const onClick = async () => {
							if ( 'install' === link ) {
								try {
									const data = {
										_wpnonce: nonceInstall,
										slug: 'hello-plus', // ToDo ensure this is the right slug, for now it is free.
									};

									setIsLoading( true );

									const response = await wp.ajax.post( 'hello_biz_install_hp', data );

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
								window.location.href = link;
							}
						};

						return (
							<Button key={ title } onClick={ onClick } variant={ variant } color={ color } >
								{ isLoading ? __( 'Installing Hello Plus', 'hello-elementor' ) : title }
							</Button>
						);
					} )
				}
			</Stack>
			{ showText && ( <Typography variant="body2" sx={ { color: 'text.tertiary' } }>
				{
					__(
						'By clicking "Begin setup" I agree to install and activate the Hello+ plugin.',
						'hello-elementor',
					)
				}
			</Typography> ) }
		</BaseAdminPaper>
	);
};
