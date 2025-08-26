import { parallelTest as test } from '../../parallelTest.ts';
import { expect } from '@playwright/test';
import SettingsPage from '../../pages/settings-page.ts';

test.describe.serial( 'Description Meta Tag Setting - Behavior Tests', () => {
	let postId: string;

	test.beforeEach( async ( { page, apiRequests }, testInfo ) => {
		const settingsPage = new SettingsPage( page, testInfo, apiRequests );
		postId = await settingsPage.createNewBasicPost();
		await settingsPage.gotoSettingsPage();
		await settingsPage.waitForPageLoad();
		await settingsPage.clickTab( 'SEO and accessibility' );
	} );

	test( 'should not show meta description on page when the "Disable description meta tag" setting is enabled', async ( { page, apiRequests }, testInfo ) => {
		const settingsPage = new SettingsPage( page, testInfo, apiRequests );
		const metaCheckbox = settingsPage.getCheckboxBySetting( 'Disable description meta tag' );

		const isChecked = await metaCheckbox.isChecked();
		if ( ! isChecked ) {
			await settingsPage.toggleSetting( 'Disable description meta tag' );
		}

		await page.goto( `/?p=${ postId }` );

		const metaDescription = page.locator( 'meta[name="description"]' );
		await expect( metaDescription ).not.toBeAttached();
	} );

	test( 'should show meta description on page when the "Disable description meta tag" setting is disabled', async ( { page, apiRequests }, testInfo ) => {
		const settingsPage = new SettingsPage( page, testInfo, apiRequests );
		const metaCheckbox = settingsPage.getCheckboxBySetting( 'Disable description meta tag' );

		const isChecked = await metaCheckbox.isChecked();
		if ( isChecked ) {
			await settingsPage.toggleSetting( 'Disable description meta tag' );
		}

		await page.goto( `/?p=${ postId }` );

		const metaDescription = page.locator( 'meta[name="description"]' );
		await expect( metaDescription ).toBeAttached();
	} );

	test( 'should not show meta description on home page when the "Disable description meta tag" setting is enabled', async ( { page, apiRequests }, testInfo ) => {
		const settingsPage = new SettingsPage( page, testInfo, apiRequests );
		const metaCheckbox = settingsPage.getCheckboxBySetting( 'Disable description meta tag' );

		const isChecked = await metaCheckbox.isChecked();
		if ( ! isChecked ) {
			await settingsPage.toggleSetting( 'Disable description meta tag' );
		}

		await page.goto( '/' );

		const metaDescription = page.locator( 'meta[name="description"]' );
		await expect( metaDescription ).not.toBeAttached();
	} );
} );
