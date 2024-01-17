import { __ } from '@wordpress/i18n';
import { ActionLinks } from '../components/action-links.js';

const actionLinks = {
	'install-elementor':
		{
			image: helloAdminData.templateDirectoryURI + '/assets/images/elementor.svg',
			alt: __( 'Elementor', 'hello-elementor' ),
			title: __( 'Install Elementor', 'hello-elementor' ),
			message: __( 'Create cross-site header & footer using Elementor.', 'hello-elementor' ),
			button: __( 'Install Elementor', 'hello-elementor' ),
			link: helloAdminData.actionLinkURL,
		},
	'activate-elementor':
		{
			image: helloAdminData.templateDirectoryURI + '/assets/images/elementor.svg',
			alt: __( 'Elementor', 'hello-elementor' ),
			title: __( 'Activate Elementor', 'hello-elementor' ),
			message: __( 'Create cross-site header & footer using Elementor.', 'hello-elementor' ),
			button: __( 'Activate Elementor', 'hello-elementor' ),
			link: helloAdminData.actionLinkURL,
		},
	'activate-header-footer-experiment':
		{
			image: helloAdminData.templateDirectoryURI + '/assets/images/elementor.svg',
			alt: __( 'Elementor', 'hello-elementor' ),
			title: __( 'Style using Elementor', 'hello-elementor' ),
			message: __( 'Design your cross-site header & footer from Elementor’s "Site Settings" panel.', 'hello-elementor' ),
			button: __( 'Activate header & footer experiment', 'hello-elementor' ),
			link: helloAdminData.actionLinkURL,
		},
	'style-header-footer':
		{
			image: helloAdminData.templateDirectoryURI + '/assets/images/elementor.svg',
			alt: __( 'Elementor', 'hello-elementor' ),
			title: __( 'Style cross-site header & footer', 'hello-elementor' ),
			message: __( 'Customize your cross-site header & footer from Elementor’s "Site Settings" panel.', 'hello-elementor' ),
			button: __( 'Start Designing', 'hello-elementor' ),
			link: helloAdminData.actionLinkURL,
		},
};

export const ActionLinksPanel = () => {
	if ( ! helloAdminData.actionLinkType ) {
		return;
	}

	return <ActionLinks { ...actionLinks[ helloAdminData.actionLinkType ] } />;
};
