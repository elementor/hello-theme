import { parallelTest as test } from '../../parallelTest.ts';
import { expect } from '@playwright/test';
import SettingsPage from '../../pages/settings-page.ts';

test.describe.serial( 'Hello Biz Settings - Complete Test Suite', () => {
	test( 'should verify all settings tabs are accessible', async ( { page, apiRequests }, testInfo ) => {
		const settingsPage = new SettingsPage( page, testInfo, apiRequests );

		await settingsPage.gotoSettingsPage();
		await settingsPage.waitForPageLoad();

		const tabs = [
			'SEO and accessibility',
			'Structure and layout',
			'CSS and styling control',
		];

		for ( const tabName of tabs ) {
			const tab = settingsPage.getTab( tabName );
			await expect( tab ).toBeVisible();

			await settingsPage.clickTab( tabName );
			const panel = settingsPage.getTabPanel( tabName );
			await expect( panel ).toBeVisible();
		}
	} );

	test( 'should toggle settings correctly', async ( { page, apiRequests }, testInfo ) => {
		const settingsPage = new SettingsPage( page, testInfo, apiRequests );
		await settingsPage.gotoSettingsPage();
		await settingsPage.waitForPageLoad();

		await settingsPage.clickTab( 'SEO and accessibility' );
		const skipLinksCheckbox = settingsPage.getCheckboxBySetting( 'Disable skip links' );
		const initialSkipLinksState = await skipLinksCheckbox.isChecked();

		await settingsPage.toggleSetting( 'Disable skip links' );
		const newSkipLinksState = await skipLinksCheckbox.isChecked();
		expect( newSkipLinksState ).toBe( ! initialSkipLinksState );

		await settingsPage.clickTab( 'Structure and layout' );
		const headerFooterCheckbox = settingsPage.getCheckboxBySetting( 'Disable theme header and footer' );
		const initialHeaderFooterState = await headerFooterCheckbox.isChecked();

		await settingsPage.toggleSetting( 'Disable theme header and footer' );
		const newHeaderFooterState = await headerFooterCheckbox.isChecked();
		expect( newHeaderFooterState ).toBe( ! initialHeaderFooterState );
	} );

	test( 'should persist settings across page reloads', async ( { page, apiRequests }, testInfo ) => {
		const settingsPage = new SettingsPage( page, testInfo, apiRequests );
		await settingsPage.gotoSettingsPage();
		await settingsPage.waitForPageLoad();

		await settingsPage.clickTab( 'SEO and accessibility' );
		const skipLinksCheckbox = settingsPage.getCheckboxBySetting( 'Disable skip links' );
		const initialState = await skipLinksCheckbox.isChecked();

		await settingsPage.toggleSetting( 'Disable skip links' );
		const stateAfterToggle = await skipLinksCheckbox.isChecked();

		await page.reload();
		await settingsPage.waitForPageLoad();
		await settingsPage.clickTab( 'SEO and accessibility' );

		const stateAfterReload = await skipLinksCheckbox.isChecked();
		expect( stateAfterReload ).toBe( stateAfterToggle );

		await settingsPage.toggleSetting( 'Disable skip links' );
		const finalState = await skipLinksCheckbox.isChecked();
		expect( finalState ).toBe( initialState );
	} );
} );
