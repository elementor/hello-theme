import { parallelTest as test } from '../../parallelTest.ts';
import { expect } from '@playwright/test';
import SettingsPage from '../../pages/settings-page.ts';

test.describe.serial( 'Page Title Setting - Behavior Tests', () => {
	let postId: string;

	test.beforeEach( async ( { page, apiRequests }, testInfo ) => {
		const settingsPage = new SettingsPage( page, testInfo, apiRequests );
		postId = await settingsPage.createNewBasicPost();
		await settingsPage.gotoSettingsPage();
		await settingsPage.waitForPageLoad();
		await settingsPage.clickTab( 'Structure and layout' );
	} );

	test( 'should hide page title when setting is checked', async ( { page, apiRequests, request }, testInfo ) => {
		const settingsPage = new SettingsPage( page, testInfo, apiRequests );
		const pageTitleCheckbox = settingsPage.getCheckboxBySetting( 'Hide page title' );

		const isChecked = await pageTitleCheckbox.isChecked();
		if ( ! isChecked ) {
			await settingsPage.toggleSetting( 'Hide page title' );
		}

		// Act - Navigate to the test post
		await page.goto( `/?p=${ postId }` );

		// Assert - Page title should be hidden
		const pageHeader = page.locator( '.page-header h1.entry-title' );
		await expect( pageHeader ).not.toBeAttached();
	} );

	test( 'should show page title when setting is unchecked', async ( { page, apiRequests, request }, testInfo ) => {
		const settingsPage = new SettingsPage( page, testInfo, apiRequests );
		const pageTitleCheckbox = settingsPage.getCheckboxBySetting( 'Hide page title' );
		const isChecked = await pageTitleCheckbox.isChecked();
		if ( isChecked ) {
			await settingsPage.toggleSetting( 'Hide page title' );
		}

		// Act - Navigate to the test post
		await page.goto( `/?p=${ postId }` );

		// Assert - Page title should be visible
		const pageHeader = page.locator( '.page-header h1.entry-title' );
		await expect( pageHeader ).toBeAttached();
		await expect( pageHeader ).toHaveText( 'Playwright Test Page #' + postId );
	} );
} );
