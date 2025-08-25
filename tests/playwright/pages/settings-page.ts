import { APIRequestContext, type Page, type TestInfo, expect } from '@playwright/test';
import WpAdminPage from './wp-admin-page.ts';

export default class SettingsPage extends WpAdminPage {
	async gotoSettingsPage(): Promise<void> {
		await this.page.goto( '/wp-admin/admin.php?page=hello-elementor-settings' );
		await this.page.waitForSelector( 'h4:has-text("Advanced theme settings")', { timeout: 10000 } );
	}

	getTab( tabName: string ) {
		return this.page.getByRole( 'tab', { name: tabName } );
	}

	getTabPanel( tabName: string ) {
		return this.page.getByRole( 'tabpanel', { name: tabName } );
	}

	async createNewBasicPost(): Promise<string> {
		const request: APIRequestContext = this.page.context().request,
			postDataInitial = {
				title: 'Playwright Test Page - Uninitialized',
				content: 'This is a test content for the post.',
				status: 'publish' as const,
				excerpt: 'This is a test excerpt that should appear in meta description.',
			},
			postId = await this.apiRequests.create( request, 'pages', postDataInitial ),
			postDataUpdated = {
				title: `Playwright Test Page #${ postId }`,
			};

		await this.apiRequests.create( request, `pages/${ postId }`, postDataUpdated );

		return postId;
	}

	async clickTab( tabName: string ): Promise<void> {
		await this.getTab( tabName ).click();
		await this.page.waitForSelector( `[role="tabpanel"]:visible`, { timeout: 5000 } );
	}

	getCheckboxByIndex( index: number ) {
		return this.page.locator( 'input[type="checkbox"]' ).nth( index );
	}

	getCheckboxBySetting( settingName: string ) {
		const settingMap: { [key: string]: number } = {
			'Disable description meta tag': 0,
			'Disable skip links': 1,
			'Disable theme header and footer': 0,
			'Hide page title': 1,
			'Deregister Hello reset.css': 0,
			'Deregister Hello theme.css': 1,
		};
		return this.page.locator( `input[type="checkbox"]` ).nth( settingMap[ settingName ] || 0 );
	}

	async toggleSetting( settingName: string ): Promise<boolean> {
		const checkbox = this.getCheckboxBySetting( settingName );
		await checkbox.click();
		await this.waitForSaveNotification();
		return await checkbox.isChecked();
	}

	async toggleCheckboxByIndex( index: number ): Promise<boolean> {
		const checkbox = this.getCheckboxByIndex( index );
		await checkbox.click();
		await this.waitForSaveNotification();
		return await checkbox.isChecked();
	}

	async waitForSaveNotification(): Promise<void> {
		await expect( this.page.locator( '[role="alert"]:has-text("Settings Saved")' ).first() ).toBeVisible( { timeout: 5000 } );
	}

	async closeSaveNotification(): Promise<void> {
		const notification = this.page.locator( '[role="alert"]:has-text("Settings Saved")' );
		if ( await notification.isVisible() ) {
			await notification.getByRole( 'button', { name: 'Close' } ).click();
		}
	}

	async openChangelog(): Promise<void> {
		await this.page.getByRole( 'link', { name: 'Changelog' } ).click();
		await expect( this.page.locator( 'h4:has-text("Changelog")' ) ).toBeVisible( { timeout: 5000 } );
	}

	async closeChangelogWithEscape(): Promise<void> {
		await this.page.keyboard.press( 'Escape' );
		await expect( this.page.locator( '[role="dialog"]' ) ).not.toBeVisible( { timeout: 3000 } );
	}

	async closeChangelogByClickingOutside(): Promise<void> {
		await this.page.locator( '[role="dialog"]' ).click( { position: { x: 5, y: 5 } } );
		await expect( this.page.locator( '[role="dialog"]' ) ).not.toBeVisible( { timeout: 3000 } );
	}

	async getChangelogVersions(): Promise<string[]> {
		const versionElements = this.page.locator( 'h6[class*="MuiTypography"]:regex("\\d+\\.\\d+\\.\\d+ - \\d{4}-\\d{2}-\\d{2}")' );
		return await versionElements.allTextContents();
	}

	async hasWarningAlert(): Promise<boolean> {
		return await this.page.locator( '[role="alert"]:has-text("Be Careful")' ).isVisible();
	}

	async getSettingDescription( settingName: string ): Promise<string> {
		const descriptionElement = this.page.locator( `h6:has-text("${ settingName }") ~ * p:has-text("What it does:")` );
		return await descriptionElement.textContent() || '';
	}

	async getSettingTip( settingName: string ): Promise<string> {
		const tipElement = this.page.locator( `h6:has-text("${ settingName }") ~ * p:has-text("Tip:")` );
		return await tipElement.textContent() || '';
	}

	async getSettingCode( settingName: string ): Promise<string> {
		const codeElement = this.page.locator( `h6:has-text("${ settingName }") ~ * code` );
		return await codeElement.textContent() || '';
	}

	async waitForPageLoad(): Promise<void> {
		await this.page.waitForSelector( 'h4:has-text("Advanced theme settings")', { timeout: 10000 } );
		await this.page.waitForSelector( '[role="tablist"]', { timeout: 5000 } );
		await this.page.waitForSelector( '[role="tabpanel"]:visible', { timeout: 5000 } );
		await this.page.waitForTimeout( 1000 );
	}

	async resetToDefaults(): Promise<void> {
		const tabs = [
			'SEO and accessibility',
			'Structure and layout',
			'CSS and styling control',
		];

		for ( const tabName of tabs ) {
			await this.clickTab( tabName );

			const checkboxes = this.page.locator( 'input[type="checkbox"]' );
			const count = await checkboxes.count();

			for ( let i = 0; i < count; i++ ) {
				const checkbox = checkboxes.nth( i );
				const isChecked = await checkbox.isChecked();

				let shouldBeChecked = false;
				if ( 'Structure and layout' === tabName && 1 === i ) {
					shouldBeChecked = true;
				}

				if ( isChecked !== shouldBeChecked ) {
					await checkbox.click();
					await this.waitForSaveNotification();
				}
			}
		}
	}
}
