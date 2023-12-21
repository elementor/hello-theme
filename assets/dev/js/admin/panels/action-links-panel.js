import { __ } from '@wordpress/i18n';
import { ActionLinks } from '../components/action-links.js';

const actionLinks = {
	'install-elementor':
		{
			image: helloAdminData.templateDirectoryUri + '/assets/images/elementor.svg',
			title: __( 'Install Elementor', 'hello-elementor' ),
			description: __( 'Gain full control over your website’s design with the Elementor Page Builder.', 'hello-elementor' ),
			buttonText: __( 'Install Elementor', 'hello-elementor' ),
			link: helloAdminData.linkInstalledElementor,
		},
	'activate-elementor':
		{
			image: helloAdminData.templateDirectoryUri + '/assets/images/elementor.svg',
			title: __( 'Activate Elementor', 'hello-elementor' ),
			description: __( 'Gain full control over your website’s design with the Elementor Page Builder.', 'hello-elementor' ),
			buttonText: __( 'Activate Elementor', 'hello-elementor' ),
			link: helloAdminData.linkActivateElementor,
		},
	'activate-header-footer-experiment':
		{
			image: helloAdminData.templateDirectoryUri + '/assets/images/elementor.svg',
			title: __( 'Style using Elementor', 'hello-elementor' ),
			description: __( 'Design your cross-site header & footer using Elementor, from the "Site Settings" panel.', 'hello-elementor' ),
			buttonText: __( 'Activate Hello theme header & footer experiment', 'hello-elementor' ),
			link: helloAdminData.linkHelloExperiment,
		},
	'style-header-footer':
		{
			image: helloAdminData.templateDirectoryUri + '/assets/images/elementor.svg',
			title: __( 'Style cross-site header & footer', 'hello-elementor' ),
			description: __( 'Customize your cross-site header & footer from Elementor’s "Site Settings" panel.', 'hello-elementor' ),
			buttonText: __( 'Start Designing', 'hello-elementor' ),
			link: helloAdminData.linkStyleHeaderFooter,
		},
};

export const ActionLinksPanel = () => {
	let upsellType = '';

	if ( ! helloAdminData.isElementorInstalled ) {
		upsellType = 'install-elementor';
	} else if ( ! helloAdminData.isElementorActive ) {
		upsellType = 'activate-elementor';
	} else if ( helloAdminData.isHelloHeaderFooterActive && ! helloAdminData.isHelloExperimentActive ) {
		upsellType = 'activate-header-footer-experiment';
	} else if ( helloAdminData.isHelloHeaderFooterActive ) {
		upsellType = 'style-header-footer';
	} else {
		return;
	}

	return <ActionLinks { ...actionLinks[ upsellType ] } />;
};
