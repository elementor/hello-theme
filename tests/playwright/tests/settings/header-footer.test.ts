import { parallelTest as test } from '../../parallelTest.ts';
import { expect } from '@playwright/test';
import SettingsPage from '../../pages/settings-page.ts';

test.describe.serial( 'Header and Footer Setting - Behavior Tests', () => {
	test.beforeEach( async ( { page, apiRequests }, testInfo ) => {
		const settingsPage = new SettingsPage( page, testInfo, apiRequests );
		await settingsPage.gotoSettingsPage();
		await settingsPage.waitForPageLoad();
		await settingsPage.clickTab( 'Structure and layout' );
	} );

	test( 'should show header and footer by default when setting is disabled', async ( { page, apiRequests }, testInfo ) => {
		const settingsPage = new SettingsPage( page, testInfo, apiRequests );
		const headerFooterCheckbox = settingsPage.getCheckboxBySetting( 'Disable theme header and footer' );

		const isChecked = await headerFooterCheckbox.isChecked();
		if ( isChecked ) {
			await settingsPage.toggleSetting( 'Disable theme header and footer' );
		}

		await page.goto( '/' );

		const header = page.locator( 'header#site-header.site-header' );
		const footer = page.locator( 'footer#site-footer.site-footer' );

		await expect( header ).toBeAttached();
		await expect( footer ).toBeAttached();
	} );

	test( 'should hide header and footer when setting is enabled', async ( { page, apiRequests }, testInfo ) => {
		const settingsPage = new SettingsPage( page, testInfo, apiRequests );

		const headerFooterCheckbox = settingsPage.getCheckboxBySetting( 'Disable theme header and footer' );
		const isChecked = await headerFooterCheckbox.isChecked();
		if ( ! isChecked ) {
			await settingsPage.toggleSetting( 'Disable theme header and footer' );
		}

		await page.goto( '/' );

		const header = page.locator( 'header#site-header.site-header' );
		const footer = page.locator( 'footer#site-footer.site-footer' );

		await expect( header ).not.toBeAttached();
		await expect( footer ).not.toBeAttached();
	} );
} );
