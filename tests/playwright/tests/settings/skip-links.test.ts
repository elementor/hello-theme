import { parallelTest as test } from '../../parallelTest.ts';
import { expect } from '@playwright/test';
import SettingsPage from '../../pages/settings-page.ts';

test.describe.serial( 'Skip Links Setting - Behavior Tests', () => {
	test.beforeEach( async ( { page, apiRequests }, testInfo ) => {
		const settingsPage = new SettingsPage( page, testInfo, apiRequests );
		await settingsPage.gotoSettingsPage();
		await settingsPage.waitForPageLoad();
		await settingsPage.clickTab( 'SEO and accessibility' );
	} );

	test( 'should show skip link by default when setting is disabled', async ( { page, apiRequests }, testInfo ) => {
		const settingsPage = new SettingsPage( page, testInfo, apiRequests );
		const skipLinkCheckbox = settingsPage.getCheckboxBySetting( 'Disable skip links' );

		const isChecked = await skipLinkCheckbox.isChecked();
		if ( isChecked ) {
			await settingsPage.toggleSetting( 'Disable skip links' );
		}

		await page.goto( '/' );

		const skipLink = page.locator( 'a.skip-link.screen-reader-text[href="#content"]' );
		await expect( skipLink ).toBeAttached();
		await expect( skipLink ).toHaveText( 'Skip to content' );
	} );

	test( 'should hide skip link when setting is enabled', async ( { page, apiRequests }, testInfo ) => {
		const settingsPage = new SettingsPage( page, testInfo, apiRequests );

		const skipLinkCheckbox = settingsPage.getCheckboxBySetting( 'Disable skip links' );
		const isChecked = await skipLinkCheckbox.isChecked();
		if ( ! isChecked ) {
			await settingsPage.toggleSetting( 'Disable skip links' );
		}

		await page.goto( '/' );

		const skipLink = page.locator( 'a.skip-link.screen-reader-text[href="#content"]' );
		await expect( skipLink ).not.toBeAttached();
	} );

	test( 'should verify skip link functionality when visible', async ( { page, apiRequests }, testInfo ) => {
		const settingsPage = new SettingsPage( page, testInfo, apiRequests );

		const skipLinkCheckbox = settingsPage.getCheckboxBySetting( 'Disable skip links' );
		const isChecked = await skipLinkCheckbox.isChecked();
		if ( isChecked ) {
			await settingsPage.toggleSetting( 'Disable skip links' );
		}

		await page.goto( '/' );

		const skipLink = page.locator( 'a.skip-link.screen-reader-text[href="#content"]' );
		await expect( skipLink ).toBeAttached();

		await skipLink.focus();
		await skipLink.click();

		await expect( page ).toHaveURL( /#content$/ );
	} );
} );
