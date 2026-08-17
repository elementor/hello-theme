import { parallelTest as test } from '../parallelTest.ts';
import { expect } from '@playwright/test';
import WpAdminPage from '../pages/wp-admin-page.ts';

test.describe('Admin Menu', () => {
	test('Hello Elementor menu exists in sidebar with correct name', async ({
		page,
		apiRequests,
	}, testInfo) => {
		const wpAdmin = new WpAdminPage(page, testInfo, apiRequests);

		await wpAdmin.gotoDashboard();

		const helloElementorMenu = page.locator('#toplevel_page_hello-elementor');

		await expect(helloElementorMenu).toBeVisible();

		const menuTitle = helloElementorMenu.locator('.wp-menu-name');
		await expect(menuTitle).toHaveText('Hello');
	});

	test('redirects hello-elementor page to settings', async ({ page }) => {
		await page.goto('/wp-admin/admin.php?page=hello-elementor');

		await expect(page).toHaveURL(/page=hello-elementor-settings/);
	});

	test('does not show submenu items', async ({
		page,
		apiRequests,
	}, testInfo) => {
		const wpAdmin = new WpAdminPage(page, testInfo, apiRequests);

		await wpAdmin.gotoDashboard();

		const helloMenu = page.locator('#toplevel_page_hello-elementor');
		await helloMenu.hover();

		await expect(helloMenu.locator('.wp-submenu li')).toHaveCount(0);
	});
});
