import { parallelTest as test } from '../../parallelTest.ts';
import { expect } from '@playwright/test';

test.describe( 'Hello Theme Admin Home Page', () => {
	test.beforeEach( async ( { page } ) => {
		await page.goto( '/wp-admin/admin.php?page=hello-elementor' );
	} );

	test( 'should display Welcome to Hello Theme message and take screenshot', async ( { page } ) => {
		const welcomeSection = page.locator( 'text=Go Pro, Go Limitless' ).locator( '..' ).locator( '..' );
		await expect.soft( welcomeSection ).toHaveScreenshot( 'welcome-section.png' );
	} );

	test( 'should display Quick Links section', async ( { page } ) => {
		const quickLinksHeading = page.locator( 'h6:has-text("Quick Links")' );
		await expect( quickLinksHeading ).toBeVisible();
		await expect( quickLinksHeading ).toContainText( 'Quick Links' );
		const quickLinksSection = page.locator( 'text=Quick Links' ).locator( '..' ).locator( '..' );
		await expect( quickLinksSection ).toContainText( 'These quick actions will get your site airborne in a flash.' );
		const expectedQuickLinks = [
			'Site Name',
			'Site Logo',
			'Site Favicon',
			'Site Colors',
			'Site Fonts',
		];
		for ( const linkText of expectedQuickLinks ) {
			const linkElement = page.locator( `h6:has-text("${ linkText }")` );
			await expect( linkElement ).toBeVisible();
		}
	} );

	test( 'should navigate to correct pages from Quick Links', async ( { page } ) => {
		const quickLinksTests = [
			{
				linkText: 'Site Name',
				expectedUrlPattern: /post\.php\?post=\d+&action=elementor.*active-tab=settings-site-identity/,
				expectedPageSection: '.elementor-control-section_settings-site-identity',
			},
			{
				linkText: 'Site Logo',
				expectedUrlPattern: /post\.php\?post=\d+&action=elementor.*active-tab=settings-site-identity/,
				expectedPageSection: '.elementor-control-section_settings-site-identity',
			},
			{
				linkText: 'Site Favicon',
				expectedUrlPattern: /post\.php\?post=\d+&action=elementor.*active-tab=settings-site-identity/,
				expectedPageSection: '.elementor-control-section_settings-site-identity',
			},
			{
				linkText: 'Site Colors',
				expectedUrlPattern: /post\.php\?post=\d+&action=elementor.*active-tab=global-colors/,
				expectedPageSection: '.elementor-control-section_global_colors',
			},
			{
				linkText: 'Site Fonts',
				expectedUrlPattern: /post\.php\?post=\d+&action=elementor.*active-tab=global-typography/,
				expectedPageSection: '.elementor-control-section_text_style',
			},
		];
		for ( const linkTest of quickLinksTests ) {
			await page.goto( '/wp-admin/admin.php?page=hello-elementor' );
			const linkElement = page.locator( `h6:has-text("${ linkTest.linkText }") a` );
			await expect( linkElement ).toBeVisible();

			if ( !! process.env.DAILY_MATRIX_WORKFLOW ) {
				// Skip this test in Daily Matrix workflow due to artifact deployment timing issues
				continue;
			}

			await Promise.all( [
				page.waitForURL( linkTest.expectedUrlPattern ),
				linkElement.click(),
			] );

			expect( page.url() ).toMatch( linkTest.expectedUrlPattern );

			await page.waitForSelector( '#elementor-kit-panel' );
			const location = page.locator( linkTest.expectedPageSection );
			await expect( location ).toBeVisible();
		}
	} );
} );
