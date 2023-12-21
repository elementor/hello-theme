import { __ } from '@wordpress/i18n';
import { ActionLinks } from '../components/action-links.js';

const actionLinks = {
	'install-elementor':
		{
			image: helloAdminData.templateDirectoryURI + '/assets/images/elementor.svg',
			title: __( 'Install Elementor', 'hello-elementor' ),
			description: __( 'Gain full control over your website’s design with the Elementor Page Builder.', 'hello-elementor' ),
			buttonText: __( 'Install Elementor', 'hello-elementor' ),
			link: helloAdminData.actionLinkURL,
		},
	'activate-elementor':
		{
			image: helloAdminData.templateDirectoryURI + '/assets/images/elementor.svg',
			title: __( 'Activate Elementor', 'hello-elementor' ),
			description: __( 'Gain full control over your website’s design with the Elementor Page Builder.', 'hello-elementor' ),
			buttonText: __( 'Activate Elementor', 'hello-elementor' ),
			link: helloAdminData.actionLinkURL,
		},
	'activate-header-footer-experiment':
		{
			image: helloAdminData.templateDirectoryURI + '/assets/images/elementor.svg',
			title: __( 'Style using Elementor', 'hello-elementor' ),
			description: __( 'Design your cross-site header & footer using Elementor, from the "Site Settings" panel.', 'hello-elementor' ),
			buttonText: __( 'Activate Hello theme header & footer experiment', 'hello-elementor' ),
			link: helloAdminData.actionLinkURL,
		},
	'style-header-footer':
		{
			image: helloAdminData.templateDirectoryURI + '/assets/images/elementor.svg',
			title: __( 'Style cross-site header & footer', 'hello-elementor' ),
			description: __( 'Customize your cross-site header & footer from Elementor’s "Site Settings" panel.', 'hello-elementor' ),
			buttonText: __( 'Start Designing', 'hello-elementor' ),
			link: helloAdminData.actionLinkURL,
		},
};

export const ActionLinksPanel = () => {
	if ( ! helloAdminData.actionLinkType ) {
		return;
	}

	return <ActionLinks { ...actionLinks[ helloAdminData.actionLinkType ] } />;
};
