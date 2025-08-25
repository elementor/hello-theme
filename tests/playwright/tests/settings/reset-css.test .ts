import { parallelTest as test } from '../../parallelTest.ts';
import { expect } from '@playwright/test';
import SettingsPage from '../../pages/settings-page.ts';

test.describe.serial( 'Reset CSS Setting - Behavior Tests', () => {
	test.beforeEach( async ( { page, apiRequests }, testInfo ) => {
		const settingsPage = new SettingsPage( page, testInfo, apiRequests );
		await settingsPage.gotoSettingsPage();
		await settingsPage.waitForPageLoad();
		await settingsPage.clickTab( 'CSS and styling control' );
	} );

	test( 'should load reset.css by default when setting is disabled', async ( { page, apiRequests }, testInfo ) => {
		const settingsPage = new SettingsPage( page, testInfo, apiRequests );
		const themeCssCheckbox = settingsPage.getCheckboxBySetting( 'Deregister Hello reset.css' );

		const isChecked = await themeCssCheckbox.isChecked();
		if ( isChecked ) {
			await settingsPage.toggleSetting( 'Deregister Hello reset.css' );
		}

		const cssRequests: string[] = [];
		page.on( 'request', ( request ) => {
			if ( request.url().includes( '.css' ) ) {
				cssRequests.push( request.url() );
			}
		} );

		await page.goto( '/' );

		const themeCssLoaded = cssRequests.some( ( url ) =>
			url.includes( '/hello-theme/assets/css/reset.css' ),
		);

		expect( themeCssLoaded ).toBeTruthy();

		const themeCssLink = page.locator( 'link[rel="stylesheet"][href*="hello-theme"][href*="reset.css"]' );
		await expect( themeCssLink ).toBeAttached();
	} );

	test( 'should not load reset.css when setting is enabled', async ( { page, apiRequests }, testInfo ) => {
		const settingsPage = new SettingsPage( page, testInfo, apiRequests );

		const themeCssCheckbox = settingsPage.getCheckboxBySetting( 'Deregister Hello reset.css' );
		const isChecked = await themeCssCheckbox.isChecked();
		if ( ! isChecked ) {
			await settingsPage.toggleSetting( 'Deregister Hello reset.css' );
		}

		const cssRequests: string[] = [];
		page.on( 'request', ( request ) => {
			if ( request.url().includes( '.css' ) ) {
				cssRequests.push( request.url() );
			}
		} );

		await page.goto( '/' );

		const themeCssLoaded = cssRequests.some( ( url ) =>
			url.includes( '/hello-theme/assets/css/reset.css' ),
		);

		expect( themeCssLoaded ).toBeFalsy();

		const themeCssLink = page.locator( 'link[rel="stylesheet"][href*="hello-theme"][href*="reset.css"]' );
		await expect( themeCssLink ).not.toBeAttached();
	} );
} );
